<?php
session_start();
$head_title = 'Manage Flights - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
// query system users

if (isset($_GET['q'])) {
  $q = mysqli_real_escape_string( $conn, strip_tags(trim($_GET['q'])) );
  $record = get_record_from_query("
    SELECT
      f.id AS 'flight_id',
      f.flight_code AS 'flight_code',
      a_orig.place AS 'origin',
      a_dest.place AS 'destination',
      f.departure_time AS 'departure_time',
      f.arrival_time AS 'arrival_time',
      f.status AS 'flight_status'
    FROM
      flights f, airports a_orig, airports a_dest
    WHERE
      f.origin_id = a_orig.id AND
      f.destination_id = a_dest.id AND
      LOWER(
        CONCAT(
          f.flight_code, a_orig.place, a_dest.place,
          f.departure_time, f.arrival_time
        )
      ) LIKE LOWER('%$q%')
  ");
}

else {
  $record = get_record_from_query("
    SELECT
      f.id AS 'flight_id',
      f.flight_code AS 'flight_code',
      a_orig.place AS 'origin',
      a_dest.place AS 'destination',
      f.departure_time AS 'departure_time',
      f.arrival_time AS 'arrival_time',
      f.status AS 'flight_status'
    FROM
      flights f, airports a_orig, airports a_dest
    WHERE
      f.origin_id = a_orig.id AND
      f.destination_id = a_dest.id
  ");
}

?>

<h2>Manage Flights</h2>

<?php require_once('markup/form-search.php'); ?>

<form action="add-flight.php" method="post">
  <button type="submit" name="add">Add User</button>
</form>

<!-- display system users -->
<div>

<table>

  <tr>
    <th>&nbsp;</th>
    <th>Flight Code</th>
    <th>Origin</th>
    <th>Destination</th>
    <th>Destination</th>
  </tr>

  <?php foreach ($record as $row) { ?>
  <tr>
    
    <td>
      <div>

        <form action="modify-flight.php" method="post">
          <input type="hidden" name="uid" value="<?=$row['id']?>" />
          <button type="submit" name="edit">Edit</button>
        </form>

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
        <?=date('H:i', strtotime($row['departure_time']))?> /
        <?=date('H:i', strtotime($row['arrival_time']))?>
      </div>
    </td>

  </tr>

  <?php } ?>

</table>

</div>

</body>
</html>