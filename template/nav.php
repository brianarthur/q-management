<?php
  $dir = dirname($_SERVER['PHP_SELF']);
  if ($dir == "/q-management") {
    $home = './';
    $login = './login/';
  }
  elseif($dir == "/q-management/login") {
    $home = '../';
    $login = './';
  }
?>

<header>
  <nav class="header navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="<?= $home; ?>">Q MANAGEMENT</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?= $home; ?>">Home<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
        <?php
          if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            echo '<li class="nav-item navbar-text mr-3">';
              echo 'Hello, '.$_SESSION['first_name'];
            echo '</li>';
            echo '<li class="nav-item">';
              echo '<a class="nav-link" href="'.$login.'logout.php">Logout</a>';
            echo '</li>';
          }
          else {
            echo '<li class="nav-item">';
              echo '<a class="nav-link" href="'.$login.'index.php?signup=false">Login</a>';
            echo '</li>';
            echo '<li class="nav-item">';
              echo '<a class="nav-link" href="'.$login.'index.php?signup=true">Sign Up</a>';
            echo '</li>';
          }
        ?>
      </ul>
    </div>
  </nav>
</header>
