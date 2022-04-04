<?php
    class User {
             // Database Connection & Table name 

        private $conn;
        private $table = "users";


        // object properties 

        public $id;
        public $firstname;
        public $lastname;
        public $email;
        public $password;

        // Constructor with DataBase
        public function __construct($db)
        {
            $this->conn = $db;
        }

        // create new user 

        public function createUser() {
                // insert query
            $query = "INSERT INTO " .$this->table_name ."
            SET 
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                password = :password";

           // Prepare statement
              $stmt = $this->conn->prepare($query);

           // sanitize
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));

            // bind the values
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':email', $this->email);


            // hash the password before saving to database
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);

         // Execute query (and check if the query was succf)
          if($stmt->execute()) {
            return true;
          }
            // print error 

                printf("ERROR 404", $stmt->error);

            return false;
    }


        


}
?>

