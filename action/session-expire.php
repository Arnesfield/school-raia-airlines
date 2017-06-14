<?php
if (!isset($_COOKIE['has_session'])) {
  session_start();
  session_destroy();

  // set message
  setcookie('msg_session_timed_out', 1, time()+60, '/');

  // redirect
  header('location: ./');
}
?>