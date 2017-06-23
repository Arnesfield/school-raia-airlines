<?php
date_default_timezone_set("Asia/Hong_Kong");
ob_start();
require_once('action/redirect.php');
// require('action/seat-generate.php');

function get_record_from_query($q) {
  global $conn;
  return $conn->query($q);
}

function set_message($key) {
  setcookie($key, 1, time()+60, '/');
}

function show_message($msg) {
  include_once('markup/msg.php');
}

function add_admin($username, $password, $status) {
  global $conn;

  // prepare and bind
  $query = "
    INSERT INTO users(
      username, password, email,
      fname, lname, birthdate,
      gender, address, contact,
      type, status, verification_code
    ) VALUES(?, ?, '', '', '', CURRENT_DATE(), 'M', '', '', 'admin', ?, '');
  ";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sss", $username, $hashed_password, $status);

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt->execute();
  $stmt->close();
}

function modify_admin($uid, $username, $password, $status, $set_password) {
  global $conn;

  // prepare and bind
  $s = '';
  if ($set_password) {
    $s = ', password = ?';
  }
  $query = "
    UPDATE users
    SET
      username = ? $s,
      status = ?
    WHERE
      id = ?
  ";

  $stmt = $conn->prepare($query);

  if ($set_password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sssi", $username, $hashed_password, $status, $uid);
  }
  else
    $stmt->bind_param("ssi", $username, $status, $uid);
  
  $stmt->execute();
  $stmt->close();
}

function modify_user(
  $uid, $username, $password,
  $email, $fname, $lname, $birthdate,
  $gender, $address, $contact, $status, $set_password
) {
  global $conn;

  // prepare and bind
  $s = '';
  if ($set_password) {
    $s = ', password = ?';
  }
  $query = "
    UPDATE users
    SET
      username = ? $s,
      email = ?,
      fname = ?,
      lname = ?,
      birthdate = ?,
      gender = ?,
      address = ?,
      contact = ?,
      status = ?
    WHERE
      id = ?
  ";

  $stmt = $conn->prepare($query);

  if ($set_password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ssssssssssi",
      $username, $hashed_password, $email, $fname, $lname, $birthdate,
      $gender, $address, $contact, $status, $uid
    );
  }
  else
    $stmt->bind_param("sssssssssi",
      $username, $email, $fname, $lname, $birthdate,
      $gender, $address, $contact, $status, $uid
    );
  
  $stmt->execute();
  $stmt->close();
}

function add_airport($name, $place, $status) {
  global $conn;

  // prepare and bind
  $query = "
    INSERT INTO airports(name, place, status)
    VALUES(?, ?, ?);
  ";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sss", $name, $place, $status);

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt->execute();
  $stmt->close();
}

function modify_airport($aid, $name, $place, $status) {
  global $conn;

  // prepare and bind
  $query = "
    UPDATE airports
    SET name = ?, place = ?, status = ?
    WHERE id = ?
  ";

  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssi", $name, $place, $status, $aid);
  $stmt->execute();
  $stmt->close();
}

function add_hotel($name, $address, $price, $place, $status) {
  global $conn;

  // prepare and bind
  $query = "
    INSERT INTO hotels(name, address, price, airport_id, status)
    VALUES(?, ?, ?, ?, ?);
  ";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssdis", $name, $address, $price, $place, $status);
  $stmt->execute();
  $stmt->close();
}

function modify_hotel($hid, $name, $address, $price, $place, $status) {
  global $conn;

  // prepare and bind
  $query = "
    UPDATE hotels
    SET
      name = ?, address = ?, price = ?,
      airport_id = ?, status = ?
    WHERE id = ?
  ";

  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssdisi", $name, $address, $price, $place, $status, $hid);
  $stmt->execute();
  $stmt->close();
}

function add_flight(
  $flight_code, $origin, $destination,
  $departure_time, $arrival_time, $total_seats,
  $price, $price_w_baggage, $price_w_all, $status
) {
  global $conn;

  // prepare and bind
  $query = "
    INSERT INTO flights(
      flight_code, origin_id, destination_id,
      departure_time, arrival_time, total_seats,
      price, price_w_baggage, price_w_all, status
    )
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
  ";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("siissiddds",
    $flight_code, $origin, $destination,
    $departure_time, $arrival_time, $total_seats,
    $price, $price_w_baggage, $price_w_all, $status
  );
  $stmt->execute();
  $stmt->close();

  // get id of last inserted flight
  $query = "SELECT id FROM flights ORDER BY id DESC LIMIT 1";
  $gen_id = $conn->query($query)->fetch_assoc()['id'];
  require('action/seat-generate.php');
}

function modify_flight(
  $fid, $flight_code, $origin, $destination,
  $departure_time, $arrival_time,
  $price, $price_w_baggage, $price_w_all, $status
) {
  global $conn;

  // prepare and bind
  $query = "
    UPDATE flights
    SET
      flight_code = ?,
      origin_id = ?,
      destination_id = ?,
      departure_time = ?,
      arrival_time = ?,
      price = ?,
      price_w_baggage = ?,
      price_w_all = ?,
      status = ?
    WHERE id = ?
  ";

  $stmt = $conn->prepare($query);
  $stmt->bind_param("siissdddsi",
    $flight_code, $origin, $destination,
    $departure_time, $arrival_time,
    $price, $price_w_baggage, $price_w_all, $status, $fid
  );
  $stmt->execute();
  $stmt->close();
}

function add_reservation($arr) {
  global $conn;

  foreach ($arr as $key => $val) {
    $$key = $val;
  }

  foreach($passenger_info as $key => $val) {
    foreach ($val as $field => $info) {
      $$field = $info;
    }

    // insert here
    $query = "
      INSERT INTO reservations(
        user_id, flight_id, seat_id,
        hotel_id, with_tour, flight_type,
        psgr_name, psgr_birthdate,
        departure_date, arrival_date, status, date_reserved, time_reserved
      ) VALUES(
        ?, ?, ?,
        ?, ?, ?,
        ?, ?, ?,
        ?, '1', CURRENT_DATE(), CURRENT_TIME()
      )
    ";

    $birthdate = $birth_year.'-'.$birth_month.'-'.$birth_day;

    $stmt = $conn->prepare($query);

    $user_id = $_SESSION['user_id'];
    $departure_id = $departure_choice['departure_id'];
    $seat_id = $departure_seats[$key];
    $hotel_id = (int)$hotel_id;
    $with_tour = $search_flights['with_tour'];
    $flight_type = $departure_choice['departure_flight_type'];
    $psgr_name = "$fname $lname";
    $set_departure_date = $search_flights['departure_date'];

    $stmt->bind_param("ssssssssss",
      $user_id, $departure_id, $seat_id,
      $hotel_id, $with_tour,
      $flight_type,
      $psgr_name, $birthdate,
      $set_departure_date, $set_departure_date
    );
    $stmt->execute();
    $stmt->close();
  }

  if (isset($return_choice)) {
    foreach($passenger_info as $key => $val) {
      foreach ($val as $field => $info) {
        $$field = $info;
      }

      // insert here
      $query = "
        INSERT INTO reservations(
          user_id, flight_id, seat_id,
          hotel_id, with_tour, flight_type,
          psgr_name, psgr_birthdate,
          departure_date, arrival_date, status, date_reserved, time_reserved
        ) VALUES(
          ?, ?, ?,
          ?, ?, ?,
          ?, ?, ?,
          ?, '1', CURRENT_DATE(), CURRENT_TIME()
        )
      ";

      $birthdate = $birth_year.'-'.$birth_month.'-'.$birth_day;

      $stmt = $conn->prepare($query);

      $user_id = $_SESSION['user_id'];
      $departure_id = $return_choice['return_id'];
      $seat_id = $departure_seats[$key];
      $hotel_id = (int)$hotel_id;
      $with_tour = $search_flights['with_tour'];
      $flight_type = $return_choice['return_flight_type'];
      $psgr_name = "$fname $lname";
      $set_departure_date = $search_flights['return_date'];

      $stmt->bind_param("ssssssssss",
        $user_id, $departure_id, $seat_id,
        $hotel_id, $with_tour,
        $flight_type,
        $psgr_name, $birthdate,
        $set_departure_date, $set_departure_date
      );
      $stmt->execute();
      $stmt->close();
    }

  }
}

function modify_reservation($rid, $status) {
  global $conn;
  
  $sql = "
    UPDATE reservations
    SET status = ?
    WHERE id = ?
  ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $status, $rid);
  $stmt->execute();
  $stmt->close();
}

require('markup/messages.php');
?>