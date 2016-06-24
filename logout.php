<?php
  $pass = time() - 100;
  // this make the time in the past to destroy the cookie
  setcookie('UID', gone, $past, '', $_SERVER['SERVER_NAME']);
  setcookie('PWD', gone, $past, '', $_SERVER['SERVER_NAME']);
  header("Location: login.php");
?>