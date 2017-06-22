<?php
session_start();
$head_title = 'Modify Users - RAIA Airlines';
require_once('markup/top.php');
require_once('action/admin-init.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/admin-nav.html');

require_once('action/db-connection.php');
?>

<?php
if ( !isset($_POST['edit']) ) {
  if (!isset($_POST['submit'])) {
    set_message('msg_error');
    header('location: manage-users.php');
  }
}

$uid = $_POST['uid'];

$query = "
  SELECT * FROM users
  WHERE id = $uid
";

// $date = DateTime::createFromFormat("Y-m-d", "2068-06-15");
// echo $date->format("Y");

$row = $conn->query($query)->fetch_assoc();
$username = $row['username'];
$email = $row['email'];
$fname = $row['fname'];
$lname = $row['lname'];
$birthdate = $row['birthdate'];
$formatted_date = DateTime::createFromFormat('Y-m-d', $birthdate);

$birth_month = $formatted_date->format('m');
$birth_day = $formatted_date->format('d');
$birth_year = $formatted_date->format('Y');

$gender = $row['gender'];
$address = $row['address'];
$contact = $row['contact'];

$status = $row['status'] == '1' ? 'checked' : '';
?>

<?php
// if added, query if exist and validate
if (isset($_POST['submit'])) {
  // check if username exists
  $username = strip_tags(trim($_POST['username']));
  $password = strip_tags(trim($_POST['password']));
  $email = strip_tags(trim($_POST['email']));
  $fname = strip_tags(trim($_POST['fname']));
  $lname = strip_tags(trim($_POST['lname']));

  $birth_month = strip_tags(trim($_POST['birth_month']));
  $birth_day = strip_tags(trim($_POST['birth_day']));
  $birth_year = strip_tags(trim($_POST['birth_year']));

  $birthdate = $_POST['birth_year'].'-'.$_POST['birth_month'].'-'.$_POST['birth_day'];

  $gender = strip_tags(trim($_POST['gender']));
  $address = strip_tags(trim($_POST['address']));
  $contact = strip_tags(trim($_POST['contact']));
  
  $status = isset($_POST['status']) ? 'checked' : '';

  $u = mysqli_real_escape_string($conn, $username);
  $e = mysqli_real_escape_string($conn, $email);
  $urecord = get_record_from_query("
    SELECT username FROM users
    WHERE username = '$u'
  ");
  $erecord = get_record_from_query("
    SELECT email FROM users
    WHERE email = '$e'
  ");

  if ($urecord->num_rows > 0 && $row['username'] != $username) {
    show_message('Username already exists.');
  }

  else if ($erecord->num_rows > 0 && $row['email'] != $email) {
    show_message('Email already taken.');
  }

  else if (
    empty($username) || empty($email) ||
    empty($fname) || empty($lname) ||
    empty($birth_month) || empty($birth_day) ||
    empty($birth_year) || empty($gender) ||
    empty($address) || empty($contact)
  ) {
    show_message('Fields cannot be empty.');
  }

  else {
    $valid = true;
  }

}

?>

<h2>Modify User</h2>

<div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <input type="hidden" name="uid" value="<?=$uid?>" />

  <h2>Login Information</h2>
  
  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username"
      required value="<?=$username?>" />
    <br/>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" />
    <br/>
  </div>
  
  <h2>Personal Information</h2>
  
  <div>
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="fname"
      required value="<?=$fname?>" />
    <br/>
    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lname"
      required value="<?=$lname?>" />
  </div>
  
  <div>
    <label for="email">Email</label>
    <input type="email" id="email" name="email"
      required value="<?=$email?>" />
  </div>
  
  <div>
    <label for="birth_month">Birthdate</label>
    <select id="birth_month" name="birth_month" required>
      <option value="">Month</option>
      <?php
        for ($i=1; $i<=12; $i++) {
          $month = date('F', mktime(0,0,0,$i, 1, date('Y')));
          $selected = ($i == $birth_month) ? 'selected': '';
          echo "<option value='$i' $selected>$month</option>";
        }
      ?>
    </select>
    
    <select name="birth_day" required>
      <option value="">Day</option>
      <?php
        for ($i=1; $i<=31; $i++) {
          $selected = ($i == $birth_day) ? 'selected': '';
          echo "<option value='$i' $selected>$i</option>";
        }
      ?>
    </select>
    
    <select name="birth_year" required>
      <?php
        for ($i = 0; $i < 100; $i++) {
          $year_temp = date("Y") - $i;
          $year = $birth_year;
          $selected = (!empty($year) && $year == $year_temp) ? "selected" : 
                      (empty($year) && $year_temp == date('Y')) ? "selected" : "";
          echo "<option value='$year_temp' $selected>$year_temp</option>";
        }
      ?>
    </select>
  </div>
  
  <div>
    <label for="gender">Gender</label>
    <select id="gender" name="gender" required>
      <option value="">I am...</option>
      <?php
        $gender_arr = array(
          'M' => 'Male',
          'F' => 'Female'
        );
        
        foreach ($gender_arr as $key => $value) {
          $selected = ($gender == $key) ? 'selected' : '';
          echo "<option value='$key' $selected>$value</option>";
        }
      ?>
    </select>
  </div>
  
  <div>
    <label for="address">Address</label>
    <input type="text" id="address" name="address"
      required value="<?=$address?>" />
  </div>
  
  <div>
    <label for="contact">Mobile Number</label>
    <input type="tel" id="contact" name="contact"
      required pattern="^([+]63|[0])[\d]{10}$" value="<?=$contact?>" />
  </div>


  <div>
    <label for="status">Active</label>
    <input type="checkbox" id="status" name="status" <?=$status?>/>
  </div>

  <div>
    <a href="manage-users.php">Cancel</a>
    <button type="submit" name="submit">Modify</button>
  </div>

</form>

</div>

<?php

// on success
// set message
// redirect to page

if (isset($valid)) {
  $status = $status == 'checked' ? '1' : '0';
  $set_password = !empty($_POST['password']);
  modify_user(
    $uid, $username, $password,
    $email, $fname, $lname, $birthdate,
    $gender, $address, $contact, $status, $set_password
  );

  set_message('msg_modify_user');
  header('location: manage-users.php');
}
?>

</body>
</html>