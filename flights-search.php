<?php
$head_title = 'Search Flights - RAIA Airlines';
require_once('markup/top.php');
require_once('action/session-expire.php');
require_once('action/header.php');
require_once('markup/user-nav.html');

session_start();
require_once('action/db-connection.php');

// if search flights is set here and is user
if (isset($_SESSION['search_flights']) && !$_SESSION['is_admin']) {
  // unset search flights
  unset($_SESSION['search_flights']);

  if (isset($_SESSION['departure_choice']))
    unset($_SESSION['departure_choice']);

  if (isset($_SESSION['return_choice']))
    unset($_SESSION['return_choice']);

  if (isset($_SESSION['select_flight']))
    unset($_SESSION['select_flight']);
}

?>

<?php
// query flights here
$query = "SELECT id, place FROM airports";
$record = $conn->query($query);


// if session array is set
if (isset($_SESSION['search_flights'])) {
  foreach ($_SESSION['search_flights'] as $key => $value) {
    $_POST[$key] = $value;
  }

  // unset variables
  unset($_SESSION['search_flights']);
  unset($_POST['search_flights']);
}

// foreach ($_POST as $key => $value)
  // echo $key . ' ' . $value . '<br/>';

?>

<h1>Search Flights (1)</h1>

<h2>Select where</h2>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

  <div>
    <label for="origin">Origin</label>
    <select id="origin" name="origin" required>
      
      <option value=""></option>
      <?php foreach ($record as $row) { ?>
      <option value="<?=$row['id']?>"
        <?php
          if (isset($_POST['origin']))
            echo $row['id'] == $_POST['origin'] ? 'selected': '';
        ?>>
        <?=$row['place']?>
      </option>
      <?php } ?>

    </select>
  </div>

  <div>
    <label for="destination">Destination</label>
    <select id="destination" name="destination" required>

      <option value=""></option>
      <?php foreach ($record as $row) { ?>
      <option value="<?=$row['id']?>"
        <?php
          if (isset($_POST['destination']))
            echo $row['id'] == $_POST['destination'] ? 'selected': '';
        ?>>
        <?=$row['place']?>
      </option>
      <?php } ?>

    </select>
  </div>

  <div>
    <label for="departure_date">Departure Date</label>
    <input type="date" id="departure_date" name="departure_date" required
      min="<?=date('Y-m-d')?>" max="<?=date('Y')+1 . date('-m-d')?>"
      class="date-select"
      value="<?=isset($_POST['departure_date']) ? $_POST['departure_date'] : date('Y-m-d')?>" />
  </div>

  <div>

    <input type="checkbox" id="do_return_date" name="do_return_date"
      <?=isset($_POST['do_return_date']) ? 'checked' : ''?>/>
    <label for="do_return_date">Round-trip</label>
  
    <div id="container-return_date"
      style="<?php
        echo isset($_POST['do_return_date']) ? '' : 'display: none';
      ?>">
      <label for="return_date">Return Date</label>
      <input type="date" id="return_date" name="return_date" required
        min="<?=date('Y-m-d')?>" max="<?=date('Y')+1 . date('-m-d')?>"
        class="date-select"
        value="<?=isset($_POST['return_date']) ? $_POST['return_date'] : date('Y-m-d')?>" />
    </div>

  </div>

  <script>
    $('.date-select').change(function() {
      $('#return_date').attr('min', $('#departure_date').val());
    });

    $('#do_return_date').change(function() {
      $('#container-return_date').toggle();

      var attr = $('#return_date').attr('required');
      if (typeof attr !== typeof undefined && attr !== false) {
        $('#return_date').removeAttr('required');
      }
      else {
        $('#return_date').attr('required', 'true');
      }
    });
  </script>

  <div>
    <label for="no_adults">Adults</label>
    <input type="number" id="no_adults" name="no_adults" min="0" max="20"
      class="passenger_no" required
      value="<?=isset($_POST['no_adults']) ? $_POST['no_adults'] : 1?>" />
  </div>

  <div>
    <label for="no_children">Children</label>
    <input type="number" id="no_children" name="no_children" min="0" max="19"
      class="passenger_no" required
      value="<?=isset($_POST['no_children']) ? $_POST['no_children'] : 0?>"/>
  </div>

  <div>
    <label for="no_infant">Infants</label>
    <input type="number" id="no_infant" name="no_infant" min="0" max="1"
      class="passenger_no" required
      value="<?=isset($_POST['no_infant']) ? $_POST['no_infant'] : 0?>"/>
  </div>

  <script>
    $('.passenger_no').change(function() {
      var max = 20;
      // if 0
      if ($('#no_adults').val()*1 == 0) {
        $('#no_children').attr('max', 2);
      }
      else {
        $('#no_children').attr('max', max - $('#no_adults').val());
        $('#no_adults').attr('max', max - $('#no_children').val());
      }

      $('#no_infant').attr('max', $('#no_adults').val());

      // number of adults will depend on total

      $('.passenger_no').each(function() {
        if ($(this).val()*1 > $(this).attr('max')*1) {
          $(this).val($(this).attr('max'));
        }
      });

    });
  </script>

  <div>
    <button type="submit" name="search_flights">Search</button>
  </div>
  
</form>

<?php
if ( isset($_POST['search_flights']) ) {

  // if both destinations are the same
  if ($_POST['origin'] == $_POST['destination']) {
    $msg = 'Origin and destination cannot be the same.';
    include_once('markup/msg.php');
    exit();
  }

  // save entries to array in session
  foreach ($_POST as $key => $value) {
    // save to session
    $_SESSION['search_flights'][$key] = $value;
  }

  // redirect here
  header('location: flights-select.php');
}
?>

</body>
</html>