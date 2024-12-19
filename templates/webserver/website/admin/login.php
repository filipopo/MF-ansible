<?php
  include '../includes/php/cookies.php';
  if (isset($_POST['password']) && hash_equals(cookiePassword, $_POST['password'])) {
    setcookie(cookieName, cookieEncrypted, time()+3600, httponly: true);
    header('Location: /admin');
    die();
  }

  $title = 'Admin page login';
  $css = 'admin.css';
  include '../includes/php/body.php';
?>
  Enter Password:
  <form method="POST">
  <input type="password" name="password"><br/>
  <br/>
  <button class="btn btn-secondary" type="submit">Login</button>
  </form>
  <?php if (isset($_POST['password'])): ?>
  Wrong password
  <?php endif; ?>
</body>
</html>
