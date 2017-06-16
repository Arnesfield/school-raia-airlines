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
if (!isset($_SESSION['select_seats'])) {
  header('location: seats-select.php');
  exit();
}
?>

<?php
// get total persons
$total_passengers_set = $_SESSION['search_flights']['total_passengers_set'];

// repost to form
if (isset($_POST['passenger_info'])) {
  foreach ($_POST as $key => $values) {
    if ($key == 'passenger_info')
      continue;
    
    // set variables
    for ($i = 0; $i < count($values); $i++) {
      $temp = ($key == ('seat_id-' . $i)) ? $key : $key . '-' . $i;
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
  for ($i = 0; $i < $total_passengers_set; $i++) {
    ${'seat_id-' . $i} = '';
    ${'fname-' . $i} = '';
    ${'lname-' . $i} = '';
    ${'birth_day-' . $i} = '';
    ${'birth_month-' . $i} = '';
    ${'birth_year-' . $i} = '';
  }
}

?>

<?php echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>

<?php

?>

<h2>Enter passenger info</h2>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">


<h4>Departure Seats</h4>

<?php
$curr_passenger_index = 0;
foreach ($_SESSION['generated_seats']['departure_seats'] as $seat_id) {
  require('markup/form-passenger-info.php');
  $curr_passenger_index++;
}  
?>


  <div>
    <button type"submit" name="passenger_info">Submit</button>
  </div>

</form>

<?php
// if post
if (isset($_POST['passenger_info'])) {
  echo 'posted';

  echo '<pre>';
  print_r($_POST);
  echo '</pre>';

  return;
  echo 'posted 2';
  // save to session if valid
  $_SESSION['passenger_info'][] = array(
    'fname' => $fname,
    'lname' => $lname,
    'birth_day' => $birth_day,
    'birth_month' => $birth_month,
    'birth_month' => $birth_month,
    'birth_day' => $birth_day,
  );

  // redirect to summary
  // header('location: reservation summary');
}
?>

</body>
</html>