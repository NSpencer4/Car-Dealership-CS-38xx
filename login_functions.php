
  <?php

    function verify_login($db, $cust_email, $cust_password)
    {
      $query = "SELECT cust_password FROM customers WHERE cust_email = :cust_email";
      $statement = $db->prepare($query);
      $statement->bindValue(':cust_email', $cust_email);
      $statement->execute();
      $result = $statement->fetch();
      $statement->closeCursor();
      $hash = $result['cust_password'];
      return password_verify($cust_password, $hash);
    }

    function existing_cust_email($db, $cust_email)
    {
      $query = "SELECT COUNT(cust_email) FROM customers WHERE cust_email = :cust_email";
      $statement = $db->prepare($query);
      $statement->bindValue(':cust_email', $cust_email);
      $statement->execute();
      $exists = $statement->fetch();
      $statement->closeCursor();
      return $exists[0] == 1;
    }

    function addUser($db, $cust_email, $cust_password, $cust_name, $cust_address, $cust_state, $cust_zip, $cust_city, $cust_phone) {
      $query = "INSERT INTO customers (cust_email, cust_password, cust_name, cust_address, cust_city, cust_state, cust_zip, cust_phone)
                VALUES (:cust_email, :cust_password, :cust_name, :cust_address, :cust_city, :cust_state, :cust_zip, :cust_phone)";
      $statement = $db->prepare($query);
      $statement->bindValue(':cust_email', $cust_email);
      $statement->bindValue(':cust_password', $cust_password);
      $statement->bindValue(':cust_name', $cust_name);
      $statement->bindValue(':cust_address', $cust_address);
      $statement->bindValue(':cust_city', $cust_city);
      $statement->bindValue(':cust_state', $cust_state);
      $statement->bindValue(':cust_zip', $cust_zip);
      $statement->bindValue(':cust_phone', $cust_phone);
      $success = $statement->execute();
      $statement->closeCursor();
      return $success;
    }


    function validcust_password($cust_password){
      $valid_pattern = '/(?=^.{8,}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/';
      if (preg_match($valid_pattern, $cust_password))
        return true;
      else
        return false;
    }

?>
