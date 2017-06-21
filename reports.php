<?php
session_start();
$head_title = 'Reports - RAIA Airlines';
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
    r.date_reserved AS 'date_reserved',
    r.time_reserved AS 'time_reserved',
    u.username AS 'username',
    f.flight_code AS 'flight_code',
    a_orig.place AS 'origin',
    a_dest.place AS 'destination',
    f.departure_date AS 'departure_date',
    f.departure_date AS 'departure_date',
    f.arrival_date AS 'arrival_date',

  FROM
    users u, reservations r, flights f,
    seats s, hotel h, airports a_orig, a_dest
";


?>




<h2>Reservations</h2>

</body>
</html>