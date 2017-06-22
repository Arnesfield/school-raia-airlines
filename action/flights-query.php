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

// get total available seats of departure
foreach ($$record_name as $row) {
  // push number of seats to array
  $id = $row['id'];
  
  // get total available seats
  $sql = "
    SELECT total_seats, departure_time FROM flights
    WHERE id = $id
  ";

  // get total available flights of flight id
  $temp_rec = $conn->query($sql)->fetch_assoc();
  $total_available_seats = $temp_rec['total_seats'];
  $departure_time = $temp_rec['departure_time'];

  // also query transactions table
  // 
  $sql = "
    SELECT
      r.id AS 'res_id'
    FROM reservations r, flights f
    WHERE
      f.id = r.flight_id AND
      r.flight_id = $id AND
      r.departure_date = '{$$date_name}' AND
      f.departure_time = '$departure_time'
  ";
  // total taken seats
  $temp_rec = $conn->query($sql);
  $temp_row = $temp_rec->fetch_assoc();
  $total_taken_seats = $temp_rec->num_rows;
  $total_available_seats -= $total_taken_seats*1;

  // echo $total_available_seats;

  // save it to array
  array_push($available_seats, array(
    'flight_id' => $id,
    'total_available_seats' => $total_available_seats
  ));

}

?>