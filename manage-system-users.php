<?php
session_start();
$head_title = 'Manage System Users - RAIA Airlines';
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
  WHERE type = 'admin'
";

$record = $conn->query($query);
?>

<h2>Manage System Users</h2>

<!-- display system users -->
<div>

<table>

  <tr>
    <th>Username</th>
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
        <?=$row['status'] == '1' ? 'Yes' : 'No'?>
      </div>
    </td>

  </tr>

  <?php } ?>
</table>

</div>

</body>
</html>