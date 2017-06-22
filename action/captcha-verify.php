<?php
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
  $secret = "6LdobCYUAAAAANOtra8BkAUonu9cPI7XCmOgt4bi";
  $ip = $_SERVER['REMOTE_ADDR'];
  $captcha = $_POST['g-recaptcha-response'];
  $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip$ip");
  $arr = json_decode($rsp, TRUE);

  $valid_captcha = $arr['success'];
}

else {
  $valid_captcha = false;
}
?>