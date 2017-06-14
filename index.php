<?php
$head_title = "RAIA Airlines";
require_once('markup/top.php');
require_once('action/header.php');
?>

<?php
session_start();

// do show login form
$show_login = true;

// if invalid login
if (isset($_COOKIE['msg_invalid_login'])) {
  // show message
  $msg = "Invalid username and password.";
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_invalid_login', 0, time()-60, '/');
}

// if session expired
if (isset($_COOKIE['msg_session_timed_out'])) {
  // show message
  $msg = "Your session has expired.";
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_session_timed_out', 0, time()-60, '/');
}

// if logged out
if (isset($_COOKIE['msg_is_logged_out'])) {
  // show message
  $msg = "You have logged out.";
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_is_logged_out', 0, time()-60, '/');
}

// if verification code not sent successfully
if (isset($_COOKIE['msg_mailer_error'])) {
  // show message
  $msg = 'An error occured while sending verification code.';
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_mailer_error', 0, time()-60, '/');
}

// if account not yet verified
if (isset($_COOKIE['msg_verify_first'])) {
  // show message
  $msg = 'Please check your email to verify your account first.';
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_verify_first', 0, time()-60, '/');
}

// if account created successfully
if (isset($_COOKIE['msg_account_created'])) {
  // show message
  $msg = "Account successfully created. Please check your email to verify your account.";
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_account_created', 0, time()-60, '/');
}

// if verification code expired
if (isset($_COOKIE['msg_verification_expired'])) {
  // show message
  $msg = 'This verification code has expired.';
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_verification_expired', 0, time()-60, '/');
}

// if account is verified
if (isset($_COOKIE['msg_account_verified'])) {
  // show message
  $msg = 'Your account has been verified. You may now log in.';
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_account_verified', 0, time()-60, '/');
}

// if verification code invalid
if (isset($_COOKIE['msg_verification_invalid'])) {
  // show message
  $msg = 'Invalid verification code.';
  include_once('markup/msg.php');

  // unset message
  setcookie('msg_verification_invalid', 0, time()-60, '/');
}

// if logged in
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
  // do not show login form
  $show_login = false;
  
  if (isset($_COOKIE['msg_is_logged_in'])) {
    // show message
    $msg = "You are logged in.";
    include_once('markup/msg.php');

    // unset message
    setcookie('msg_is_logged_in', 0, time()-60, '/');
  }

  // if search flights is set here and is user
  if (isset($_SESSION['search_flights']) && !$_SESSION['is_admin']) {
    // unset search flights
    unset($_SESSION['search_flights']);
  }

  // require home page
  require_once( $_SESSION['is_admin'] ? 'markup/admin-home.php' : 'markup/user-home.php' );
}

?>

<?php
if ($show_login) {
  require_once('action/session-clear.php');
  //clear session

  // include form
  require_once('markup/form-login.html');
}
?>

</body>
</html>