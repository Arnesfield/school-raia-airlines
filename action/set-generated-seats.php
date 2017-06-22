<?php

if ($what_seat == 'departure_seats') {
  $what_flight = $_SESSION['reservation']['departure_choice']['departure_id'];
}
else {
  $what_flight = $_SESSION['reservation']['return_choice']['return_id'];
}

$dept_date = $_SESSION['reservation']['search_flights']['departure_date'];

$query = "
  SELECT id FROM seats
  WHERE flight_id = $what_flight
  LIMIT $total_passengers
";

$query = "
  SELECT s.id AS 'id'
  FROM
    seats s, flights f, reservations r
  WHERE
    s.flight_id = $what_flight AND
    r.flight_id = f.id AND
    (r.departure_date != '$dept_date' OR r.seat_id != s.id)
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