<?php
session_start();
$head_title = 'Manage Hotels - RAIA Airlines';
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
    h.id AS 'id',
    h.name AS 'hotel_name',
    h.address AS 'hotel_address',
    a.place AS 'place',
    h.price AS 'price',
    h.status AS 'status'
  FROM
    hotels h, airports a
  WHERE
    h.airport_id = a.id
";

if (isset($_GET['q'])) {
  $q = mysqli_real_escape_string( $conn, strip_tags(trim($_GET['q'])) );
  $record = get_record_from_query($main_q . "
    AND LOWER(
      CONCAT(
        h.name, h.address, a.place, h.price
      )
    ) LIKE LOWER('%$q%')
  ");
}

else {
  $record = get_record_from_query($main_q);
}
?>

<div class="content">

<h2>Manage Hotels</h2>

<?php require_once('markup/form-search.php'); ?>

<form action="add-hotel.php" method="post">
  <button type="submit" name="add">Add Hotel</button>
</form>


<div>

<table>

  <tr>
    <th>&nbsp;</th>
    <th>Hotel Name</th>
    <th>Hotel Address</th>
    <th>Place In</th>
    <th>Price</th>
    <th>Active</th>
  </tr>

  <?php foreach ($record as $row) { ?>
  
  <tr>

    <td>
      <form action="modify-hotel.php" method="post">
        <input type="hidden" name="hid" value="<?=$row['id']?>" />
        <button type="submit" name="edit">Edit</button>
      </form>
    </td>

    <td>
      <div>
        <?=$row['hotel_name']?>
      </div>
    </td>

    <td>
      <div>
        <?=$row['hotel_address']?>
      </div>
    </td>

    <td>
      <div>
        <?=$row['place']?>
      </div>
    </td>

    <td>
      <div>
        <?='P' . $row['price']?>
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

</div>

</body>
</html>