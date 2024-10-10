<!DOCTYPE html>
<html lang="en">
<head>
  <title><?= $title ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/includes/css/<?= isset($css) ? $css : 'style.css' ?>">
</head>
<body>
<nav class="nav-top">
  <a class="nav-link" href="/">Home</a>
  <a class="nav-link" href="/stats.php">Statistics</a>
  <a class="nav-link" href="/admin">Admin</a>
</nav>
