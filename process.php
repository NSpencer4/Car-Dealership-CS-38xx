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
}
