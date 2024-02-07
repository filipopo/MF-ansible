<?php
  if (!isset($_POST['data']))
    die();

  if ($file = fopen('donation_log.txt', 'a')) {
    fwrite($file, sprintf("%s %s\n", date(DATE_RFC2822), $_POST['data']));
    fclose($file);
  }

  include 'includes/php/kofi.php';
  $_POST['data'] = json_decode($_POST['data'], true);
  
  if (hash_equals(kofi_token, $_POST['data']['verification_token'])) {
    $date = date_parse($_POST['data']['timestamp']);
    $amount_received = $_POST['data']['amount'];

    include 'includes/php/db.php';
    executeParams(
      'INSERT INTO donations (time, day, month, year, name, message, amount_sent, amount_received) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
      [
        sprintf('%02d:%02d:%02d', $date['hour'], $date['minute'], $date['second']),
        $date['day'],
        $date['month'],
        $date['year'],
        $_POST['data']['from_name'],
        $_POST['data']['message'],
        $_POST['data']['amount'],
        $amount_received
      ]
    );
  }
?>