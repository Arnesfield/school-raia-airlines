<?php

// query flights table and look for available flights on that day
$query = "
  SELECT * FROM flights
  WHERE
    status = '1' AND
    origin_id = $fid_1 AND
    destination_id = $fid_2
  ORDER BY
    departure_time ASC
";

// all available flights
$$record_name = $conn->query($query);
$available = $available && $$record_name->num_rows > 0;

// use this array to store data
$available_seats = array();

// get total available seats of departure
foreach ($$record_name as $row) {
  // push number of seats to array
  $id = $row['id'];
  
  // get total available seats
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

}

?>