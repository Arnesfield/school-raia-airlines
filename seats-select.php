<?php
session_start();
$head_title = 'Select Seats - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['select_flight'])) {
  header('location: flights-select.php');
  exit();
}
?>

<?php
// include variables from search flights
foreach ($_SESSION['reservation']['search_flights'] as $key => $value) {
  // echo $key . ' ' . $value . '<br/>';
  $$key = $value;
}

// get total persons
$total_passengers = $_SESSION['reservation']['search_flights']['total_passengers'];
?>

<?php echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>

<?php
// generate seats
$what_seat = 'departure_seats';
require('action/set-generated-seats.php');

if (isset($_SESSION['reservation']['return_choice'])) {
  $what_seat = 'return_seats';
  require('action/set-generated-seats.php');
}

// generate seats based on record
// use table instead

// generate seats instead
?>


<h2>Seats here</h2>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <div>
  
    <h4>Generated departure seats</h4>

    <!-- display generated seats -->
    <?php foreach($_SESSION['reservation']['departure_seats'] as $seat) { ?>
      <p><?=$seat?></p>
    <?php } ?>

    <?php if (isset($_SESSION['reservation']['return_choice'])) { ?>
    
      <h4>Generated return seats</h4>
      
      <!-- display generated seats -->
      <?php foreach($_SESSION['reservation']['return_seats'] as $seat) { ?>
        <p><?=$seat?></p>
      <?php } ?>
      
    <?php } ?>

  </div>

  <div>
    <a href="flights-select.php">&laquo; Back</a>
    <button type="submit" name="select_seats">Next</button>
  </div>

</form>

<!-- show table -->

<table>

<?php for ($i = 0; $row = $record->fetch_assoc(); $i++) { ?>

<?php if ($i % 6 == 0) { ?>
  <tr>
<?php } ?>

    <td>
      <label for="seat-<?=$row['id']?>">Seat <?=$row['id']?></label>
      <input type="checkbox" id="seat-<?=$row['id']?>" name="seat_ids[]"
        value="<?=$row['id']?>" />
    </td>

    <?php if ($i % 2 == 0 && ($i+1) % 3 == 0) { ?>
      <td><div>&nbsp;</div></td>
    <?php } ?>

<?php if (($i+1) % 6 == 0) { ?>
  </tr>
<?php
  }
}
?>

</table>

<?php

if ( isset($_POST['select_seats']) ) {

  // if number of selected seats is greater than number of set passengers
  /*
  if (count($_POST['seats']) != $total_passengers) {
    // display error
    $msg = 'There should be only ' . $total_passengers . ' number of seats selected.';
    include_once('markup/msg.php');
    exit();
  }
  */

  // save selected seats here
  echo count($_POST['seats']);
  
  // save entries to array in session
  foreach ($_POST as $key => $value) {
    // save to session
    $_SESSION['reservation'][$key] = $value;
  }

  // redirect to next page
  header('location: passenger-info.php');
}


// close connection
$conn->close();
?>

</body>
</html>