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
  <nav class="header navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= $home; ?>">Q MANAGEMENT</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?= $home; ?>">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $login.'index.php?signup=false'; ?>">Login (temp)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $login.'index.php?signup=true'; ?>">Sign Up (temp)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $login.'logout.php'; ?>">Logout (temp)</a>
        </li>

      </ul>
      <!--
      <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    -->
    </div>
  </nav>
</header>
