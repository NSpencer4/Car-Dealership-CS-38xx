<?php
session_start();
if (!isset($_SESSION['exotic_inventory'])) {
    $_SESSION['exotic_inventory'] = readInventory();
}


$services = get_services($db);
$appointments = get_appointments($db);
submit_service_req($db, $_POST);
?>
<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>
<body>
<main id="container" class="cards">
    <?php include('templates/navbar.php'); ?>
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
