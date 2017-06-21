<?php
session_start();
$head_title = 'Manage Airports - RAIA Airlines';
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
  SELECT * FROM airports
";

if (isset($_GET['q'])) {
  $q = mysqli_real_escape_string( $conn, strip_tags(trim($_GET['q'])) );
  $record = get_record_from_query($main_q . "
    AND LOWER(CONCAT(name, place))
    LIKE LOWER('%$q%')
  ");
}

else {
  $record = get_record_from_query($main_q);
}
?>

<h2>Manage Airports</h2>

<?php require_once('markup/form-search.php'); ?>

<form action="add-airport.php" method="post">
  <button type="submit" name="add">Add Hotel</button>
</form>


<div>

<table>

  <tr>
    <th>&nbsp;</th>
    <th>Hotel Name</th>
    <th>Place / City</th>
  </tr>

  

  <?php foreach ($record as $row) { ?>
  
  <tr>

    <td>
      <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="aid" value="<?=$row['id']?>" />
        <button type="submit" name="edit">Edit</button>
      </form>
    </td>

    <td>
      <div>
        <?=$row['name']?>
      </div>
    </td>

    <td>
      <div>
        <?=$row['place']?>
      </div>
    </td>

  </tr>

  <?php } ?>

</table>

</div>

<?php
if (isset($_POST['edit'])) {

  echo $_POST['aid'];

  // redirect to action
  // header('location: mofidy-hotel.php');
}
?>

</body>
</html>