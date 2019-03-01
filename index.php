<?php

  require("./db.php");
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



<?php
  /* TODO possibly? currently not working
  if (isset($_SESSION['alert'])) {
    echo '<div class="container">';
      echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
        echo $_SESSION['alert'];
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
          echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
      echo '</div>';
    echo '</div>';
    unset($_SESSION['alert']);
  }
  */
?>


  <div id="content">
  <?
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      if (isset($_SESSION['schedule']) && $_SESSION['schedule'] != 0) {
        require("./show_schedule.php");
      } else {
        echo '<div class="container">';
          echo '<div class="jumbotron">';
            echo '<h2> Select your schedule number: </h2>';
            echo '<hr class="my-4">';
            echo '<div class="row justify-content-md-center">';
            if ($query = $pdo->prepare("SELECT * FROM `schedule` WHERE `type` = '0'")) {
                $query->execute();
                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo '<a class="btn btn-primary btn-sm mr-4" href="./add_schedule.php?s='.$result['id'].'" role="button">Section '.$result['section_number'].'</a>';
                }
            }
            else {
                $error = $query->errorInfo();
                echo "My SQL Error: " . $error;
                return false;
            }
            echo '</div>';
          echo '</div>';
        echo '</div>';
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
