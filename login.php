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

        require_once("open-db.php");
        include ("login_functions.php");
        session_start();

        //need to save whether log in is new or existing
        if (isset($_POST['type'])) {
            $_SESSION['login-type'] = $_POST['type'];
            unset($_POST['type']);
        }

        //store cust_email and other info
        if (isset($_POST['cust_email'])) {
            $cust_email = htmlspecialchars($_POST['cust_email']);
        }
        else {
            $cust_email = "";
        }
        if (isset($_POST['cust_name'])) {
            $cust_name = htmlspecialchars($_POST['cust_name']);
        }
        else {
            $cust_name = "";
        }
        if (isset($_POST['cust_address'])) {
            $cust_address = htmlspecialchars($_POST['cust_address']);
        }
        else {
            $cust_address = "";
        }
        if (isset($_POST['cust_phone'])) {
            $cust_phone = htmlspecialchars($_POST['cust_phone']);
        }
        else {
            $cust_phone = "";
        }



        //check cust_email availability
        if (isset($_POST['check_cust_email']) && isset($_POST['cust_email'])) {
            $check = true;  //will need to know if cust_email needs to be put back
            if (existing_cust_email($db, $cust_email)) {
                echo "<script type='text/javascript'>alert('cust_email unavailable.');</script>";
            }
            else {
                echo "<script type='text/javascript'>alert('cust_email is available.');</script>";
            }
            unset($_POST['check_cust_email']);
            unset($_POST['cust_email']);
        }
        else {
            $check = false; //no name in the input box
        }

        //log in existing user
        if ($_SESSION['login-type'] == 'existing') {
            if (isset($_POST['cust_email']) && isset($_POST['cust_password'])) {
                $cust_email = htmlspecialchars($_POST['cust_email']);
                $cust_password = htmlspecialchars($_POST['cust_password']);
                if (verify_login($db, $cust_email, $cust_password)) {
                    $_SESSION['login'] = 'accept_existing';
                    $_SESSION['user'] = $cust_email;
                    header('Location: login_message.php');
                }
                else {
                    $_SESSION['login'] = 'deny';
                    header('Location: login_message.php');
                }
            }
        }
        else {  //create new user
            if (isset($_POST['cust_email']) && isset($_POST['cust_password'])) {
                $cust_email = htmlspecialchars($_POST['cust_email']);
                $cust_password = htmlspecialchars($_POST['cust_password']);

                if (validcust_password($cust_password)) {
                    $cust_password2 = htmlspecialchars($_POST['cust_password2']);
                    if ($cust_password !== $cust_password2) {
                        echo "<script type='text/javascript'>alert('cust_passwords do not match.');</script>";
                    }
                    else  //cust_passwords match
                    {
                        if (existing_cust_email($db, $cust_email)) {
                            echo "<script type='text/javascript'>alert('cust_email unavailable');</script>";
                        }
                        else {  //cust_email available
                            $encrypt_cust_password = password_hash($cust_password, password_DEFAULT);
                            if (addUser($db, $cust_email, $encrypt_cust_password, $cust_name, $lname, $cust_address, $city, $state, $cust_phone)){
                                $_SESSION['login'] = 'accept_new';
                                $_SESSION['user'] = $cust_email;
                                header('Location: login_message.php');
                            }
                            else {
                                echo "<script type='text/javascript'>alert('Unable to create account.');</script>";
                            }
                        }//!existing_cust_email
                    }//cust_passwords match
                }//valid cust_password
                else {    //invalid cust_password
                    echo "<script type='text/javascript'>alert('cust_password must be at least 8 characters and "
                        . "contain at least one number, one uppercase letter, and one lowercase letter');</script>";
                }
            }//isset
        }//else (new user)
        ?>
        <body>
        <header>
            <?php
            if ($_SESSION['login-type'] == "existing"){
                echo "<h1>User Log-In</h1>";
            }
            else {
                echo "<h1>Enter new account information</h1>";
            }
            ?>

        </header>
        <main>
            <form action="" method="post">
                <label for="cust_email" class="login_label">cust_email</label>
                <?php
                echo "<input type='text' name='cust_email' value=$cust_email>";
                if ($_SESSION['login-type'] == "new") {
                    echo '<input type="submit" name="check_cust_email" value="Check cust_email Availability" id="check_button">';
                }
                echo '<br/>';
                ?>
                <label for="cust_password" class="login_label">cust_password</label>
                <input type="cust_password" name="cust_password" value=""><br />
                <?php
                if ($_SESSION['login-type'] == "new"){
                    echo "<label for='cust_password2' class='login_label'>Retype cust_password</label>";
                    echo "<input type='cust_password' name='cust_password2' value=''><br /><br />";

                    echo "<label for='cust_name' class='login_label'>First Name</label>";
                    echo "<input type='text' name='cust_name' value='$cust_name' required><br />";
                    echo "<label for='lname' class='login_label'>Last Name</label>";
                    echo "<input type='text' name='lname' value='$lname' required><br />";
                    echo "<label for='cust_address' class='login_label'>Street cust_address</label>";
                    echo "<input type='text' name='cust_address' value='$cust_address' required ><br />";
                    $submit_value = 'Create Account';
                }
                else {
                    $submit_value = 'Log In';
                }
                echo "<input type='submit' value='$submit_value'>";
                ?>
            </form>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>