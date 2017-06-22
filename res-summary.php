<?php
session_start();
$head_title = 'Reservation Summary - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['hotel_id'])) {
  header('location: hotels-select.php');
  exit();
}
?>

<?php
foreach ($_SESSION['reservation']['search_flights'] as $key => $value) {
  $$key = $value;
}

$departure_seats = $_SESSION['reservation']['departure_seats'];
if (isset($_SESSION['reservation']['return_choice'])) {
  $return_seats = $_SESSION['reservation']['return_seats'];
}

$total_passengers = $_SESSION['reservation']['search_flights']['total_passengers'];

// 
$res = $_SESSION['reservation'];

// set needed variables
$origin_id = $res['search_flights']['origin'];
$destination_id = $res['search_flights']['destination'];


// query places
$query = "SELECT name, place FROM airports WHERE id = $origin";
$record = $conn->query($query)->fetch_assoc();
$origin_a_name = $record['name'];
$origin_name = $record['place'];

// main query
$main_q = "
  SELECT
    f.id AS 'flight_id',
    f.flight_code AS 'flight_code',
    f.departure_time AS 'departure_time',
    f.arrival_time AS 'arrival_time',
    f.price AS 'price',
    f.price_w_baggage AS 'price_w_baggage',
    f.price_w_all AS 'price_w_all'
  FROM seats s, flights f
  WHERE
    s.flight_id = f.id
";

$query = $main_q . " AND s.id = {$departure_seats[0]}";
echo $query;
$record = $conn->query($query)->fetch_assoc();
$dept_fid = $record['flight_id'];
$dept_fcode = $record['flight_code'];
$dept_time = $record['departure_time'];
$dept_arrival = $record['arrival_time'];
$dept_price = $record['price'];
$dept_type = $_SESSION['reservation']['departure_choice']['departure_flight_type'];

if ($dept_type == 0)
  $dept_price = $record['price'];
else if ($dept_type == 1)
  $dept_price = $record['price_w_baggage'];
else if ($dept_type == 2)
  $dept_price = $record['price_w_all'];
// $code_orig = $conn->query($query)->fetch_assoc()['flight_code'];

$query = "SELECT name, place FROM airports WHERE id = $destination";
$record = $conn->query($query)->fetch_assoc();
$destination_a_name = $record['name'];
$destination_name = $record['place'];
// $code_dest = $conn->query($query)->fetch_assoc()['flight_code'];

if (isset($_SESSION['reservation']['return_choice'])) {
  $query = $main_q . " AND s.id = {$return_seats[0]}";
  $record = $conn->query($query)->fetch_assoc();
  $return_fid = $record['flight_id'];
  $return_fcode = $record['flight_code'];
  $return_time = $record['departure_time'];
  $return_arrival = $record['arrival_time'];
  $return_price = $record['price'];
  $return_type = $_SESSION['reservation']['return_choice']['return_flight_type'];

  if ($return_type == 0)
    $return_price = $record['price'];
  else if ($return_type == 1)
    $return_price = $record['price_w_baggage'];
  else if ($return_type == 2)
    $return_price = $record['price_w_all'];
}

?>

<?php echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>

<h2>Reservation Summary</h2>

<!-- flight info -->
<div>
  
  <!-- display table -->
  <div>

    <div>
      <h4>
        Passenger Details
      </h4>
    </div>

    <?php require('markup/user-res-psgr-details.php'); ?>

  </div>

  <div>
    <h3>Flight Details</h3>

    <div>

      <table>

        <tr>
          <td colspan=4>
            <h3>Departure Information</h3>
          </td>
        </tr>

        <tr>
          <th>Flight</th>
          <th>Departure</th>
          <th>Arrival</th>
          <th>Price</th>
        </tr>

        <tr>

          <td>
            <div>
              <p>Flight Code: <?=$dept_fcode?></p>
              <p><?=$origin_name?> to <?=$destination_name?></p>
            </div>
          </td>

          <td>
            <div>
              <p>Departure date: <?=date('F d, Y', strtotime($departure_date))?></p>
              <p>Departure time: <?=date('H:i', strtotime($dept_time))?></p>
              <p><?=$origin_a_name?></p>
            </div>
          </td>

          <td>
            <div>
              <p>Arrival date: <?=date('F d, Y', strtotime($departure_date))?></p>
              <p>Arrival time: <?=date('H:i', strtotime($dept_arrival))?></p>
              <p><?=$destination_a_name?></p>
            </div>
          </td>

          <td>
            <div>
              <p>P<?=$dept_price?></p> <br/>
            </div>
          </td>

        </tr>

        <!-- return -->
        <?php if (isset($_SESSION['reservation']['return_choice'])) { ?>

        <tr>
          <td colspan=4>
            <h3>Return Information</h3>
          </td>
        </tr>

        <tr>
          <th>Flight</th>
          <th>Departure</th>
          <th>Arrival</th>
          <th>Price</th>
        </tr>

        <tr>

          <td>
            <div>
              <p>Flight Code: <?=$return_fcode?></p>
              <p><?=$destination_name?> to <?=$origin_name?></p>
            </div>
          </td>

          <td>
            <div>
              <p>Departure date: <?=date('F d, Y', strtotime($return_date))?></p>
              <p>Departure time: <?=date('H:i', strtotime($return_time))?></p>
              <p><?=$destination_a_name?></p>
            </div>
          </td>

          <td>
            <div>
              <p>Arrival date: <?=date('F d, Y', strtotime($return_date))?></p>
              <p>Arrival time: <?=date('H:i', strtotime($return_arrival))?></p>
              <p><?=$origin_a_name?></p>
            </div>
          </td>

          <td>
            <div>
              <p>P<?=$return_price?></p> <br/>
            </div>
          </td>

        </tr>

        <?php } ?>

        <?php
          $total = 0;
          $hid = $_SESSION['reservation']['hotel_id'];
          if ($hid != '0') {
            echo $hid;
            $rec = get_record_from_query("SELECT * FROM hotels WHERE id = $hid")->fetch_assoc();
            $total = $rec['price']*1;
            
        ?>

        <tr>
          <td colspan=2>&nbsp;</td>
          <th>
            Hotel
          </th>
        </tr>

        <tr>
          <td colspan=2>&nbsp;</td>
          <td>
            <p><?=$rec['name']?></p>
            <p><?=$rec['address']?></p>
          </td>
          <td>
            <?='P' . $rec['price']?>
          </td>
        </tr>

        <?php } ?>

        <tr>
          <td colspan=2>&nbsp;</td>
          <th>
            Total
          </th>

          <td>
            <?php
              $total += $dept_price;

              if (isset($_SESSION['reservation']['return_choice'])) {
                $total += $return_price;
              }
            ?>

            <strong>P<?=$total?></strong>
          </td>

        </tr>

      </table>
    </div>

  </div>

</div>

<?php

$_SESSION['reservation']['total_payment'] = $total;

?>

<div>

  <a href="hotels-select.php">Back</a>
  <a href="res-payment.php">Next</a>

</div>

</body>
</html>