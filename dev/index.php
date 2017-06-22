<?php
ob_start();

// access with /dev/?action=dev
if (isset($_GET['action']) && $_GET['action'] = 'dev') {

// generate seats based on flight total seats
require_once('../action/db-connection.php');
$query = "SELECT id FROM flights ORDER BY id DESC LIMIT 1";
$gen_id = $conn->query($query)->fetch_assoc()['id'];
// require_once('../action/seat-generate.php');

// $conn->close();
}

header('location: ../');
?>