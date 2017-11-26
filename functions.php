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

    public function get_appointment_times($db, $appointments) {
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

    public function submit_service_req($db, $form) {
      $appointments = $this->get_appointments($db);
      $available_times = $this->get_appointment_times($db, $appointments);
      print_r($available_times);
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

    public function get_user_serv_history ($db, $user){
      $query = "SELECT Appointments.service_id, Appointments.appt_time, Appointments.cust_comments, Services.serv_description FROM Appointments
                INNER JOIN Services ON Services.service_id=Appointments.service_id;
                ORDER BY Appointments.appt_time";
      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $statement->closeCursor();
      return $result;
    }
}
