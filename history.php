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
        if (!isset($_SESSION['login-type']) || !isset($_SESSION['login']) || $_SESSION['login'] == 'deny') {
            echo "You are not logged in. Please login and try again. Redirecting to the homepage in 3 seconds.";
            header( "refresh:3; url=login_start.php" );
        } else {
            echo "<h2>Service History Page</h2>";
            echo "<p>";
            echo "Hodor, HODOR hodor, hodor hodor... Hodor hodor hodor? Hodor, hodor; hodor hodor, hodor. Hodor hodor... Hodor hodor hodor?! Hodor hodor - hodor... Hodor hodor hodor. Hodor, hodor. Hodor. Hodor, hodor hodor hodor!
            Hodor, HODOR hodor, hodor hodor... Hodor hodor hodor? Hodor, hodor; hodor hodor, hodor. Hodor hodor... Hodor hodor hodor?! Hodor hodor - hodor... Hodor hodor hodor. Hodor, hodor. Hodor. Hodor, hodor hodor hodor!
            Hodor, HODOR hodor, hodor hodor... Hodor hodor hodor? Hodor, hodor; hodor hodor, hodor. Hodor hodor... Hodor hodor hodor?! Hodor hodor - hodor... Hodor hodor hodor. Hodor, hodor. Hodor. Hodor, hodor hodor hodor!
            Hodor, HODOR hodor, hodor hodor... Hodor hodor hodor? Hodor, hodor; hodor hodor, hodor. Hodor hodor... Hodor hodor hodor?! Hodor hodor - hodor... Hodor hodor hodor. Hodor, hodor. Hodor. Hodor, hodor hodor hodor!";
            echo "</p><br>";
        }
        ?>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>
