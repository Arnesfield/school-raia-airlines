<?php
// fetch places based on ids
$query = "SELECT place FROM airports WHERE id = $fid_1";
$origin_place = $conn->query($query)->fetch_assoc()['place'];

$query = "SELECT place FROM airports WHERE id = $fid_2";
$destination_place = $conn->query($query)->fetch_assoc()['place'];
?>

<?php
if (!$available) {
  $departure_bool = false;
  require_once('markup/user-no-available-flights.html');
} else if ($departure_bool) {
?>

<!-- start -->
<div class="container-sched">

<h2><?=$table_title?></h2>
<table>

  <tr>
    <th>Flight Code</th>
    <th>Departure / Arrival</th>
    <th>Airport</th>
    <th>Duration</th>
    <th>Fly Only</th>
    <th>Fly + Baggage</th>
    <th>Fly + Baggage + Meal</th>
  </tr>

  <?php
    $added_rows = 0;
    foreach ($curr_record as $skey => $row) {
      // echo $available_seats[$index]['total_available_seats']*1;
  ?>
  <?php
    // if id
    if ($available_seats[$skey]['flight_id'] == $row['id']) {

      // skip current info if full
      if ($available_seats[$skey]['total_available_seats']*1 < $total_passengers)
        continue;
    }

    $added_rows++;
  ?>
  <tr>
    
    <td>
      <div>
        <?=$row['flight_code']?>
      </div>
    </td>

    <td>
      <div>
        <?=date('H:i', strtotime($row['departure_time']))?> /
        <?=date('H:i', strtotime($row['arrival_time']))?>
      </div>
    </td>

    <td>
      <div>
        <?=$origin_place?> / <?=$destination_place?>
      </div>
    </td>

    <td>
      <div>
        <?php
          $at = new DateTime($row['arrival_time']);
          $dt = new DateTime($row['departure_time']);
          $interval = $at->diff($dt);

          echo $interval->format("%hh %im");
        ?>
      </div>
    </td>

    <td>
      <div>
        <input type="radio" id="flight_choice-<?=$row['id']?>" name="<?=$choice_name?>"
          value="<?=$row['id']?>-0" required
          <?php
          if (isset($selected_item) && $selected_item == $row['id'] . '-0')
            echo 'checked';
          ?>/>
        
        <?=$row['price']?>
      </div>
    </td>

    <td>
      <div>
        <input type="radio" id="flight_choice-<?=$row['id']?>" name="<?=$choice_name?>"
          value="<?=$row['id']?>-1" required
          <?php
          if (isset($selected_item) && $selected_item == $row['id'] . '-1')
            echo 'checked';
          ?>/>

        <?=$row['price_w_baggage']?>
      </div>
    </td>

    <td>
      <div>
        <input type="radio" id="flight_choice-<?=$row['id']?>" name="<?=$choice_name?>"
          value="<?=$row['id']?>-2" required
          <?php
          if (isset($selected_item) && $selected_item == $row['id'] . '-2')
            echo 'checked';
          ?>/>

        <?=$row['price_w_all']?>
      </div>
    </td>

  </tr>

  <?php } ?>

</table>

</div>

<!-- redo available -->

<?php
if ($added_rows == 0 && $departure_bool) {
  require_once('markup/user-no-available-flights.html');
?>

<script>
  $('.container-sched').hide();
</script>

<?php
  $departure_bool = false;
}
?>

<?php } ?>