<?php

if (isset($_COOKIE['msg_add_admin'])) {
  $msg = "System Admin successfully added.";
  include_once('markup/msg.php');
  setcookie('msg_add_admin', 0, time()-60, '/');
}

if (isset($_COOKIE['msg_modify_admin'])) {
  $msg = "System Admin successfully modified.";
  include_once('markup/msg.php');
  setcookie('msg_modify_admin', 0, time()-60, '/');
}

if (isset($_COOKIE['msg_error'])) {
  $msg = "An error occured.";
  include_once('markup/msg.php');
  setcookie('msg_error', 0, time()-60, '/');
}

?>