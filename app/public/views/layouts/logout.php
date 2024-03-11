<?php

  if (isset($_COOKIE[user()])) {
    setcookie(user(), 1, time() - 3600, '/');
  }

  header('location: ' . user() . '-login');

?>