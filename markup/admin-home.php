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

<div class="content">

<h1>Welcome, <?=$username?>!</h1>

<div class="my-p-t-3 my-p-b my-p-x-4 my-fs-3 -my-lh-2">

  <p>Do check our reports page for more information!</p>

  <br/>

  <p class="my-t-r t-secondary">
    <em>-- RAIA Airlines v0.5 &copy; 2017</em>
  </p>

</div>

</div>