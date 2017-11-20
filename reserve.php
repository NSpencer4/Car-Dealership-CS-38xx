<?php
session_start();
require_once('process.php');
$process = new process();
?>

<!DOCTYPE html>
<html>
<head>
  <title>
    <?php
    echo $_SESSION['inventory'][$_POST['CarIndex']]['car'];
    ?>
  </title>
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>
<main id="container" class="cards">
    <?php include('templates/header.php'); ?>
  <section id="main-content-container">
    <div class="cards" id="car-reserve-container">
      <?php
      echo "<h1>"."Reserve Your Future " . $_SESSION['inventory'][$_POST['CarIndex']]['car']."</h1>";
      echo "<img id='car-reserve-img' class='car-img' src='".$_SESSION['inventory'][$_POST['CarIndex']]['image']."'><br>";
      echo '<form action="index.php" method="POST">';
      ?>
      <br><br><input type="text" name="firstname" placeholder="First Name"><br><br>
      <input type="text" name="lastname" placeholder="Last Name"><br><br>
      <input type="date" name="date"><br><br>
      <?php
      echo '<input type="hidden" name="CarIndex" value="'.$_POST['CarIndex'].'">';
      echo '<input type="submit" class="btn modify" name="Method" value="Reserve">';
      echo '</form>';
      ?>
    </div>
  </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>