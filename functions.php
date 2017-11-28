<?php
/**
 * Created by PhpStorm.
 * User: Chase
 * Date: 9/11/2017
 * Time: 11:48 AM
 * This file includes all of the backend functionality of the site
 */
/**
* This function queries the database for all of the appointments
* @return array the array of appointments
*/
function get_appointments($db) {
  $query = "SELECT service_id, appt_time, cust_email, cust_comments from Appointments";

  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $result;
}

/**
 * This function queries the database for all of the services
 * @return array the array of services
 */
function get_services($db) {
  $query = "SELECT service_id, serv_description from Services";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $result;
}

/**
 * This function makes a list of available appointment times
 * @return array the array of available appointment times
 */
function get_appointment_times($db, $appointments) {
  $unavailable_times = array();
  $available_times = array();
  foreach ($appointments as $appointment) {
    array_push($unavailable_times, date("Y-m-d H:i:s", strtotime($appointment['appt_time'])));
  }
  foreach ($unavailable_times as $unavailable_time) {
    $possible_time = date("Y-m-d H:i:s", strtotime($unavailable_time . "+1 hour"));
    if (!in_array($possible_time, $unavailable_times)) {
      array_push($available_times, $possible_time);
    }
  }
  return $available_times;
}

/**
 * This function will insert into the database the service request
 * @return sucess which is the status of the insert to the database
 */
function submit_service_req($db, $form) {
  $appointments = get_appointments($db);
  $available_times = get_appointment_times($db, $appointments);
  $query = "INSERT INTO Appointments (service_id, appt_time, cust_email, cust_comments)
        VALUES (:service_id, :appt_time, :cust_email, :cust_comments)";
  $statement = $db->prepare($query);
  $statement->bindValue(':service_id', $form['service']);
  $statement->bindValue(':appt_time', $available_times[$form['service_date']]);
  $statement->bindValue(':cust_email', $form['cust_email']);
  $statement->bindValue(':cust_comments', $form['cust_comments']);
  $success = $statement->execute();
  $statement->closeCursor();
  return $success;
}

/**
 * This method reads the inventory file and returns the array
 * @return array the array of inventory
 * @throws Exception Throw exception if the file does not exist
 */
function get_user_serv_history ($db, $user){
  $query = "SELECT Appointments.service_id, Appointments.appt_time, Appointments.cust_comments, Services.serv_description FROM Appointments
            INNER JOIN Services ON Services.service_id=Appointments.service_id
            WHERE (Appointments.cust_email='$user')
            ORDER BY Appointments.appt_time";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $statement->closeCursor();
  return $result;
}

/**
 * This method reads the inventory file and returns the array
 * @return array the array of inventory
 * @throws Exception Throw exception if the file does not exist
 */
function readInventory () {

    // Open the file
    $inputFile = fopen("input/inventory.txt", "r");


    // Look the file for reading
    flock($inputFile, LOCK_SH);

    if ($inputFile) {
        $count = 0;
        $inventoryArray = array();
        $tempArr = array();

        // While the file has next
        while (!feof($inputFile)){

            // Get the line
            $line = fgets($inputFile);

            if ($count === 0) {
                $tempArr['car'] = $line;
            } else if ($count === 1) {
                $tempArr['price'] = $line;
            } else if ($count === 2) {
                $tempArr['image'] = $line;
            } else {
                $tempArr['status'] = $line;
                array_push($inventoryArray, $tempArr);

                // Clear temp array
                $tempArr = array();
            }

            // Next Line
            $count++;

            // We have reached the 3rd line
            // Reset count for new car
            if ($count === 4){
                $count = 0;
            }
        }
        // Unlock the file to prepare for close
        flock($inputFile, LOCK_UN);
        // Close the file
        fclose($inputFile);

        return $inventoryArray;
    } else {
        throw new Exception("The inventory file does not exist!");
    }
}
