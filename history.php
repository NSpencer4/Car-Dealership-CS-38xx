<?php
session_start();
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = $process->readInventory();
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
        <?php
        if (!isset($_SESSION['login-type'])) {
            echo "You are not logged in. Please login and try again. Redirecting to the homepage in 3 seconds.";
            header( "refresh:3; url=index.php" );
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