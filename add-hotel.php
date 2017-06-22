<?php
session_start();
$head_title = 'Add Hotel - RAIA Airlines';
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
  $address = strip_tags(trim($_POST['address']));
  $place = strip_tags(trim($_POST['place']));
  $status = isset($_POST['status']) ? 'checked' : '';

  if (empty($name) || empty($address)) {
    show_message('Fields cannot be empty.');
  }
  else
    $valid = true;
}

else {
  $name = '';
  $address = '';
  $place = '';
  $status = 'checked';
}
?>

<h2>Add Hotel</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <div>
    <label for="name">Hotel Name</label>
    <input type="text" id="name" name="name" required/>
  </div>

  <div>
    <label for="address">Hotel Address</label>
    <input type="text" id="address" name="address" required/>
  </div>

  <div>
    <label for="place">Place</label>
    <select id="place" name="place" required>

      <?php
      $record = get_record_from_query('SELECT id, place FROM airports');
      foreach ($record as $row) {
      ?>
      <option value="<?=$row['id']?>"
        <?php
          if (isset($_POST['place']))
            echo $row['id'] == $_POST['place'] ? 'selected': '';
        ?>>
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
  add_hotel($name, $address, $place, $status);

  set_message('msg_add_hotel');
  header('location: manage-hotels.php');
}
?>

</body>
</html>