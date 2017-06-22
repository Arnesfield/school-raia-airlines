<?php
session_start();
$head_title = 'Modify Airport - RAIA Airlines';
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
    header('location: manage-airports.php');
  }
}

$aid = $_POST['aid'];

$query = "
  SELECT name, place, status FROM airports
  WHERE id = $aid
";

$row = $conn->query($query)->fetch_assoc();
$name = $row['name'];
$place = $row['place'];
$status = $row['status'] == '1' ? 'checked' : '';
?>

<?php
if (isset($_POST['submit'])) {
  $n_name = strip_tags(trim($_POST['name']));
  $n_place = strip_tags(trim($_POST['place']));
  $status = isset($_POST['status']) ? 'checked' : '';

  if (empty($n_name) || empty($n_place)) {
    show_message('Fields cannot be empty.');
  }
  else
    $valid = true;
}

?>

<h2>Modify Airport</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <input type="hidden" name="aid" value="<?=$aid?>" />

  <div>
    <label for="name">Airport Name</label>
    <input type="text" id="name" name="name" required
      value="<?=$name?>"/>
  </div>

  <div>
    <label for="place">Place</label>
    <input type="text" id="place" name="place" required
      value="<?=$place?>"/>
  </div>

  <div>
    <label for="status">Active</label>
    <input type="checkbox" id="status" name="status" <?=$status?>/>
  </div>

  <div>
    <a href="manage-airports.php">Cancel</a>
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
  modify_airport($aid, $n_name, $n_place, $status);

  set_message('msg_modify_airport');
  header('location: manage-airports.php');
}
?>

</body>
</html>