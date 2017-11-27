<?php
session_start();
require_once('functions.php');
$functions = new functions();
?>
<!DOCTYPE html>
<html>
<?php include('templates/navbar.php'); ?>
<body>
<main id="container" class="cards">
    <?php include('templates/navbar.php'); ?>
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
