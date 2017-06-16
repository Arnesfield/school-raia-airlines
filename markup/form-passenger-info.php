<div>

  <input type="hidden" name="seat_id[]" value="<?=$seat_id?>" />

  <h5>For seat number <?=$seat_id?></h5>

  <div>
    <label for="fname-<?=$curr_passenger_index?>">First Name</label>
    <input type="text" id="fname-<?=$curr_passenger_index?>" name="fname[]" required
      value="<?=${'fname-' . $curr_passenger_index}?>" />
  </div>

  <div>
    <label for="lname-<?=$curr_passenger_index?>">Last Name</label>
    <input type="text" id="lname-<?=$curr_passenger_index?>" name="lname[]" required
      value="<?=${'lname-' . $curr_passenger_index}?>" />
  </div>

  <div>
    <label for="birth_month-<?=$curr_passenger_index?>">Birthdate</label>
    <select id="birth_month-<?=$curr_passenger_index?>" name="birth_month[]" required>
      <option value="">Month</option>
      <?php
        for ($i=1; $i<=12; $i++) {
          $month = date('F', mktime(0,0,0,$i, 1, date('Y')));
          $selected = ($i == ${'birth_month-' . $curr_passenger_index}) ? 'selected': '';
          echo "<option value='$i' $selected>$month</option>";
        }
      ?>
    </select>

    <select name="birth_day[]" required>
      <option value="">Day</option>
      <?php
        for ($i=1; $i<=31; $i++) {
          $selected = ($i == ${'birth_day-' . $curr_passenger_index}) ? 'selected': '';
          echo "<option value='$i' $selected>$i</option>";
        }
      ?>
    </select>
    
    <select name="birth_year[]" required>
      <?php
        for ($i = 0; $i < 100; $i++) {
          $year_temp = date("Y") - $i;
          $year = ${'birth_year-' . $curr_passenger_index};
          $selected = (!empty($year) && $year == $year_temp) ? "selected" : 
                      (empty($year) && $year_temp == date('Y')) ? "selected" : "";
          echo "<option value='$year_temp' $selected>$year_temp</option>";
        }
      ?>
    </select>

  </div>

</div>