<div id="form_choices_card_payment" class="included_choices">
  <h3>Payment Option</h3>

  <div>
    <label for="credit_card">Credit Card</label>
    <input type="radio" id="credit_card" name="card_payment_option"
      value="credit_card" class="clickable"/>
  </div>

  <div>
    <label for="debit_card">Debit Card</label>
    <input type="radio" id="debit_card" name="card_payment_option"
      value="debit_card" class="clickable"/>
  </div>
</div>


<div id="form_card_payment" class="included_form">

  <h3>Customer Details</h3>

  <div>
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="fname">
  </div>

  <div>
    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lname">
  </div>

  <div>
    <label for="card_no">Card Number</label>
    <input type="number" min="1000" max="9999" id="card_no" name="card_no">
  </div>

  <div>
    <label for="expiry_month">Expiration Date</label>
    <select id="expiry_month" name="expiry_month">
      <option value="" disabled selected>Month</option>
      <?php
      for ($i = 1; $i <= 12; $i++) {
        $month = date('F', mktime(0, 0, 0, $i, 1, date('Y')));
        $selected = ($i == ('expiry_month')) ? 'selected' : '';
        echo "<option value='$i' $selected>$month</option>";
      }
      ?>
    </select>

    <select id="expiry_year" name="expiry_year">
      <option value="" disabled selected>Year</option>
      <?php
      for ($i = 0; $i < 100; $i++) {
        $year_temp = date("Y") + $i;
        $year = ('expiry_year');
        $selected = (!empty($year) && $year == $year_temp) ? "selected" :
            (empty($year) && $year_temp == date('Y')) ? "selected" : "";
        echo "<option value='$year_temp' $selected>$year_temp</option>";
      }
      ?>
    </select>
  </div>

</div>