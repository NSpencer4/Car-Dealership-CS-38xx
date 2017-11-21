
  <?php 
    
    function verify_login($db, $username, $password)
    {
      $query = "SELECT password FROM customers WHERE username = :user";
      $statement = $db->prepare($query);
      $statement->bindValue(':user', $username);
      $statement->execute();
      $result = $statement->fetch();
      $statement->closeCursor();
      $hash = $result['password'];
      return password_verify($password, $hash);
    }
    
    function existing_username($db, $username)
    {
      $query = "SELECT COUNT(username) FROM customers WHERE username = :username";
      $statement = $db->prepare($query);
      $statement->bindValue(':username', $username);
      $statement->execute();
      $exists = $statement->fetch();
      $statement->closeCursor();
      return $exists[0] == 1;
    }

    function addUser($db, $cust_email, $cust_password, $cust_name, $cust_address, $cust_phone) {
      $query = "INSERT INTO customers (cust_email, cust_password, cust_name, cust_address, cust_phone)
                VALUES (:cust_email, :cust_password, :cust_name, :cust_address, :cust_phone)";
      $statement = $db->prepare($query);
      $statement->bindValue(':cust_email', $cust_email);
      $statement->bindValue(':cust_password', $cust_password);
      $statement->bindValue(':cust_name', $cust_name);
      $statement->bindValue(':cust_address', $cust_address);
      $statement->bindValue(':$cust_phone', $cust_phone);
      $success = $statement->execute();
      $statement->closeCursor();     
      return $success;
    }
    
     
    function validPassword($password){
      $valid_pattern = '/(?=^.{8,}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/';
      if (preg_match($valid_pattern, $password))
        return true;
      else
        return false;
    }

?>
