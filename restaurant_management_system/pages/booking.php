<?php
// Database connection
include "../config.php";
if (isset($_POST["submit"])) {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $number = $_POST['guests'];
  $request = $_POST['special'];

  $sql = "INSERT INTO booking (name, phone, guest, time, date, special) VALUES ('$name', '$phone', '$number', '$time', '$date', '$request')";

  if (mysqli_query($connection, $sql)) {
    echo "<script>alert('Submitted Successfully')</script>";
  } else {
    echo "<script>alert('Submission Failed')</script>";
  }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Restaurant Table Booking</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    box-sizing: border-box;
  }

  input[type='submit'] {
    cursor: pointer;
  }

  .root {
    display: flex !important;
    box-shadow: 2px 2px 8px gainsboro;
    width: fit-content;
    border-radius: 8px;
    margin: auto;
  }

  form {
    display: flex;
    flex-direction: column;
    padding: 12px;
    width: 350px;
  }

  input,
  textarea {
    padding: 4px;
    font-size: 1.2rem;
    border: 2px solid gainsboro;
  }

  h2 {
    text-align: center;
  }
</style>

<body>
  <div class="">
    <h2>Book Table</h2>
    <div class="root">
      <div class="img left">
        <img src="../images/restaurant.jpg" alt="Restaurant Image" width="350px">
      </div>
      <div class="right">
        <form method="post" action="">
          <input type="text" placeholder="Full name" id="name" name="name" required><br>

          <input type="tel" id="phone" placeholder="Phone" name="phone" required><br>

          <input type="date" id="date" min="2024-07-28" max="2024-12-30" name="date" required><br>

          <input type="time" id="time" name="time" required><br>

          <input type="number" id="guests" placeholder="4" name="guests" min="1" max="10" required><br>

          <textarea id="special" name="special" rows="4" placeholder="Any special requests..."></textarea><br>

          <input type="submit" name="submit" value="Book Table">
        </form>
      </div>
    </div>
  </div>
</body>

</html>