<?php
  include '../includes/variables.php';
  if (isset($_POST['password']) && hash_equals(cookiePassword, $_POST['password'])) {
    setcookie(cookieName, encryptedPasssword, time()+3600, httponly: true);
    header('Location: /admin');
    die();
  }

  $title = 'Admin page login';
  include '../includes/b.php';
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