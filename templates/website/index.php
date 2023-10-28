<?php 
  $title = 'Mobile Forces website';
  include 'includes/php/body.php';

  include 'includes/php/kofi.php';
  include 'includes/php/db.php';

  $balance = (float)executeParams(
    'SELECT SUM(amount_received) FROM donations WHERE year=? and month=?',
    [date('Y'), date('n')]
  )->fetchArray()[0];
  $donations = $db->query('SELECT time, day, month, year, name, message, amount_sent FROM donations LIMIT 10');
?>
  <div class="big left">
    Join the <a href="https://discord.gg/xPcFh7E">Discord server</a> and support MF!<br>
    <br>
    <iframe id="kofiframe" src="https://ko-fi.com/<?= kofi_name ?>/?hidefeed=true&widget=true&embed=true&preview=true" style="width:400px;padding:4px;background:#f9f9f9;" height="562px" title="<?= kofi_name ?>"></iframe><br>
    One time donations are better, source: <a href="https://help.ko-fi.com/hc/en-us/articles/360002506494-Does-Ko-fi-Take-a-Fee-#01H841GJ8PJH21PXY64231CFHB">Ko-fi fees</a>
  </div>
  <div class="small right">
    Balance for <?= sprintf('%s %d', date('F'), date('Y')) ?><br>
    <?= $balance ?> / <?= kofi_target ?> <?= kofi_currency ?>
    <script src="/includes/js/css_random.js"></script>
    <ul>
      <?php while ($row = $donations->fetchArray()): ?>
      <li>
        <?= sprintf('%02d/%02d/%d %s', $row['day'], $row['month'], $row['year'], $row['time']) ?><br>
        <?= $row['name'] ?> donated <?= $row['amount_sent'] ?> <?= kofi_currency ?>
        <?php if($row['message']): ?>
        with the message: <?= $row['message'] ?>
        <?php endif; ?>
      </li>
      <?php endwhile; ?>
    </ul>
    The amount(s) above include the transfer fee which is around 3% + 0.3 <?= kofi_currency ?><br>
  </div>
  <br>
  This server has been up since <?= date_format(date_create(kofi_startdate), "d/m/Y H:i:s") ?>
</body>
</html>