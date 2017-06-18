<?php

$what_flight = $what_seat == 'departure_seats' ?
  $_SESSION['reservation']['departure_choice']['departure_id'] :
  $_SESSION['reservation']['return_choice']['return_id'];

$query = "
  SELECT id FROM seats
  WHERE flight_id = $what_flight
  LIMIT $total_passengers
";

$record = $conn->query($query);

// NOTE
// Also consider taken seats based on transaction table

$_SESSION['reservation'][$what_seat] = array();

foreach ($record as $row) {
  // add generated seat to array
  $_SESSION['reservation'][$what_seat][] = $row['id'];
}

?>