<?php
$head_title = 'Select Seats - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

session_start();
require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['select_flight'])) {
  header('location: flights-select.php');
  exit();
}
?>

<?php echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?> 

<?php
// query seats of given departure
$query = "
  SELECT id FROM seats
  WHERE status = '1'
";

$record = $conn->query($query);

// generate seats based on record
?>

</body>
</html>