<?php
ob_start();

// access with /dev/?action=dev
if (isset($_GET['action']) && $_GET['action'] = 'dev') {

// generate seats based on flight total seats
require_once('../action/db-connection.php');

$query = "
  SELECT id, total_seats
  FROM flights
";

$record = $conn->query($query);
foreach ($record as $row) {
  // generate n seats based on total_seats
  for ($i = 0; $i < $row['total_seats']; $i++) {
    $sql = "INSERT INTO seats(flight_id) VALUES(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $row['id']);
    $stmt->execute();
    $stmt->close();
  }
}

// $conn->close();
}

header('location: ../');
?>