<?php
session_start();
$head_title = 'Add Airport - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
if (isset($_POST['submit'])) {
  $name = strip_tags(trim($_POST['name']));
  $place = strip_tags(trim($_POST['place']));
  $status = isset($_POST['status']) ? 'checked' : '';

  if (empty($name) || empty($place)) {
    show_message('Fields cannot be empty.');
  }
  else
    $valid = true;
}

else {
  $name = '';
  $place = '';
  $status = 'checked';
}
?>

<h2>Add Airport</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <div>
    <label for="name">Airport Name</label>
    <input type="text" id="name" name="name" required/>
  </div>

  <div>
    <label for="place">Place</label>
    <input type="text" id="place" name="place" required/>
  </div>

  <div>
    <label for="status">Active</label>
    <input type="checkbox" id="status" name="status" <?=$status?>/>
  </div>

  <div>
    <a href="manage-airports.php">Cancel</a>
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
  add_airport($name, $place, $status);

  set_message('msg_add_airport');
  header('location: manage-airports.php');
}
?>

</body>
</html>