<?php

if (isset($_COOKIE['msg_add_admin'])) {
  $msg = "System Admin successfully added.";
  include_once('markup/msg.php');
  setcookie('msg_add_admin', 0, time()-60, '/');
}

?>