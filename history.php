<?php
session_start();
if (!isset($_SESSION['exotic_inventory'])) {
    $_SESSION['exotic_inventory'] = readInventory();
}
require_once('open-db.php');
include('functions.php');
if (isset($_SESSION['user'])) {
  $services = get_user_serv_history($db, $_SESSION['user']);
}
?>
<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>
<body>
<main id="container" class="cards">
    <?php include('templates/navbar.php'); ?>
    <section id="main-container">
        <?php
        if (!isset($_SESSION['login-type']) || !isset($_SESSION['login']) || $_SESSION['login'] == 'deny') {
            echo "You are not logged in. Please login and try again. Redirecting to the homepage in 3 seconds.";
            header( "refresh:3; url=login_start.php" );
        } else {
            echo "<h2>Service History Page</h2><br>";
            echo '<table>';
            echo '<tr>';
            echo '<th>Service</th>';
            echo '<th>Date</th>';
            echo '<th colspan="2">Comments</th>';
            echo '</tr>';
            foreach ($services as $service) {
              echo "<tr id='row'>";
              echo "<td>";
              echo $service['serv_description'];
              echo "</td>";
              echo "<td>";
              echo date("Y-m-d H:i:s", strtotime($service['appt_time']));
              echo "</td>";
              echo "<td>";
              echo $service['cust_comments'];
              echo "</td>";
              echo "</tr>";
            }
          echo '</table>';
        }
        ?>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>
