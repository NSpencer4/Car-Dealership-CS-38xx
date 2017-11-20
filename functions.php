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
    public function getQs($db) {
        $query = "SELECT questionID, questionText from questions";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }

    public function getAs($db) {
        $query = "SELECT questionID, answerText, correctAnswerText from answers";

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }

    public function populate_not_answered($submission, $answers_arr) {
        $qids = $this->get_q_ids($answers_arr);

        foreach ($qids as $value) {
            if (!isset($submission[$value])) {
                $submission[$value] = "Not answered";
            }
        }

        return $submission;
    }

    public function get_q_ids($arr) {
        $dup_checker = array();
        foreach ($arr as $key=>$answer) {
            $question_id = $answer['questionID'];
            if (!in_array((string)$question_id, $dup_checker)) {
                array_push($dup_checker, (string)$question_id);
            }
        }
        return $dup_checker;
    }

    public function gradeQuiz($submission, $answer_arr) {
        $graded_arr = array();
        $answer_key = $this->create_answer_key($answer_arr);

        foreach ($answer_key as $key=>$answer) {
            if ($submission[$key] == $answer_key[$key]) {
                array_push($graded_arr, "Correct");
            } elseif ($submission[$key] == "Not answered") {
                array_push($graded_arr, "Not answered");
            } else {
                array_push($graded_arr, "Incorrect");
            }
        }

        return $graded_arr;
    }

    public function create_answer_key($answer_arr) {
        $dup_checker = array();
        $answer_key = array();

        foreach ($answer_arr as $key=>$answer) {
            $question_id = $answer['questionID'];
            if (!in_array((string)$question_id, $dup_checker)) {
                array_push($dup_checker, (string)$question_id);
            } else {
                unset($answer_arr[$key]);
            }
            unset($answer_arr[$key]['answerText']);
        }

        foreach ($answer_arr as $answer) {
            $answer_key[(string)$answer['questionID']] = $answer['correctAnswerText'];
        }

        return $answer_key;
    }

    public function saveAttempt($arr, $db) {
        $correct_count = 0;
        foreach ($arr as $result) {
            if ($result == "Correct") {
                $correct_count++;
            }
        }

        $date = date("Y-m-d H:i:s");

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
