<?php
$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "db_airlines";

$conn = new mysqli($server_name, $username, $password, $db_name);

/* check connection */
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  header('location: ./');
  exit();
}
?>