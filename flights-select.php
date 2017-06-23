<?php
session_start();
$head_title = 'Select Flight - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

require_once('action/redirect-user.php');
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['search_flights'])) {
  header('location: flights-search.php');
  exit();
}
?>

<?php
foreach ($_SESSION['reservation']['search_flights'] as $key => $value) {
  // echo $key . ' ' . $value . '<br/>';
  $$key = $value;
}

// use this array to store data
$available_seats = array();

// set variables inside flights-query.php
$available = true;

$fid_1 = $origin;
$fid_2 = $destination;
$record_name = 'departure_record';
$date_name = 'departure_date';

require('action/flights-query.php');

// if has return
if (isset($do_return_date)) {

  // set variables for flights-query.php
  $fid_1 = $destination;
  $fid_2 = $origin;
  $record_name = 'return_record';
  $date_name = 'return_date';

  require('action/flights-query.php');
}

?>

<div class="content">

<h1>Select flight (2)</h1>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

<?php

// set value here
if (isset($_SESSION['reservation']['departure_choice'])) {
  $selected_d_id = $_SESSION['reservation']['departure_choice']['departure_id'];
  $selected_f_type = $_SESSION['reservation']['departure_choice']['departure_flight_type'];
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

$fid_1 = $origin;
$fid_2 = $destination;

require('markup/user-flights-table.php');

if (isset($do_return_date) && $available) {
  // set value here
  if (isset($_SESSION['reservation']['return_choice'])) {
    $selected_d_id = $_SESSION['reservation']['return_choice']['return_id'];
    $selected_f_type = $_SESSION['reservation']['return_choice']['return_flight_type'];
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
  $fid_1 = $destination;
  $fid_2 = $origin;

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
    $_SESSION['reservation']['departure_choice'] = array(
      'departure_id' => $d_id,
      'departure_flight_type' => $d_f_type
    );

    // add post submit to session
    $_SESSION['reservation']['select_flight'] = $_POST['select_flight'];
  }

  if (isset($do_return_date)) {
    sscanf($_POST['return_choice'], '%d-%d', $r_id, $r_f_type);
    // echo 'Return Info: ' . $r_id . ' ' . $r_f_type . '<br/>';

    // add to session
    $_SESSION['reservation']['return_choice'] = array(
      'return_id' => $r_id,
      'return_flight_type' => $r_f_type
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

</div>

</body>
</html>