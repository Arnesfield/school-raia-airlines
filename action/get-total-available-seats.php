<?php

// total available flights

// can be changed to
$sql = "
  SELECT total_seats FROM flights
  WHERE id = $id
";

// get total available flights of flight id
$total_available_seats = $conn->query($sql)->fetch_assoc()['total_seats'];

// also query transactions table
// 

// save it to array
array_push($available_seats, array(
  'flight_id' => $id,
  'total_available_seats' => $total_available_seats
));

?>