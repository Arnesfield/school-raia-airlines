<?php
session_start();
$head_title = 'Add Flight - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
if (isset($_POST['submit'])) {
  $flight_code = strip_tags(trim($_POST['flight_code']));
  $origin = strip_tags(trim($_POST['origin']));
  $destination = strip_tags(trim($_POST['destination']));
  $departure_time = strip_tags(trim($_POST['departure_time']));
  $arrival_time = strip_tags(trim($_POST['arrival_time']));
  $total_seats = strip_tags(trim($_POST['total_seats']));
  $price = strip_tags(trim($_POST['price']));
  $price_w_baggage = strip_tags(trim($_POST['price_w_baggage']));
  $price_w_all = strip_tags(trim($_POST['price_w_all']));
  $status = isset($_POST['status']) ? 'checked' : '';

  if (
    empty($flight_code) || empty($origin) || 
    empty($destination) || empty($departure_time) || 
    empty($arrival_time) || empty($total_seats) ||
    empty($price) || empty($price_w_baggage) ||
    empty($price_w_all)
  ) {
    show_message('Fields cannot be empty.');
  }

  else if ($origin == $destination) {
    show_message('Origin and destination cannot be the same.');
  }
  else
    $valid = true;
}

else {
  $flight_code = '';
  $origin = '';
  $destination = '';
  $departure_time = '';
  $arrival_time = '';
  $total_seats = '';
  $price = '';
  $price_w_baggage = '';
  $price_w_all = '';
  $status = 'checked';
}
?>

<h2>Add Flight</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <div>
    <label for="flight_code">Flight Code</label>
    <input type="text" id="flight_code" name="flight_code" required/>
  </div>

  <div>
    <label for="origin">Origin</label>
    <select id="origin" name="origin" required>

      <?php
      $record = get_record_from_query('SELECT id, place FROM airports');
      foreach ($record as $row) {
      ?>
      <option value="<?=$row['id']?>"
        <?php
          if (isset($_POST['origin']))
            echo $row['id'] == $_POST['origin'] ? 'selected': '';
        ?>>
        <?=$row['place']?>
      </option>
      <?php } ?>

    </select>
  </div>

  <div>
    <label for="destination">Destination</label>
    <select id="destination" name="destination" required>

      <?php
      $record = get_record_from_query('SELECT id, place FROM airports');
      foreach ($record as $row) {
      ?>
      <option value="<?=$row['id']?>"
        <?php
          if (isset($_POST['destination']))
            echo $row['id'] == $_POST['destination'] ? 'selected': '';
        ?>>
        <?=$row['place']?>
      </option>
      <?php } ?>

    </select>
  </div>

  <div>
    <label for="departure_time">Departure Time</label>
    <input type="time" id="departure_time" name="departure_time" required/>
  </div>

  <div>
    <label for="arrival_time">Arrival Time</label>
    <input type="time" id="arrival_time" name="arrival_time" required/>
  </div>

  <div>
    <label for="total_seats">Total Seats</label>
    <input type="number" min="20" max="1000" id="total_seats" name="total_seats" required/>
  </div>

  <div>
    <label for="price">Price</label>
    <input type="number" min="20" max="1000000" id="price" name="price" required
      value="2000"/>
  </div>

  <div>
    <label for="price_w_baggage">Price (w/Baggage)</label>
    <input type="number" min="20" max="1000000" id="price_w_baggage" name="price_w_baggage" required
      value="2300"/>
  </div>

  <div>
    <label for="price_w_all">Price (w/Baggage and Food)</label>
    <input type="number" min="20" max="1000000" id="price_w_all" name="price_w_all" required
      value="2500"/>
  </div>

  <div>
    <label for="status">Active</label>
    <input type="checkbox" id="status" name="status" <?=$status?>/>
  </div>

  <div>
    <a href="manage-flights.php">Cancel</a>
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
  add_flight(
    $flight_code, $origin, $destination,
    $departure_time, $arrival_time, $total_seats,
    $price, $price_w_baggage, $price_w_all, $status
  );

  set_message('msg_add_flight');
  header('location: manage-flights.php');
}
?>

</body>
</html>