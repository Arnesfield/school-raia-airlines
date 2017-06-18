<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();
echo 'header<br/>';
require_once('action/redirect.php');
// require('action/seat-generate.php');

function get_record_from_query($q) {
  global $conn;
  return $conn->query($q);
}
?>