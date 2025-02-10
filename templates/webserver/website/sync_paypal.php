<?php
  $dir = strrpos($argv[0], '/');
  $dir = $dir ? substr($argv[0], 0, $dir) : '.';
  $db = new SQLite3($dir . '/var/app.db');

  $donations = $db->query('SELECT id, kofi_tx FROM donation WHERE amount_sent=amount_received');
  $donation = $donations->fetchArray();

  if (!$donation) {
    die();
  }

  function sendRequest($url, $method, $headers, $data = [], $basicAuth = null) {
    if (isset($basicAuth)) {
      array_push($headers, 'Authorization: Basic ' . base64_encode($basicAuth));
    }

    $options = [
      'http' => [
        'header' => $headers,
        'method' => $method,
        'content' => http_build_query($data),
      ]
    ];

    $context = stream_context_create($options);
    return file_get_contents($url, false, $context);
  }

  session_start();
  if (!isset($_SESSION['expires_in']) || time() >= ($_SESSION['expires_in'] - 1)) {
    $res = sendRequest(
      'https://api-m.paypal.com/v1/oauth2/token',
      'POST',
      ['Content-type: application/x-www-form-urlencoded'],
      ['grant_type' => 'client_credentials'],
      basicAuth: sprintf('%s:%s', getenv('PAYPAL_CLIENTID'), getenv('PAYPAL_SECRETKEY'))
    );

    if (!$res) {
      die();
    }

    $res = json_decode($res, true);
    $_SESSION['access_token'] = $res['access_token'];
    $_SESSION['expires_in'] = strtotime(sprintf('+%s second', $res['expires_in']));
  }

  // A transaction takes up to 3 hours to get into the list this API calls
  $query = [
    'start_date' => date(DATE_RFC3339, strtotime('now - 1 day - 3 hour')),
    'end_date' => date(DATE_RFC3339),
  ];

  $res = sendRequest(
    'https://api-m.paypal.com/v1/reporting/transactions?' . http_build_query($query),
    'GET',
    ['Content-Type: application/json', 'Authorization: Bearer ' . $_SESSION['access_token']]
  );

  if (!$res) {
    die();
  }

  $res = json_decode($res, true);
  foreach ($res['transaction_details'] as $transaction) {
    if ($transaction['transaction_info']['invoice_id'] === $donation['kofi_tx']) {
      $amount_received = $transaction['transaction_info']['transaction_amount']['value'] + $transaction['transaction_info']['fee_amount']['value'];

      $db->exec(sprintf(
        'UPDATE donation SET amount_received=%s WHERE id=%s',
        $amount_received, $donation['id']
      ));

      $donation = $donations->fetchArray();
      if (!$donation) {
        break;
      }
    }
  }
