<?php
session_start();
require('session-clear.php');

// show message logged out
setcookie('msg_is_logged_out', 1, time()+60, '/');

// redirect to index.php
header('location: ./');
?>