<?php
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

require_once('action/db-connection.php');

$username = get_record_from_query("
  SELECT * FROM users WHERE id = {$_SESSION['user_id']}
")->fetch_assoc()['username'];

$record = get_record_from_query("
  SELECT
    r.id AS 'res_id',
    r.date_reserved AS 'date_reserved',
    r.time_reserved AS 'time_reserved',
    u.username AS 'username',
    f.flight_code AS 'flight_code',
    a_orig.place AS 'origin',
    a_dest.place AS 'destination',
    r.departure_date AS 'departure_date',
    f.departure_time AS 'departure_time',
    r.arrival_date AS 'arrival_date',
    f.arrival_time AS 'arrival_time',
    h.name AS 'hotel_name',
    s.id AS 'seat_id',
    r.with_tour AS 'with_tour'
  FROM
    users u, reservations r, flights f,
    seats s, hotels h, airports a_orig, airports a_dest
  WHERE
    r.user_id = {$_SESSION['user_id']} AND
    r.user_id = u.id AND
    r.flight_id = f.id AND
    r.seat_id = s.id AND
    f.origin_id = a_orig.id AND
    f.destination_id = a_dest.id AND
    r.hotel_id = h.id AND
    r.status = '1'
  ORDER BY
    r.date_reserved, r.time_reserved
");

?>

<div class="content">

<h1>Welcome, <?=$username?>!</h1>

<div>

<?php if ($record->num_rows == 0) { ?>

<p>You have no reservations :-(</p>

<?php
} else {
?>

<table>

  <tr>
    <th>&nbsp;</th>
    <th>Date Reserved</th>
    <th>Username</th>
    <th>Flight Code</th>
    <th>Origin</th>
    <th>Destination</th>
    <th>Seat Number</th>
    <th>With Tour</th>
    <th>Hotel Name</th>
    <th>Departure Date</th>
    <th>Arrival Date</th>
  </tr>

  <?php foreach ($record as $row) { ?>
  <tr>
    
    <td>

      <form action="./" method="post" onsubmit="return do_cancel()">
        <input type="hidden" name="rid" value="<?=$row['res_id']?>" />
        <button type="submit" name="cancel">Remove</button>
      </form>

    </td>

    <td>
      <div>
        <?=$row['date_reserved']?>
        <?=date('H:i', strtotime($row['time_reserved']))?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['username']?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['flight_code']?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['origin']?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['destination']?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['seat_id']?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['with_tour'] == '1' ? 'Yes' : 'No'?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['hotel_name']?>
      </div>
    </td>
    
    <td>
      <div>
        <?=$row['departure_date']?>
        <?=date('H:i', strtotime($row['departure_time']))?>
      </div>
    </td>

    <td>
      <div>
        <?=$row['arrival_date']?>
        <?=date('H:i', strtotime($row['arrival_time']))?>
      </div>
    </td>

  </tr>

  <?php } ?>

</table>

<script>
function do_cancel() {
  return confirm('Are you sure you want to cancel this reservation?');
}
</script>

<?php } ?>

</div>

<?php
if (isset($_POST['cancel'])) {
  modify_reservation($_POST['rid'], '0');
  set_message('msg_remove_reservation');
  header('location: ./');
}
?>

</div>