<?php
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
$username = get_record_from_query("
  SELECT * FROM users WHERE id = {$_SESSION['user_id']}
")->fetch_assoc()['username'];
?>

<h1>Welcome, <?=$username?>!</h1>

