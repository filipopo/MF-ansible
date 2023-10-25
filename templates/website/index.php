<?php 
  $title = 'Mobile Forces website';
  include 'includes/b.php';

  include 'includes/kofi.php';
  include 'includes/db.php';

  $balance = (float)executeParams(
    'SELECT SUM(amount_received) FROM donations WHERE year=? and month=?',
    [date('Y'), date('n')]
  )->fetchArray()[0];
  $donations = $db->query('SELECT time, day, month, year, name, message, amount_sent FROM donations LIMIT 10');
?>
  <div class="big left">
    Join the Discord server!<br>
    <a href="https://discord.gg/xPcFh7E">discord.gg/xPcFh7E</a><br>
    <br>
    Support MF!<br>
    <iframe id="kofiframe" src="https://ko-fi.com/<?= kofi_name ?>/?hidefeed=true&widget=true&embed=true&preview=true" style="width:400px;padding:4px;background:#f9f9f9;" height="562px" title="<?= kofi_name ?>"></iframe>
  </div>
  <div class="small right">
    Balance for <?= sprintf('%s %d', date('F'), date('Y')) ?><br>
    <?= $balance ?> / <?= kofi_target ?> EUR
    <ul>
      <?php while ($row = $donations->fetchArray()): ?>
        <li>
          <?= sprintf('%d/%d/%d %s', $row['day'], $row['month'], $row['year'], $row['time']) ?><br>
          <?= $row['name'] ?> donated <?= $row['amount_sent'] ?> EUR
          <?php if($row['message']): ?>
            with the following message: <?= $row['message'] ?>
          <?php endif; ?>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
  The amount(s) above include the transfer fee which is around 3% + 0.30 EUR
</body>
</html>