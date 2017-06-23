<?php
session_start();
$head_title = 'Payment - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

require_once('action/db-connection.php');
?>

<?php
// validate if submit exists
if (!isset($_SESSION['reservation']['total_payment'])) {
  header('location: res-summary.php');
  exit();
}
?>

<?php
// save choices
if (isset($_POST['submit'])) {
  $valid = true;
}
?>

<div class="content">

<h1>Reservation Payment</h1>

<h2>Payment</h2>

<div>

<div>
  <strong>
    <p>Total: P<?=$_SESSION['reservation']['total_payment']?></p>
  </strong>
</div>

<form id="form_payment_option" method="post" action="<?=$_SERVER['PHP_SELF']?>">

  <div>
    <label for="payment_card">Card Payment</label>
    <input type="radio" id="payment_card" name="payment_option"
      value="card_payment" class="clickable first" />
  </div>

  <div>
    <label for="payment_center">Payment Center</label>
    <input type="radio" id="payment_center" name="payment_option"
      value="payment_center" class="clickable first" />
  </div>

  <?php
    require_once('markup/card-payment.php');
    require_once('markup/payment-center.php');
  ?>

  <div>
    <a href="res-summary.php">Back</a>
    <button id="btn_submit" type="submit" name="submit">Next</button>
  </div>

</form>

<script>
$('.included_form').hide();
$('.included_choices').hide();
$('#btn_submit').hide();

$('.clickable.first').click(function() {

  $('.included_form').hide();
  $('.included_choices').hide();
  $('#btn_submit').hide();

  $('.included_form input').prop('required', false);
  $('.included_form select').prop('required', false);

  var form_choices = '#form_choices_' + $(this).val();
  $(form_choices).show();

  // remove all required fields on all included forms
  $('.included_choices input').prop('checked', false);
  $('.included_choices input').prop('required', false);
  $(form_choices + ' input').prop('required', true);

  if (form_choices == '#form_choices_payment_center') {
    $('#btn_submit').show();
  }
});

$('#form_choices_card_payment .clickable').click(function() {
  $('#form_card_payment').show();
  $('#form_card_payment input').prop('required', true);
  $('#form_card_payment select').prop('required', true);
  $('#btn_submit').show();
});

$('#form_choices_payment_center .clickable').click(function() {
  // $('#form_payment_center').show();
  // $('#form_payment_center input').prop('required', true);
  // $('#form_payment_center select').prop('required', true);
  // $('#btn_submit').show();
});
</script>

</div>

<?php

if (isset($valid)) {

  add_reservation($_SESSION['reservation']);
  set_message('msg_add_reservation');
  header('location: ./');
}
?>

</div>

</body>
</html>