<?php
  $title = 'MF statistics';
  include 'includes/php/body.php';

  include 'includes/php/kofi.php';
  include 'includes/php/db.php';

  $sum = (float)$db->querySingle('SELECT SUM(amount_received) FROM donations');
  $donators = $db->query('SELECT SUM(amount_sent) as amount, COUNT(*) as times, name FROM donations GROUP BY name ORDER BY amount DESC, times DESC LIMIT 10');
  //$donation_activity = $db->query('SELECT SUM(amount_received) as amount, month, year FROM donations GROUP BY year, month ORDER BY year, month');
?>
  A total of <?= $sum ?> <?= kofi_currency ?> in donations was received for MF<br>
  Approximate net balance: <?= $sum - (microtime(true) - strtotime(kofi_startdate)) / 86400 / 30 * kofi_target ?> <?= kofi_currency ?><br>
  <br>
  Top 10 donators:
  <script src="/includes/js/css_random.js"></script>
  <ul style="padding-left: 10px;">
    <?php while ($row = $donators->fetchArray()): ?>
    <li>
      <?= $row['name'] ?> donated <?= $row['amount'] ?> <?= kofi_currency ?> over <?= $row['times'] ?> donation(s)
    </li>
    <?php endwhile; ?>
  </ul>
  The amount(s) above include the transfer fee which is around 3% + 0.3 <?= kofi_currency ?>
</body>
</html>