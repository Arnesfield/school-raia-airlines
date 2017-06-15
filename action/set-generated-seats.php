<?php

$what_flight = $what_seat == 'departure_seats' ?
              $_SESSION['departure_choice']['departure_id'] :
              $_SESSION['return_choice']['return_id'];

$query = "
  SELECT id FROM seats
  WHERE
    status = '1' AND
    flight_id = $what_flight
  LIMIT $total_passengers_set
";

$record = $conn->query($query);

foreach ($record as $row) {    
  // add generated seat to array
  $_SESSION['generated_seats'][$what_seat] = array();
  array_push($_SESSION['generated_seats'][$what_seat], $row['id']);
}


?>