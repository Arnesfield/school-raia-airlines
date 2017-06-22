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

function set_message($key) {
  setcookie($key, 1, time()+60, '/');
}

function show_message($msg) {
  include_once('markup/msg.php');
}

function add_admin($username, $password, $status) {
  global $conn;

  // prepare and bind
  $query = "
    INSERT INTO users(
      username, password, email,
      fname, lname, birthdate,
      gender, address, contact,
      type, status, verification_code
    ) VALUES(?, ?, '', '', '', CURRENT_DATE(), 'M', '', '', 'admin', ?, '');
  ";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sss", $username, $hashed_password, $status);

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt->execute();
  $stmt->close();
}

function modify_admin($uid, $username, $password, $status, $set_password) {
  global $conn;

  // prepare and bind
  $s = '';
  if ($set_password) {
    $s = ', password = ?';
  }
  $query = "
    UPDATE users
    SET
      username = ? $s,
      status = ?
    WHERE
      id = ?
  ";

  $stmt = $conn->prepare($query);

  if ($set_password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sssi", $username, $hashed_password, $status, $uid);
  }
  else
    $stmt->bind_param("ssi", $username, $status, $uid);
  
  $stmt->execute();
  $stmt->close();
}

require('markup/messages.php');
?>