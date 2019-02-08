<?php


if(isset($_POST['email']) && !empty($_POST['email']) AND
    isset($_POST['email']) && !empty($_POST['email'])
){

  $email = $mysqli->escape_string($_POST['email']);
  $result = $mysqli->query("SELECT * FROM user WHERE email = '$email'") or die($mysqli->error);

  if ($result->num_rows == 0) {
    $_SESSION['message'] = "Incorrect username or password.";
  }
  else {
    $user = $result->fetch_assoc();

    if (password_verify($_POST['password'], $user['password'])) {
      $_SESSION['email'] = $user['email'];
      $_SESSION['first_name'] = $user['firstName'];
      $_SESSION['last_name'] = $user['lastName'];
      $_SESSION['active'] = $user['active'];
      $_SESSION['logged_in'] = true;

      header("location: index.php");

    }
    else {
      $_SESSION['message'] = "Incorrect username or password.";
    }


  }
}
else {
  header("location: index.php");
}
?>