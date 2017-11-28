<?php
session_start();
if (!isset($_SESSION['exotic_inventory'])) {
    $_SESSION['exotic_inventory'] = readInventory();
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

        require_once("open-db.php");
        include ("login_functions.php");

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
        if (isset($_POST['cust_city'])) {
            $cust_city = htmlspecialchars($_POST['cust_city']);
        }
        else {
            $cust_city = "";
        }
        if (isset($_POST['cust_state'])) {
            $cust_state = htmlspecialchars($_POST['cust_state']);
        }
        else {
            $cust_state = "";
        }
        if (isset($_POST['cust_zip'])) {
            $cust_zip = htmlspecialchars($_POST['cust_zip']);
        }
        else {
            $cust_zip = "";
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
                            $encrypt_cust_password = password_hash($cust_password, PASSWORD_DEFAULT);
                            if (addUser($db, $cust_email, $encrypt_cust_password, $cust_name, $cust_address, $cust_zip, $cust_city, $cust_state, $cust_phone)){
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
              <label for="cust_email" class="login_label"  id='s1' >Email</label>
                <?php
                echo "<input type='text' name='cust_email' class='login_input' id='s2' value=$cust_email > ";
                echo '<br/>';
                ?>
                <label for="cust_password" class="login_label"  id='s3'>Password</label>
                <input type="password" name="cust_password" value="" class='login_input' id='s4'><br />
                <?php
                if ($_SESSION['login-type'] == "new"){
                    echo "<label for='cust_password2' class='login_label'  id='s5'>Retype Password</label>";
                    echo "<input type='password' name='cust_password2' class='login_input' id='s6' value=''><br /><br />";

                    echo "<label for='cust_name' class='login_label'  id='s7'>Name</label>";
                    echo "<input type='text' name='cust_name' value='$cust_name' class='login_input'  id='s8' required><br />";
                    echo "<label for='cust_address' class='login_label'  id='s9'>Street Address</label>";
                    echo "<input type='text' name='cust_address' value='$cust_address' class='login_input'  id='s10' required ><br />";
                    echo "<label for='cust_state' class='login_label'  id='s11'>State</label>";
                    echo "<input type='text' name='cust_state' value='$cust_state' class='login_input'  id='s13' required ><br />";
                    echo "<label for='cust_city' class='login_label'  id='s14'>City</label>";
                    echo "<input type='text' name='cust_city' value='$cust_city' class='login_input'  id='s15' required ><br />";
                    echo "<label for='cust_zip' class='login_label'  id='s16'>Zip</label>";
                    echo "<input type='text' name='cust_zip' value='$cust_zip' class='login_input'  id='s17' required ><br />";
                    echo "<label for='cust_phone' class='login_label'  id='s18'>Phone Number</label>";
                    echo "<input type='text' name='cust_phone' value='$cust_phone' class='login_input'  id='s19' required ><br />";
                    $submit_value = 'Create Account';
                }
                else {
                    $submit_value = 'Log In';
                }
                echo "<input type='submit' id='s20' value='$submit_value'>";
                ?>
            </form>
    </section>
    <?php include('templates/footer.php'); ?>
</main>
</body>
</html>
