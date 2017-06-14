<?php

// total available flights
$sql = "
  SELECT
    flight_id,
    COUNT(*) AS 'total_available_seats'
  FROM seats
  WHERE
    status = '1' AND
    flight_id = $curr_flight_id
  GROUP BY flight_id
";

// get total available flights of flight id
$row = $conn->query($sql)->fetch_assoc();
$total_available_seats = $row['total_available_seats'];

// save it to array
array_push($no_of_available_seats, array(
  'flight_id' => $curr_flight_id,
  'total_available_seats' => $total_available_seats
));

// echo 'id ' . $curr_flight_id . ' available ' . $total_available_seats . '<br/>';

// foreach ($record as $row) {}


?>