<?php
  include '../includes/php/cookies.php';

  function check_hashes($base, $hash_array) {
    foreach ($hash_array as $hash) {
      if (!password_verify($base, $hash))
        return false;
    }

    return true;
  }

  if (!isset($_COOKIE[cookieName]) || !check_hashes(cookiePassword, [cookieEncrypted, $_COOKIE[cookieName]])) {
    header('Location: /admin/login.php');
    die();
  }

  // Refresh cookie
  setcookie(cookieName, cookieEncrypted, time()+3600, httponly: true);

  $title = 'Admin page';
  $css = 'admin.css';
  include '../includes/php/body.php';

  foreach (new DirectoryIterator(getcwd()) as $file) {
    if ($file->isDir() && str_starts_with($file->getFilename(), 'elFinder-')) {
      $elFinder = $file->getFilename();
      break;
    }
  }
?>
  <div class="small" style="float: left;">
    Welcome to the admin panel, to get started use the file manager or choose the actions you want to do:
    <form method="POST">
      <input type="checkbox" id="restart" name="restart">
      <label for="restart">Restart server</label><br>
      <input type="checkbox" id="fastdl" name="fastdl">
      <label for="fastdl">Compress files for FastDL</label><br>
      <br>
      <button class="btn btn-secondary" type="submit">Submit</button>
    </form>
    <?php
      if (count($_POST))
        echo '<br>';

      if(isset($_POST['restart'])) {
        system('systemctl restart mobileforces');
        echo 'Ran server restart command<br>';
      }

      if(isset($_POST['fastdl'])) {
        system('systemctl start mobileforces-fastdl');
        echo 'Ran command to compress files for FastDL<br>';
      }
    ?>
  </div>
  <iframe class="big" title="File Manager" style="float: right;height:450px;" src="/admin/<?= $elFinder ?>/elfinder.html"></iframe> 
</body>
</html>