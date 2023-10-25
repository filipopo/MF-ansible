<?php
  $title = 'MF statistics';
  include 'includes/b.php';

  include 'includes/kofi.php';
  include 'includes/db.php';
  $net = (float)executeParams(
    'SELECT SUM(amount_received) - (SELECT (JULIANDAY("now") - JULIANDAY(?)) / 30 * ?) FROM donations',
    [kofi_startdate, kofi_target]
  )->fetchArray()[0];
?>
  MF is worth <?= $net ?> EUR
</body>
</html>