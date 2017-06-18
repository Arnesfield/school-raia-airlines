<?php
$head_title = 'Passenger Info - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

session_start();
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['select_seats'])) {
  header('location: seats-select.php');
  exit();
}
?>

<?php
// get total persons
$total_passengers = $_SESSION['reservation']['search_flights']['total_passengers'];

// repost to form
if (isset($_POST['passenger_info'])) {
  foreach ($_POST as $key => $values) {
    if ($key == 'passenger_info')
      continue;
    
    // set variables
    for ($i = 0; $i < count($values); $i++) {
      $temp = ($key == ("seat_id-$i")) ? $key : "$key-$i";
      ${$temp} = $values[$i];
    }
    
    /*foreach ($values as $key_val => $value) {
      echo '<pre>';
      print_r($_POST);
      echo '</pre>';
      ${$key . '-' . $key_val} = strip_tags($value);
    }*/
  }
}

else {
  $total_forms = $total_passengers;

  // if (isset($_SESSION['reservation']['return_choice']))
  //   $total_forms *= 2;

  for ($i = 0; $i < $total_forms; $i++) {
    ${"seat_id-$i"} = '';
    ${"fname-$i"} = '';
    ${"lname-$i"} = '';
    ${"birth_day-$i"} = '';
    ${"birth_month-$i"} = '';
    ${"birth_year-$i"} = '';
  }
}

?>

<?php echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>

<h2>Enter passenger info</h2>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <h4>Departure Seats</h4>

  <?php
    $curr_passenger_index = 0;
    foreach ($_SESSION['reservation']['departure_seats'] as $seat_id) {
      require('markup/form-passenger-info.php');
      $curr_passenger_index++;
    }
  ?>

  <?php if (isset($_SESSION['reservation']['return_choice'])) { ?>

  <h4>Return Seats</h4>

  <?php
    foreach ($_SESSION['reservation']['return_seats'] as $seat_id) {
      require('markup/form-passenger-info.php');
      $curr_passenger_index++;
    }
  ?>

  <?php } ?>

  <div>
    <button type"submit" name="passenger_info">Submit</button>
  </div>

</form>

<?php
// if post
if (isset($_POST['passenger_info'])) {
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';

  // save to session if valid
  for ($i = 0; $i < $total_passengers; $i++) {
    $_SESSION['reservation']['passenger_info'][$i] = array(
      'fname' => ${"fname-$i"},
      'lname' => ${"lname-$i"},
      'birth_day' => ${"birth_day-$i"},
      'birth_month' => ${"birth_month-$i"},
      'birth_year' => ${"birth_year-$i"}
    );
  }

  // redirect to summary
  header('location: res-summary.php');
}
?>

</body>
</html>