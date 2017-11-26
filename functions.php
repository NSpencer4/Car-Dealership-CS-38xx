<?php
/**
 * Created by PhpStorm.
 * User: Chase
 * Date: 9/11/2017
 * Time: 11:48 AM
 * This file includes all of the backend functionality of the site
 */
class functions
{
    public function get_appointments($db) {
      $query = "SELECT service_id, appt_time, cust_email, cust_comments from Appointments";

      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $statement->closeCursor();
      return $result;
    }

    public function get_services($db) {
      $query = "SELECT service_id, serv_description from Services";

      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $statement->closeCursor();
      return $result;
    }

    // public function getPrevAttempts($db) {
    //   $date = datetime($_POST['service_date']);
    //
    //   $query = "INSERT INTO scores (dateCompleted, score)
    //         VALUES ('$date', $correct_count)";
    //
    //   $statement = $db->prepare($query);
    //   $success = $statement->execute();
    //   $statement->closeCursor();
    // }
}
