<?php

  require_once("./db.php");
  require_once("./functions.php");
  session_start();

  // If user is not active log them out
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    $inactive = 3600; // 1 hour in seconds
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
      header("Location: ./login/logout.php");
      // logged out
    }
    $_SESSION['timeout'] = time();
  }

  // Header file includes <head> items and css
  include("./template/header.php");
?>

<div class="title">
  <div class="container">
    <h1> Q Management App </h1>
  </div>
  <hr>
</div>


  <div id="content">
  <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
          require("./admin_page.php");
        } else {
          if (isset($_SESSION['schedule']) && $_SESSION['schedule'] != 0) {
            require("./show_schedule.php");
          } else {
            printSelectSection();
          }
        }
    } else {
      echo '<div class="container">';
        echo '<div class="jumbotron">';
          echo '<h2> Please Log In To Continue</h2>';
          echo '<hr class="my-4">';
          echo '<div class="row justify-content-md-center">';
            echo '<a class="btn btn-primary btn-md mr-4" href="./login/index.php?signup=false" role="button">Login</a>';
            echo '<a class="btn btn-primary btn-md ml-4" href="./login/index.php?signup=true" role="button">Sign Up</a>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    }
  ?>
</div>


<?php include("./template/footer.php"); ?>
