<?php
$head_title = 'Payment - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

session_start();
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['total_payment'])) {
  header('location: res-summary.php');
  exit();
}
?>

<h2>Payment</h2>

</body>
</html>