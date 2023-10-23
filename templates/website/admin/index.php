<?php
  include "../includes/variables.php";

  function check_hashes($base, $hash_array) {
    foreach ($hash_array as $hash) {
      if (!password_verify($base, $hash))
        return false;
    }

    return true;
  }

  if (!isset($_COOKIE[cookieName]) || !check_hashes(cookiePassword, [encryptedPasssword, $_COOKIE[cookieName]])) {
    header("Location: /admin/login.php");
    die();
  }

  $title = "Admin page";
  include "../includes/b.php";

  foreach (new DirectoryIterator(getcwd()) as $file) {
    if ($file->isDir() && str_starts_with($file->getFilename(), "elFinder-")) {
      $elFinder = $file->getFilename();
      break;
    }
  }
?>
  <div class="small left">
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
        echo "<br>";

      if(isset($_POST["restart"])) {
        system("systemctl restart mobileforces");
        echo "Ran server restart command<br>";
      }

      if(isset($_POST["fastdl"])) {
        system("sh {{ game_path }}/System/compress.sh");
        echo "Ran command to compress files for FastDL<br>";
      }
    ?>
  </div>
  <iframe class="big right" title="File Manager" style="height: 100%;" src="/admin/<?= $elFinder ?>/elfinder.html"></iframe> 
</body>
</html>