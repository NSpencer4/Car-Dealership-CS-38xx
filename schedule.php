<?php
session_start();
if (!isset($_SESSION['exotic_inventory'])) {
    $_SESSION['exotic_inventory'] = $process->readInventory();
}
if (!isset($_SESSION['exotic_customers'])) {
    $_SESSION['exotic_customers'] = $process->readCustomers();
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
        <?php
        if (!isset($_SESSION['login-type'])) {
            echo "You are not logged in. Please login and try again. Redirecting to the homepage in 3 seconds.";
            header( "refresh:3; url=login_start.php" );
        } else {
            echo "<h2>Scheduling Page</h2><br>";
            echo '<form action="confirmation.php" method="POST">';
            echo '<br><br><input type="text" name="firstname" placeholder="First Name"><br><br>';
            echo '<input type="text" name="lastname" placeholder="Last Name"><br><br>';
            echo '<input type="date" name="date"><br><br>';
            echo '<input type="hidden" name="CarIndex" value="'.$_POST['CarIndex'].'">';
            echo '<input type="submit" class="btn modify" name="Method" value="Reserve">';
            echo '</form>';
        }
        ?>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>
