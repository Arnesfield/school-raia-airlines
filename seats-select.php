<?php
$head_title = 'Select Seats - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

session_start();
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['select_flight'])) {
  header('location: flights-select.php');
  exit();
}
?>

<?php
// include variables from search flights
foreach ($_SESSION['search_flights'] as $key => $value) {
  // echo $key . ' ' . $value . '<br/>';
  $$key = $value;
}

// get total persons
$total_passengers_set = $no_adults*1 + $no_children*1 + $no_infant*1;
?>

<?php echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?> 

<?php
// query seats of given departure
$query = "
  SELECT id FROM seats
  WHERE status != '0'
";

$record = $conn->query($query);

// generate seats based on record
// use table instead
?>


<h2>Seats here</h2>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <div>
    <a href="flights-select.php">&laquo; Back</a>
    <button type="submit" name="select_seats">Next</button>
  </div>

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

</form>

<?php

if ( isset($_POST['select_seats']) ) {

  // if number of selected seats is greater than number of set passengers
  if (count($_POST['seats']) != $total_passengers_set) {
    // display error
    $msg = 'There should be only ' . $total_passengers_set . ' number of seats selected.';
    include_once('markup/msg.php');
    exit();
  }

  // save selected seats here
  echo count($_POST['seats']);
  
  // save entries to array in session
  foreach ($_POST as $key => $value) {
    // save to session
    $_SESSION[$key] = $value;
  }

  // redirect to next page
  // header('location: passenger-info.php');
}


// close connection
$conn->close();
?>

</body>
</html>