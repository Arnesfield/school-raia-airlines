<?php
  $head_title = "Sign Up | RAIA Airlines";
  require_once('markup/top.php');
?>

<?php
  if (isset($_COOKIE['msg_duplicate_username'])) {
    // duplicate username
    $msg = "Username already taken.";
    include_once('markup/msg.php');

    // unset message
    setcookie('msg_duplicate_username', 0, time()-60, '/');
  }
  
  if (isset($_COOKIE['msg_duplicate_email'])) {
    // used email
    $msg = "Email is already being used.";
    include_once('markup/msg.php');

    // unset message
    setcookie('msg_duplicate_email', 0, time()-60, '/');
  }

  if (isset($_COOKIE['msg_password_mismatch'])) {
    // password mismatch
    $msg = "Passwords do not match.";
    include_once('markup/msg.php');

    // unset message
    setcookie('msg_password_mismatch', 0, time()-60, '/');
  }

  if (isset($_COOKIE['msg_captcha'])) {
    // password mismatch
    $msg = "Captcha verification required. Please try again.";
    include_once('markup/msg.php');

    // unset message
    setcookie('msg_captcha', 0, time()-60, '/');
  }
  
  session_start();
  
  // save values
  if (isset($_SESSION['repost'])) {
    foreach ($_SESSION as $key => $value)
      $_POST[$key] = $value;
  }
  
  function get_v($assoc) {
    return isset($_POST[$assoc]) ? $_POST[$assoc] : '';
  }
  
  function print_v($assoc) {
    echo get_v($assoc);
  }
  
  
  // clear session
  require_once("action/session-clear.php");
?>

<form action="action/user-create.php" method="post">
  <h1>Sign Up</h1>
  
  <h2>Login Information</h2>
  
  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username"
      required value="<?php print_v('username'); ?>" />
    <br/>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required />
    <br/>
    
    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm_password" name="confirm_password" required />
  </div>
  
  <h2>Personal Information</h2>
  
  <div>
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="fname"
      required value="<?php print_v('fname'); ?>" />
    <br/>
    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lname"
      required value="<?php print_v('lname'); ?>" />
  </div>
  
  <div>
    <label for="email">Email</label>
    <input type="email" id="email" name="email"
      required value="<?php print_v('email'); ?>" />
  </div>
  
  <div>
    <label for="birth_month">Birthdate</label>
    <select id="birth_month" name="birth_month" required>
      <option value="">Month</option>
      <?php
        for ($i=1; $i<=12; $i++) {
          $month = date('F', mktime(0,0,0,$i, 1, date('Y')));
          $selected = ($i == get_v('birth_month')) ? 'selected': '';
          echo "<option value='$i' $selected>$month</option>";
        }
      ?>
    </select>
    
    <select name="birth_day" required>
      <option value="">Day</option>
      <?php
        for ($i=1; $i<=31; $i++) {
          $selected = ($i == get_v('birth_day')) ? 'selected': '';
          echo "<option value='$i' $selected>$i</option>";
        }
      ?>
    </select>
    
    <select name="birth_year" required>
      <?php
        for ($i = 0; $i < 100; $i++) {
          $year_temp = date("Y") - $i;
          $year = get_v('birth_year');
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
        $gender = get_v('gender');
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
      required value="<?php print_v('address'); ?>" />
  </div>
  
  <div>
    <label for="contact">Mobile Number</label>
    <input type="tel" id="contact" name="contact"
      required pattern="^([+]63|[0])[\d]{10}$" value="<?php print_v('contact'); ?>" />
  </div>

  <div class="g-recaptcha" data-sitekey="6LdobCYUAAAAAAmW1y-w5OIQtNIKjfoXLk3vtF3o"></div>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  
  <input type="submit" name="form_signup"/>
</form>

<a href="./">Back</a>

</body>
</html>