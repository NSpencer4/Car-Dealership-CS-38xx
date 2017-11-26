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
    public function submit_service_req($db) {
        $date = datetime($_POST['service_date']);

        $query = "INSERT INTO scores (dateCompleted, score)
              VALUES ('$date', $correct_count)";

        $statement = $db->prepare($query);
        $success = $statement->execute();
        $statement->closeCursor();
    }

    public function getPrevAttempts($db) {
        $query = "SELECT dateCompleted, score from scores";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }
}
