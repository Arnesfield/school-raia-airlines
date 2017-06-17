<?php
// if not admin
if (isset($_SESSION['is_admin']) && !$_SESSION['is_admin']) {
  header('location: ./');
  exit();
}
?>