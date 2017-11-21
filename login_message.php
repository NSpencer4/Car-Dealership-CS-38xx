<?php
session_start();
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = $process->readInventory();
}
if (!isset($_SESSION['customers'])) {
    $_SESSION['customers'] = $process->readCustomers();
}
$login_status = $_SESSION['login'];
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
        <?php
          if ($login_status == 'accept_existing') {
            echo "<h1>Login successful!</h1>";
          }
           if ($login_status == 'accept_new') {
            echo "<h1>Your account has been created.</h1>";
          }
          else if ($login_status == 'deny'){
            echo "<h1>Login failed.</h1>";            
          }
          echo "You will be redirected to the home page in 5 seconds.";
          header( "refresh:5; url=index.php" );
        ?>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>