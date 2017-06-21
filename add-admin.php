<?php
session_start();
$head_title = 'Manage System Users - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
// if added, query if exist and validate
if (isset($_POST['submit'])) {
  // check if username exists
  $username = strip_tags(trim($_POST['username']));
  $password = strip_tags(trim($_POST['password']));
  $status = isset($_POST['status']) ? 'checked' : '';
  
  $u = mysqli_real_escape_string($conn, $username);

  $query = "
    SELECT username FROM users
    WHERE username = '$u'
  ";

  $record = $conn->query($query);

  // if username exists
  if ($record->num_rows > 0) {
    show_message('Username already exists.');
  }

  else {
    $valid = true;
  }

}

else {
  $username = '';
  $status = 'checked';
}
?>

<h2>Add System User</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required
      value="<?=$username?>"/>
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required/>
  </div>

  <div>
    <label for="status">Active</label>
    <input type="checkbox" id="status" name="status" <?=$status?>/>
  </div>

  <div>
    <a href="manage-system-users.php">Cancel</a>
    <button type="submit" name="submit">Add</button>
  </div>

</form>

</div>

<?php

// on success
// set message
// redirect to page

if (isset($valid)) {

  // insert
  $status = $status == 'checked' ? '1' : '0';
  add_admin($username, $password, $status);

  set_message('msg_add_admin');
  header('location: manage-system-users.php');
}
?>

</body>
</html>