<?php
session_start();
$head_title = 'Modify Admin - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
if ( !isset($_POST['edit']) ) {
  if (!isset($_POST['submit'])) {
    set_message('msg_error');
    header('location: manage-system-users.php');
  }
}

$uid = $_POST['uid'];

$query = "
  SELECT username, status FROM users
  WHERE id = $uid
";

$row = $conn->query($query)->fetch_assoc();
$username = $row['username'];
$status = $row['status'] == '1' ? 'checked' : '';
?>

<?php
// if added, query if exist and validate
if (isset($_POST['submit'])) {
  // check if username exists
  $username = strip_tags(trim($_POST['username']));
  $password = strip_tags(trim($_POST['password']));
  
  if ($uid != $_SESSION['user_id'])
    $status = isset($_POST['status']) ? 'checked' : '';

  
  $u = mysqli_real_escape_string($conn, $username);

  $query = "
    SELECT username FROM users
    WHERE username = '$u'
  ";

  $record = $conn->query($query);

  // if username exists
  if ($record->num_rows > 0 && $row['username'] != $username) {
    show_message('Username already exists.');
  }

  else {
    $valid = true;
  }

}

?>

<h2>Add System User</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <input type="hidden" name="uid" value="<?=$uid?>" />

  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required
      value="<?=$username?>"/>
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password"/>
  </div>

  <?php if ($uid != $_SESSION['user_id']) { ?>

  <div>
    <label for="status">Active</label>
    <input type="checkbox" id="status" name="status" <?=$status?>/>
  </div>

  <?php } ?>

  <div>
    <a href="manage-system-users.php">Cancel</a>
    <button type="submit" name="submit">Modify</button>
  </div>

</form>

</div>

<?php

// on success
// set message
// redirect to page

if (isset($valid)) {
  $status = $status == 'checked' ? '1' : '0';
  $set_password = !empty($_POST['password']);
  modify_admin($uid, $username, $password, $status, $set_password);

  set_message('msg_modify_admin');
  header('location: manage-system-users.php');
}
?>

</body>
</html>