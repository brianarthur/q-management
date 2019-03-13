<!DOCTYPE html>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php
		$current = ($_SERVER['PHP_SELF']);
		if ($current == '/q-management/index.php') {
			echo '<link rel="stylesheet" type="text/css" href="index_css.css">';
		}
		elseif ($current == '/q-management/login/index.php') {
			echo '<link rel="stylesheet" type="text/css" href="signin_css.css">';
			echo '<title>Login</title>';
		}
	?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">


</head>
<body>

	<?php
		$current = ($_SERVER['PHP_SELF']);
		if ($current == '/q-management/index.php') {
			require('./template/nav.php');
		}
		elseif ($current == '/q-management/login/index.php') {
			require('../template/nav.php');
		}
	?>
