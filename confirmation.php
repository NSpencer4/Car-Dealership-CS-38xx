<?php
session_start();
if (!isset($_SESSION['exotic_inventory'])) {
    $_SESSION['exotic_inventory'] = $process->readInventory();
}
require_once('functions.php');
require_once('open-db.php');
$functions = new functions();
$services = $functions->get_services($db);
$appointments = $functions->get_appointments($db);
$functions->submit_service_req($db, $_POST);
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
        echo "Your service appointment has been scheduled. You will now be redirected to the homepage.";
        header( "refresh:3; url=index.php" );
        ?>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>
