<?php
/**
 * Created by PhpStorm.
 * User: Chase
 * Date: 9/11/2017
 * Time: 11:48 AM
 * This file includes all of the backend functionality of the site
 */
class process
{
    /**
     * This method reads the inventory file and returns the array
     * @return array the array of inventory
     * @throws Exception Throw exception if the file does not exist
     */
    public function readInventory () {

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

    /**
     * This method reads the customer file and returns the array
     * @return array the array of customers
     * @throws Exception Throw exception if the file does not exist
     */
    public function readCustomers () {
        // Open the file
        $inputFile = fopen("input/customers.txt", "r");

        // Look the file for reading
        flock($inputFile, LOCK_SH);
        if ($inputFile) {
            $count = 0;
            $customerArray = array();
            $tempArr = array();

            // While the file has next
            while (!feof($inputFile)){

                // Get the line
                $line = fgets($inputFile);

                if ($count === 0) {
                    $tempArr['name'] = $line;
                } else if ($count === 1) {
                    $tempArr['phone'] = $line;
                } else if ($count === 2) {
                    $tempArr['date'] = $line;
                } else {
                    $tempArr['car'] = $line;
                    // Add the new customer to customer array
                    array_push($customerArray, $tempArr);
                    // Clear temp array
                    $tempArr = array();
                }

                // Next Line
                $count++;

                // We have reached the 3rd line
                // Reset count for new customer
                if ($count === 4){
                    $count = 0;
                }
            }
            // Unlock the file to prepare for close
            flock($inputFile, LOCK_UN);
            // Close the file
            fclose($inputFile);

            return $customerArray;
        } else {
            throw new Exception("The customer file does not exist!");
        }
    }

    /**
     * This method changes the status of a car both in the array and file
     * @param $carArray the ongoing array for the inventory
     * @param $index the index that is having the status change
     * @param $status the new status of the car
     * @return mixed returns the new session array of inventory
     */
    public function carStatusChange ($carArray, $index, $status) {
        // Update car status in array
        $carArray[$index]['status'] = $status."\n";

        // Clear file
        file_put_contents("input/inventory.txt", "");
        // Update file

        foreach($carArray as $carDetail){
            foreach ($carDetail as $detail) {
                file_put_contents("input/inventory.txt", $detail, FILE_APPEND | LOCK_EX);
            }
        }

        return $carArray;
    }

    /**
     * This method adds customer inquiries to a file
     * @param $fname the first name of the customer
     * @param $lname the last name of the customer
     * @param $date the date the customer wants to reserve the car
     * @param $car the car the customer wants to reserve
     */
    public function add($fname, $lname, $date, $car) {
        $file = 'input/customers.txt';
        file_put_contents($file, $fname."\n", FILE_APPEND | LOCK_EX);
        file_put_contents($file, $lname."\n", FILE_APPEND | LOCK_EX);
        file_put_contents($file, $date."\n", FILE_APPEND | LOCK_EX);
        file_put_contents($file, $car, FILE_APPEND | LOCK_EX);

    }
}