<?php 
  $title = 'Mobile Forces website';
  include 'includes/php/body.php';

  include 'includes/php/kofi.php';
  include 'includes/php/db.php';

  $balance = (float)executeParams(
    'SELECT SUM(amount_received) FROM donations WHERE year=? and month=?',
    [date('Y'), date('n')]
  )->fetchArray()[0];
  $donations = $db->query('SELECT time, day, month, year, name, message, amount_sent FROM donations ORDER BY id DESC LIMIT 10');
?>
  <div class="grid-container">
    <div class="grid-item a">
      Join the <a href="https://discord.gg/xPcFh7E">Discord server</a> and support MF!<br>
      <br>
      <iframe id="kofiframe" src="https://ko-fi.com/<?= kofi_name ?>/?hidefeed=true&widget=true&embed=true&preview=true" style="width:400px;padding:4px;background:#f9f9f9;" height="562px" title="<?= kofi_name ?>"></iframe><br>
      One time donations are better, source: <a href="https://help.ko-fi.com/hc/en-us/articles/360002506494-Does-Ko-fi-Take-a-Fee-#01H841GJ8PJb1PXY64231CFHB">Ko-fi fees</a>
    </div>
    <div class="grid-item b">
      <b>Mobile Forces</b> is a first-person shooter video game developed by Rage Software using the Unreal Engine and published by Majesco Entertainment, the game has eight different game modes:<br>
      <br>
      <b>Deathmatch</b> - The goal of this game style is to eliminate all players in the map.<br>
      <b>Team Deathmatch</b> - Similar to Deathmatch, only played in teams - Red and Blue.<br>
      <b>Captains</b> - In this game mode each team gets a captain and it is needed to kill opposing team's leader in order to score a point.<br>
      <b>Capture the flag</b> - In this game type both teams have to steal each other's flags in order to win.<br>
      <b>Holdout</b> - In this game mode both teams are tasked with capturing a single beacon on a map, the team that holds the beacon a set time or the longest wins.<br>
      <b>Detonation</b> - In this game style members of both sides scramble to acquire a keycard located centrally in the map, which must then be taken to a console in the opposing team's base to activate an explosive device to score.<br>
      <b>Safe Cracker</b> - This game type involves the infiltration of the enemy team's base where it is needed to open the safe and retrieve the loot. After the match attackers and defenders switch between each other.<br>
      <b>Trailer</b> - The use of vehicles is integral to success in this team game style, requiring players to drive explosive-laden units into the base of their opponents in order to get points.<br>
      <img width="418px" src="/includes/images/mobile-forces.jpg" alt="Mobile Forces">
    </div>
    <div class="grid-item c">
      Balance for <?= sprintf('%s %d', date('F'), date('Y')) ?>: <?= $balance ?> / <?= kofi_target ?> <?= kofi_currency ?>
      <script src="/includes/js/css_random.js"></script>
      <ul>
        <?php while ($row = $donations->fetchArray()): ?>
        <li>
          <?= sprintf('%02d/%02d/%d %s', $row['day'], $row['month'], $row['year'], $row['time']) ?><br>
          <?= $row['name'] ?> donated <?= $row['amount_sent'] ?> <?= kofi_currency ?><?php if($row['message']): ?>: <?= $row['message'] ?><?php endif; ?>
        </li>
        <?php endwhile; ?>
      </ul>
      The amount(s) above include the transfer fee which is around 3% + 0.3 <?= kofi_currency ?>, the time zone is <?= date_default_timezone_get() ?><br>
      <br>
      This server has been up since <?= date_format(date_create(kofi_startdate), "d/m/Y H:i:s") ?>
    </div>
  </div>
</body>
</html>