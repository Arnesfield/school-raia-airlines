<?php
$head_title = 'Reservation Summary - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

session_start();
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['passenger_info'])) {
  header('location: passenger-info.php');
  exit();
}
?>

<?php
foreach ($_SESSION['reservation']['search_flights'] as $key => $value) {
  $$key = $value;
}

$total_passengers = $_SESSION['reservation']['search_flights']['total_passengers'];

// 
$res = $_SESSION['reservation'];

// set needed variables
$origin_id = $res['search_flights']['origin'];
$destination_id = $res['search_flights']['destination'];


// query places
$query = "SELECT place FROM airports WHERE id = $origin";
$origin_name = $conn->query($query)->fetch_assoc()['place'];

$query = "SELECT place FROM airports WHERE id = $destination";
$destination_name = $conn->query($query)->fetch_assoc()['place'];


?>

<?php echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>

<h2>Reservation Summary</h2>

<!-- flight info -->
<div>
  
  <h3>
    Departure Information
  </h3>

  <h4>
    Origin: <?=$origin_name?>
  </h4>

  <h4>
    Destination: <?=$destination_name?>
  </h4>

  <h4>
    Departure date: <?=$departure_date?>
  </h4>

  <!-- display table -->
  <div>

    <div>
      <h4>
        Passenger Information
      </h4>
    </div>

    <table>
    <?php for ($i = 0; $i < $total_passengers; $i++) {
      require('markup/user-res-summary-table.php');
    }
    ?>
    </table>

  </div>

</div>


</body>
</html>