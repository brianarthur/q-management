<?php

// Check $_POST variables first
if(isset($_POST['email']) && !empty($_POST['email']) AND
    isset($_POST['firstName']) && !empty($_POST['firstName']) AND
    isset($_POST['lastName']) && !empty($_POST['lastName']) AND
    isset($_POST['password']) && !empty($_POST['password'])
){

  // Set the session variables
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['first_name'] = $_POST['firstName'];
  $_SESSION['last_name'] = $_POST['lastName'];

  // Escape all $_POST varaible to protect from SQL injections
  $first_name = $mysqli->escape_string($_POST['firstName']);
  $last_name = $mysqli->escape_string($_POST['lastName']);
  $email = $mysqli->escape_string($_POST['email']);
  $password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
  $hash = $mysqli->escape_string(md5(rand(0,1000)));

  // Check if user with email exists
  $result = $mysqli->query("SELECT * FROM user WHERE email = '$email'") or die($mysqli->error);

  if($result->num_rows > 0) {
    $_SESSION['message'] = "Email is already in use.";
  }
  else {
    $sql = "INSERT INTO user (`firstName`, `lastName`, `email`, `password`, `hash`)
      VALUES ('$first_name', '$last_name', '$email', '$password', '$hash')";

    if($mysqli->query($sql)) {
      // get the id of newest user
      $result = $mysqli->query("SELECT LAST_INSERT_ID();");
      $result = $result->fetch_assoc();
      $_SESSION['id'] = $result['LAST_INSERT_ID()'];

      // user is logged in
      $_SESSION['active'] = 0;
      $_SESSION['logged_in'] = true;
      $_SESSION['alert'] = "Confrimation email sent to '$email' (should make a page for this)";
      $_SESSION['schedule'] = 0;
      $_SESSION['timeout'] = time();

      // Send registration confirmation link
      // TODO need to verify how server will send emails
      require('../mail.php');
      $mail->setFrom('q-management@queensu.case', 'Q Management');
      $mail->addAddress($email, $first_name.' '.$last_name);
      $mail->Subject = 'Q-Management Sign Up';
      $mail->Body = '
      Hello '.$first_name.',

      Thank you for signing up for Q Management!

      Please use this link to activate your account:

      http://localhost/q-management/login/verify.php?email='.$email.'&hash='.$hash.'

      The Q-Management Team';

      if (!$mail->send()) {
        echo $mail->ErrorInfo;
      } else {
        header("Location: index.php");
      }
    }
  }
}
else {
  header("location: index.php");
}

?>
