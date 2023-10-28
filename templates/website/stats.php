<?php
  $title = 'MF statistics';
  include 'includes/php/body.php';

  include 'includes/php/kofi.php';
  include 'includes/php/db.php';
  $sum = (float)$db->querySingle('SELECT SUM(amount_received) FROM donations');
?>
  A total of <?= $sum ?> <?= kofi_currency ?> has been donated for MF<br>
  Net balance: ~<?= $sum - (microtime(true) - strtotime(kofi_startdate)) / 86400 / 30 * kofi_target ?> <?= kofi_currency ?>
</body>
</html>