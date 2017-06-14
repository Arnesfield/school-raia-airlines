<?php
if (isset($_POST['form_login'])) {
  require_once('db-connection.php');

  $username = mysqli_real_escape_string( $conn, strip_tags(trim($_POST['username'])) );
  $password = mysqli_real_escape_string( $conn, strip_tags($_POST['password']) );
  
  // use this to hash passwords to insert in database
  // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
  $query = "
    SELECT id, username, password, type, status
    FROM users
    WHERE username = '$username'
  ";
  
  $query_result = $conn->query($query);
  
  // echo "<script>alert('Invalid Credentials')</script>";
  
  // to get row data from query_result
  $user_record = $query_result->fetch_assoc();
  
  // hashed password is in database
  $hashed_password = $user_record['password'];
  $verified = password_verify($password, $hashed_password);
  
  // to check if there are rows fetch based on the query
  if ($query_result->num_rows == 1 && $verified) {
    // if status is 2, ask to verify account first
    if ($user_record['status'] == '2') {
      setcookie('msg_verify_first', 1, time()+60, '/');
      header('location: ./');
      exit();
    }

    session_start();

    // to assign session data
    $_SESSION['user_id'] = $user_record['id']; 
    
    // to assign session time
    // $_SESSION['session_time'] = time();
    
    // to assign session timeout to 30mins 3600/2
    // $_SESSION['session_timeout'] = 900;

    setcookie('has_session', 1, time()+1800, '/');

    // set type of user
    $_SESSION['is_admin'] = $user_record['type'] == 'admin';
    
    // to assign session data
    $_SESSION['is_logged_in'] = true;

    // message
    // $_COOKIE['msg_is_logged_in'] = true;
    setcookie('msg_is_logged_in', 1, time()+60, '/');
  }
  // invalid credentials
  else {
    // $_COOKIE['msg_invalid_login'] = true;
    setcookie('msg_invalid_login', 1, time()+60, '/');
  }
  
  // close connection
  $conn->close();
}

// redirect to index.php
header('location: ./');

?>