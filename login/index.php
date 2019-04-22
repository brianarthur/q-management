<?php
  require("../db/db.php");
  session_start();

  // Header file includes <head> items and css
  include("../template/header.php");

  // Redirect user if they are logged in
  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header("location: ../index.php");
  }

  // If clicked signup button from home page - set the method variable
  if(isset($_GET['signup'])) {
    if($_GET['signup'] == 'true') {
      $_SESSION['method'] = "register";
    }
    elseif($_GET['signup'] == 'false') {
      $_SESSION['method'] = "login";
    }
  }

  // Set the default method to load content
  if(empty($_SESSION['method'])) {
    $_SESSION['method'] = "login";
  }

  // If form is submitted run either login or register script
  if ($_SERVER['REQUEST_METHOD']) {
    if(isset($_POST["login"])) {
      require('./login.php');
      $_SESSION['method'] = "login";
    }
    elseif(isset($_POST["register"])) {
      require('./register.php');
      $_SESSION['method'] = "register";
    }
  }

  //print_r($_SESSION);

?>


<div id='content'>
  <div class='row justify-content-md-center'>
    <div class='col-sm-4'>
      <ul class="nav nav-pills nav-fill mb-4" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link <?php if($_SESSION['method'] == "register") echo "active"; ?>" data-toggle="pill" href="#signup">Signup</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($_SESSION['method'] == "login") echo "active"; ?>" data-toggle="pill" href="#login">Login</a>
        </li>
      </ul>
    </div>
  </div>
    <div class="tab-content" id="pills-tabContent">
      <div id="login" class="tab-pane fade <?php if($_SESSION['method'] == "login") echo "show active"; ?>" role="tabpanel">
        <form class="form-signin" action="index.php" method="POST" autocomplete="off">
          <img class="mt-4 mb-4" src="https://upload.wikimedia.org/wikipedia/en/thumb/7/70/QueensU_Crest.svg/1200px-QueensU_Crest.svg.png" alt="" width="70" height="90">
          <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
          <?php
            if(isset($_SESSION['message']) && $_SESSION['method'] == "login") {
              echo "<div class='mb-4 errors'>";
                echo $_SESSION['message'];
              echo "</div>";
              unset($_SESSION['message']);
            }
          ?>
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus value="<? echo $_SESSION['email'];?>">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
          <!--<div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>-->
          <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
          <!--<p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>-->
        </form>
      </div>
      <div id="signup" class="tab-pane fade <?php if($_SESSION['method'] == "register") echo "show active"; ?>" role="tabpanel">
        <form class="form-signin" action="index.php" method="POST" autocomplete="off">
        <img class="mt-4 mb-4" src="https://upload.wikimedia.org/wikipedia/en/thumb/7/70/QueensU_Crest.svg/1200px-QueensU_Crest.svg.png" alt="" width="70" height="90">
        <h1 class="h3 mb-3 font-weight-normal">Sign Up</h1>
        <?php
          if(isset($_SESSION['message']) && $_SESSION['method'] == "register") {
            echo "<div class='mb-4 errors'>";
              echo $_SESSION['message'];
            echo "</div>";
            unset($_SESSION['message']);
          }
        ?>
        <label for="firstName" class="sr-only">First Name</label>
        <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" required autofocus>
        <label for="lastName" class="sr-only">Last Name</label>
        <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name" required>
        <label for="r_inputEmail" class="sr-only">Email address</label>
        <input type="email" id="r_inputEmail" name="email" class="mt-3 form-control" placeholder="Email address" required>
        <label for="r_inputPassword" class="sr-only">Password</label>
        <input type="password" id="r_inputPassword" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" name="register" type="submit">Sign up</button>
        </form>
      </div>
    </div>
</div>

<?php include("../template/footer.php"); ?>
