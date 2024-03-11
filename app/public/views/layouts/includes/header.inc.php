<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Examination Portal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['SERVER_NAME']; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="http://<?= $_SERVER['SERVER_NAME']; ?>/assets/css/style.css?v=7567787687">
    <script src="assets/js/<?= user() ?>.js"></script>
  </head>
  <body>

    <?php

      if (user() == 'examdep') {
        echo '<script src="http://examdep.unisa.ac.za/assets/js/charts/Chart.min.js"></script>';
      }

    ?>