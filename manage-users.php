<?php
session_start();
$head_title = 'Manage Users - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
// query system users
$main_q = "
  SELECT * FROM users
  WHERE type = 'normal'
";

if (isset($_GET['q'])) {
  $q = mysqli_real_escape_string( $conn, strip_tags(trim($_GET['q'])) );
  $record = get_record_from_query($main_q . "
    AND LOWER( CONCAT(username, fname, lname) ) LIKE LOWER('%$q%')
  ");
}

else {
  $record = get_record_from_query($main_q);
}

?>

<div class="content">

<h2>Manage Users</h2>

<?php require_once('markup/form-search.php'); ?>

<!-- display users -->
<div>

<table>

  <tr>
    <th>&nbsp;</th>
    <th>Username</th>
    <th>Name</th>
    <th>Active</th>
  </tr>

  <?php foreach ($record as $row) { ?>
  <tr>
    
    <td>
      <div>

        <form action="modify-user.php" method="post">
          <input type="hidden" name="uid" value="<?=$row['id']?>" />
          <button type="submit" name="edit">Edit</button>
        </form>

      </div>
    </td>
    
    <td>
      <div>
        <?=$row['username']?>
      </div>
    </td>
    
    <td>
      <div>
        <?php
          printf('%s, %s', $row['lname'], $row['fname']);
        ?>
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