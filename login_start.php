<?php
session_start();
if (!isset($_SESSION['exotic_inventory'])) {
    $_SESSION['exotic_inventory'] = $process->readInventory();
}
if (!isset($_SESSION['customers'])) {
    $_SESSION['customers'] = $process->readCustomers();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>BHowdy's Exotic Car Dealership</title>
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>
<body>
<main id="container" class="cards">
    <?php include('templates/header.php'); ?>
    <section id="main-container">
        
        <form action="login.php" method="post">
          <input type="radio" name="type" value="existing" id="existing">
          <label for="existing">I have an account.</label><br>
          <input type="radio" name="type" value="new" id="new" checked>
          <label for="new">I need to create an account</label><br>
          <input type="submit" value="Go"> 
        </form>

        </section>
        <?php include('templates/footer.php'); ?>
    </main>
  </body>
</html>