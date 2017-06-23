<?php
session_start();
$head_title = 'Reports - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
// query
$main_q = "
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
    r.with_tour AS 'with_tour',
    r.status AS 'status'
  FROM
    users u, reservations r, flights f,
    seats s, hotels h, airports a_orig, airports a_dest
  WHERE
    r.user_id = u.id AND
    r.flight_id = f.id AND
    r.seat_id = s.id AND
    f.origin_id = a_orig.id AND
    f.destination_id = a_dest.id AND
    r.hotel_id = h.id
";

if (isset($_GET['q'])) {
  $q = mysqli_real_escape_string( $conn, strip_tags(trim($_GET['q'])) );
  $record = get_record_from_query($main_q . "
    AND LOWER(
      CONCAT(
        r.date_reserved, r.time_reserved, u.username, f.flight_code,
        a_orig.place, a_dest.place, f.departure_date,
        f.departure_time, f.arrival_date, f.arrival_time, s.id
      )
    ) LIKE LOWER('%$q%')
  ");
}

else {
  $record = get_record_from_query($main_q);
}
?>


<h2>Reservations</h2>

<?php require_once('markup/form-search.php'); ?>

<!-- display system users -->
<div>

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
    <th>Active</th>
  </tr>

  <?php foreach ($record as $row) { ?>
  <tr>

    <td>

      <form action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return do_toggle()">
        <input type="hidden" name="rid" value="<?=$row['res_id']?>" />
        <input type="hidden" name="status" value="<?=$row['status']?>" />

        <button type="submit" name="toggle">Toggle</button>
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

    <td>
      <div>
        <?=$row['status'] == '1' ? 'Yes' : 'No'?>
      </div>
    </td>

  </tr>

  <?php } ?>

</table>

</div>

<script>
function do_toggle() {
  return confirm('Toggle status of this reservation?');
}
</script>

<?php
if (isset($_POST['toggle'])) {
  $status = $_POST['status'] == '1' ? '0' : '1';
  modify_reservation($_POST['rid'], $status);
  set_message('msg_modify_reservation');
  header('location: reports.php');
}
?>

</body>
</html>