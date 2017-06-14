<?php
$head_title = 'Select Flight - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

session_start();
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['search_flights'])) {
  header('location: flights-search.php');
  exit();
}
?>

<?php
foreach ($_SESSION['search_flights'] as $key => $value) {
  // echo $key . ' ' . $value . '<br/>';
  $$key = $value;
}

// query flights table and look for available flights on that day
$query = "
  SELECT * FROM flights
  WHERE
    status = '1' AND
    origin_id = $origin AND
    destination_id = $destination
  ORDER BY
    departure_time ASC
";

// query this
// check if id has available seats for total passenger set
// same number of rows
// fetch assoc at the same time

// only generate seats if 

// get total persons
$total_passengers_set = $no_adults*1 + $no_children*1 + $no_infant*1;

// all available flights
$execute = $conn->query($query);

// use this array to store data
$no_of_available_seats = array();

foreach ($execute as $row) {

  // push number of seats to array
  $curr_flight_id = $row['id'];
  require('action/get-total-available-seats.php');

  // echo $total_passengers_set . '<br/>';

  // echo $no_of_available_seats[0]['flight_id'] . ' here<br/>';
}

/*
$query = "
  SELECT
    f.id AS 'id',
    f.flight_code AS 'flight_code',
    f.departure_time AS 'departure_time',
    f.arrival_time AS 'arrival_time',
    f.price AS 'price',
    f.price_w_baggage AS 'price_w_baggage',
    f.price_w_all AS 'price_w_all',
    s.id AS 'seat_id'
  FROM flights f, seats s
  WHERE
    f.status = '1' AND
    f.origin_id = $origin AND
    f.destination_id = $destination AND
    s.flight_id = f.id
  ORDER BY
    f.departure_time ASC
";
*/

$departure_record = $conn->query($query);

$available = $departure_record->num_rows > 0;

// if has return
if (isset($do_return_date)) {
  $query = "
    SELECT * FROM flights
    WHERE
      status = '1' AND
      origin_id = $destination AND
      destination_id = $origin
    ORDER BY
      departure_time ASC
  ";

  $return_record = $conn->query($query);

  // add condition to available
  $available = $return_record->num_rows > 0;
}

?>

<h1>Select flight (2)</h1>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

<?php

// set value here
if (isset($_SESSION['departure_choice'])) {
  $selected_d_id = $_SESSION['departure_choice']['departure_id'];
  $selected_f_type = $_SESSION['departure_choice']['departure_flight_type'];
}
else {
  $selected_d_id = '';
  $selected_f_type = '';
}
$selected_item = $selected_d_id . '-' . $selected_f_type;

$curr_record = $departure_record;
$table_title = 'Departure Flight';
$choice_name = 'departure_choice';
$departure_bool = true;

require('markup/user-flights-table.php');

if (isset($do_return_date) && $available) {
  // set value here
  if (isset($_SESSION['return_choice'])) {
    $selected_d_id = $_SESSION['return_choice']['return_id'];
    $selected_f_type = $_SESSION['return_choice']['return_flight_type'];
  }
  else {
    $selected_d_id = '';
    $selected_f_type = '';
  }
  $selected_item = $selected_d_id . '-' . $selected_f_type;
  
  $curr_record = $return_record;
  $table_title = 'Return Flight';
  $choice_name = 'return_choice';

  // exchange
  $temp = $origin;
  $origin = $destination;
  $destination = $temp;

  require('markup/user-flights-table.php');
}
?>

<a href="flights-search.php">&laquo; Back</a>
<button type="submit" name="select_flight">Select</button>

</form>

<?php
if ( isset($_POST['select_flight']) ) {
  $redirect = false;

  if (isset($_POST['departure_choice'])) {
    $redirect = true;
    sscanf($_POST['departure_choice'], '%d-%d', $d_id, $d_f_type);
    // echo 'Departure Info: ' . $d_id . ' ' . $d_f_type . '<br/>';

    // add to session
    $_SESSION['departure_choice'] = array(
      'departure_id' => $d_id,
      'departure_flight_type' => $d_f_type
    );

    // add post submit to session
    $_SESSION['select_flight'] = $_POST['select_flight'];
  }

  if (isset($do_return_date)) {
    sscanf($_POST['return_choice'], '%d-%d', $r_id, $r_f_type);
    // echo 'Return Info: ' . $r_id . ' ' . $r_f_type . '<br/>';

    // add to session
    $_SESSION['return_choice'] = array(
      'return_id' => $d_id,
      'return_flight_type' => $d_f_type
    );
  }

  if ($redirect) {
    // redirect here
    header('location: seats-select.php');
  }
}

// close connection
$conn->close();
?>

</body>
</html>