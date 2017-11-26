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
        echo $_SESSION['exotic_inventory'][$_POST['CarIndex']]['car'];
        ?>
    </title>
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>
<main id="container" class="cards">
    <?php include('templates/header.php'); ?>
        <h1>
          <?php
          echo $_SESSION['exotic_inventory'][$_POST['CarIndex']]['car'];
          ?>
        </h1>
    <section id="main-content-container">
        <div class="cards" id="car-emphasis-container">
          <?php
              echo "<img id='car-emphasis-img' class='car-img' src='".$_SESSION['exotic_inventory'][$_POST['CarIndex']]['image']."'><br>";
              echo '<input type="hidden" name="CarIndex" value="'.$_POST['CarIndex'].'">';
              echo "<h3>".$_SESSION['exotic_inventory'][$_POST['CarIndex']]['price']."</h3>"."<br>";
          ?>
        </div>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>
