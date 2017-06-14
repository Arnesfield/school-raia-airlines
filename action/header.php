<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();

require_once('action/db-connection.php');

// fetch latest date
$sql = "SELECT date_generated FROM seats ORDER BY date_generated DESC";

$row = $conn->query($sql)->fetch_assoc();
// echo $row['date_generated'] . '<br/>';
// echo date('Y-m-d');
echo 'header<br/>';

// if date is new, generate new seats
if (date('Y-m-d') > $row['date_generated']) {
  // status off all seats first
  $sql = "UPDATE seats SET status = '0'";

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $stmt->close();

  echo '<br/>generated<br/>';
  // generate here
  require('action/seat-generate.php');
}

?>