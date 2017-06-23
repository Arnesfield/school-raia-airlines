<?php
session_start();
$head_title = 'Select Hotel - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

require_once('action/redirect-user.php');
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['passenger_info'])) {
  header('location: passenger-info.php');
  exit();
}
?>

<?php
$hotel_id = '0';

if (isset($_POST['choose'])) {
  $hotel_id = $_POST['hid'];
}

$query = "
  SELECT
    h.id AS 'hid',
    h.name AS 'hotel_name',
    h.address AS 'hotel_address',
    h.price AS 'price'
  FROM hotels h, airports a, flights f
  WHERE
    f.destination_id = a.id AND
    f.id = {$_SESSION['reservation']['departure_choice']['departure_id']} AND
    h.airport_id = a.id AND
    h.status = '1'
";

$record = $conn->query($query);
?>

<div class="content">

<h1>Hotel Selection</h1>

<h2>Select Hotel</h2>

<div>

<table>

  <tr>
    <th>&nbsp;</th>
    <th>Hotel Name</th>
    <th>Hotel Address</th>
    <th>Place In</th>
    <th>Active</th>
  </tr>

  <?php foreach ($record as $row) { ?>
  
  <tr>

    <td>
      <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hid" value="<?=$row['hid']?>" />
        <button type="submit" name="choose">Choose</button>
      </form>
    </td>

    <td>
      <div>
        <?=$row['hotel_name']?>
      </div>
    </td>

    <td>
      <div>
        <?=$row['hotel_address']?>
      </div>
    </td>

    <td>
      <div>
        <?='P'.$row['price']?>
      </div>
    </td>

  </tr>

  <?php } ?>

</table>

  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <a href="passenger-info.php">Back</a>
    <button type="submit" name="submit">No thanks!</button>
  </form>

</div>

<?php

if (isset($_POST['choose']) || isset($_POST['submit'])) {
  $_SESSION['reservation']['hotel_id'] = $hotel_id;
  header('location: res-summary.php');
}
?>

</div>

</body>
</html>