<?php 
require_once "../config/mysql.php";

class Create_Table_Account extends MySQL {
    private $table_name = "user_account";
    private $username = "admin";
    private $password = "admin";
    private $userType = "admin";
    private $hashed_password;

    public function __construct() {
        try {
            // Create table if it doesn't exist
            $create_table_account = "CREATE TABLE IF NOT EXISTS $this->table_name (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                user_type VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            parent::OpenConnection()->exec($create_table_account);
            $this->check_account_if_exist();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            parent::CloseConnection();
        }
    }

    private function check_account_if_exist() {
        // Check if the account exists
        $select_account = "SELECT password FROM $this->table_name WHERE username = :username"; 
        $stmt =  parent::OpenConnection()->prepare($select_account);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the password against the hashed password
            if (password_verify($this->password, $user['password'])) {
                echo "Account exists.<br>";
            }

        }else{
            // If user does not exist, create a new account
            $this->hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
            $insert_account = "INSERT INTO $this->table_name (username, password, user_type) VALUES (:name, :hashed_password, :type)";
            $stmt =  parent::OpenConnection()->prepare($insert_account);
            $stmt->bindParam(':name', $this->username);
            $stmt->bindParam(':hashed_password', $this->hashed_password);
            $stmt->bindParam(':type', $this->userType);
            $stmt->execute();
        }
    }
}
// comment this Create_Table_Account(); if don't want to create a user_account table 
new Create_Table_Account();
