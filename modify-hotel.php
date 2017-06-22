<?php
session_start();
$head_title = 'Hotel Hotel - RAIA Airlines';
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
    header('location: manage-hotels.php');
  }
}

$hid = $_POST['hid'];

$query = "
  SELECT * FROM hotels
  WHERE id = $hid
";

$row = $conn->query($query)->fetch_assoc();
$name = $row['name'];
$address = $row['address'];
$price = $row['price'];
$place = $row['airport_id'];
$status = $row['status'] == '1' ? 'checked' : '';
?>

<?php
if (isset($_POST['submit'])) {
  $name = strip_tags(trim($_POST['name']));
  $address = strip_tags(trim($_POST['address']));
  $place = strip_tags(trim($_POST['place']));
  $price = strip_tags(trim($_POST['price']));
  $status = isset($_POST['status']) ? 'checked' : '';

  if (empty($name) || empty($address) || empty($price)) {
    show_message('Fields cannot be empty.');
  }
  else
    $valid = true;
}

?>

<h2>Modify Hotel</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <input type="hidden" name="hid" value="<?=$hid?>" />

  <div>
    <label for="name">Hotel Name</label>
    <input type="text" id="name" name="name" required
      value="<?=$name?>"/>
  </div>

  <div>
    <label for="address">Hotel Address</label>
    <input type="text" id="address" name="address" required
      value="<?=$address?>"/>
  </div>

  
  <div>
    <label for="price">Hotel Price</label>
    <input type="number" min="1" max="1000000" id="price" name="price" required
      value="<?=$price?>"/>
  </div>

  <div>
    <label for="place">Place</label>
    <select id="place" name="place" required>

      <?php
      $record = get_record_from_query("SELECT id, place FROM airports");
      foreach ($record as $row) {
      ?>
      <option value="<?=$row['id']?>"
        <?=$place == $row['id'] ? 'selected': ''?> >
        <?=$row['place']?>
      </option>
      <?php } ?>

    </select>
  </div>

  <div>
    <label for="status">Active</label>
    <input type="checkbox" id="status" name="status" <?=$status?>/>
  </div>

  <div>
    <a href="manage-hotels.php">Cancel</a>
    <button type="submit" name="submit">Modify</button>
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
  modify_hotel($hid, $name, $address, $price, $place, $status);

  set_message('msg_modify_hotel');
  header('location: manage-hotels.php');
}
?>

</body>
</html>