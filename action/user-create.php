<?php
if (isset($_POST['form_signup'])) {
  require_once('db-connection.php');
  
  // clear session first
  
  $username = mysqli_real_escape_string( $conn, strip_tags(trim($_POST['username'])) );
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $email = mysqli_real_escape_string($conn, strip_tags(trim($_POST['email'])) );
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  // yyyy-mm-dd
  $birthdate = $_POST['birth_year'].'-'.$_POST['birth_month'].'-'.$_POST['birth_day'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  
  // check if confirm password matches
  
  $is_password_match = $password == $confirm_password;
  
  // use this to hash passwords to insert in database
  // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
  $query = "
    SELECT username FROM users
    WHERE username = '$username' OR email = '$email'
  ";
  
  $query_result = $conn->query($query);
  // if no same username or email
  if ($query_result->num_rows == 0 && $is_password_match) {
    // create verification code
    $verification_code = md5(uniqid(rand(), true));

    // prepare and bind
    $query = "
      INSERT INTO users(
        username, password, email,
        fname, lname, birthdate,
        gender, address, contact,
        type, status, verification_code
      ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'normal', '2', '$verification_code');
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssss",
      $username, $hashed_password, $email,
      $fname, $lname, $birthdate,
      $gender, $address, $contact);

    // set parameters and execute
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    require_once('send-verification.php');
    
    $stmt->execute();

    // set message
    setcookie('msg_account_created', 1, time()+60, '/');
    
    // close statement
    $stmt->close();

    // redirect to index
    header('location: ./');
  }
  // check if username is taken
  else {
    $query = "SELECT username FROM users WHERE username = '$username'";
    $query_result = $conn->query($query);

    // if username exists, error
    if ($query_result->num_rows > 0)
      setcookie('msg_duplicate_username', 1, time()+60, '/');
    
    $query = "SELECT username FROM users WHERE email = '$email'";
    $query_result = $conn->query($query);
    
    // if duplicate email
    if ($query_result->num_rows > 0)
      setcookie('msg_duplicate_email', 1, time()+60, '/');
    
    // if password do not match
    if (!$is_password_match)
      setcookie('msg_password_mismatch', 1, time()+60, '/');
    
    session_start();

    // save posted values to session here to retain info in form
    foreach ($_POST as $key => $value) {
      $_SESSION[$key] = $value;
    }
    
    $_SESSION['repost'] = true;
    
    // redirect to sign up form
    // header("Location: http://{$_SERVER['HTTP_HOST']}/lib/html/form-signup.php");
    header("Location: ../signup.php");
  }
  
  // close connection
  $conn->close();
}


?>