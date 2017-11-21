<?php
/**
 * Created by PhpStorm.
 * User: Chase
 * Date: 9/24/2017
 * Time: 1:19 PM
 */
echo "<header id='form-title-container'>";
echo "<a href='index.php'><img id='logo' src='images/audir8.jpg'></a>";
echo "<h1>BHowdy's Exotic Car Dealership</h1><br>";
echo '<a href="index.php" <button class="btn modify margin-left">Showroom</button></a>';
echo '<a href="schedule.php" <button class="btn modify margin-left">Schedule A Service</button></a>';
echo '<a href="history.php" <button class="btn modify margin-left">Service History</button></a>';
echo '<a href="about.php" <button class="btn modify margin-left">About us</button></a>';
if (!isset($_SESSION['login-type'])) {
    echo '<a href="login_start.php" <button class="btn modify margin-left">Login / Register</button></a>';
}

echo "</header>";