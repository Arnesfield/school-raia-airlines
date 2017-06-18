<div>
  <?php
  for ($i = 0; $i < $total_passengers; $i++) {
    $p = $_SESSION['reservation']['passenger_info'][$i];
    $s = $_SESSION['reservation']['departure_seats'][$i];
  ?>

  <div>
    <strong><?=$i+1?>.</strong>

    <div>
      <p>
      <?php
        printf('%s, %s', $p['lname'], $p['fname']);
      ?>
      </p>
      
      <p>
      <?php
        echo date('F d, Y', strtotime($p['birth_year'] . '-' . $p['birth_month'] . '-' . $p['birth_day']));
      ?>
      </p>

      <p>
      Seat Number <?=$s?>
      <?php
        if (isset($_SESSION['reservation']['return_choice'])) {
          $r = $_SESSION['reservation']['return_seats'][$i];
      ?>
      
      <br/>
      Return Seat Number <?=$r?>

      <?php } ?>
      </p>
    </div>

  </div>


  <?php } ?>
</div>