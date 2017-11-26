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
        <h2>About Us</h2>
        <h3>Nicholas Spencer</h3>
        <p>
            I worked on the backend logic for the reserve process the included reading and writing to the appropriate
            files and connecting the user interface to the backend logic.
        </p><br>
        <h3>Brandon Howard</h3>
        <p>
            Front end design along with wrote the templates needed to reading and writing from
            a file. Wrote the read customers function where it reads the customer information
            that is stored into a session array.
        </p><br>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>