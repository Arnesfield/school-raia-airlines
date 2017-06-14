<?php
// get total flights in flight id and generate total seats with that flight id
$sql = "
  SELECT id, total_seats
  FROM flights
";

$flight_records = $conn->query($sql);

// generate total number of seats using flight id
foreach ($flight_records as $curr_flight_row) {

  // generate seats based on all fetched flights
  for ($i = 0; $i < $curr_flight_row['total_seats']; $i++) {

    $sql = "
      INSERT INTO seats(flight_id, date_generated, status)
      VALUES(?, CURRENT_DATE(), '1');
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $curr_flight_row['id']);
    $stmt->execute();
    $stmt->close();
  }

}


?>