<?php
// if not user
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
  header('location: ./');
  exit();
}
?>