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
$query = "
  SELECT * FROM users
  WHERE type = 'normal'
";

$record = $conn->query($query);
?>

<!-- display system users -->
<div>

<table>

  <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Active</th>
  </tr>

  <?php foreach ($record as $row) { ?>
  <tr>
    
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

</body>
</html>