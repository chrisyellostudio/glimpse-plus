<?php

/**
 * Description of UserModel
 *
 * @author cir8
 */
class UserModel {

    private $app;
    private $db;
    public $errors = array();

    public function __construct($application) {
        $this->app = $application;
        $this->db = new DBO($application);
    }

    public function insertUser($valuesArray) {
        $conn = mysql_connect($this->db->host, $this->db->username, $this->db->password);
        mysql_select_db($this->db->databasenamename, $conn) or array_push($this->errors, mysql_error());
        $sql = 'INSERT INTO `' . $this->db->databasename . '`.`' . $this->db->tblprefix . 'users`
                (firstname, surname, email, hashpassword, unique_id)
                VALUES (' . implode(",", $valuesArray) . ')';
        $result = mysql_query($sql, $conn) or array_push($this->errors, mysql_error());
        if (!$result) {
            return false;
        } else {
            return true;
        }
    }

    public function checkUser($email) {
        $conn = $this->db->connect();
        if ($conn) {
            $this->db->selectDB();
            $sql = 'SELECT `users_id` 
                    FROM `' . $this->db->databasename . '`.`' . $this->db->tblprefix . 'user_crucials`
                    WHERE `email` = "' . $email . '"';
            $result = mysql_query($sql, $conn) or array_push($this->errors, mysql_error());
            if ($result) {
                $count = mysql_num_rows($result);
                if ($count == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    /**
     *
     * @param type $email
     * @return type 
     */
    public function getUserName($email) {
        $conn = mysql_connect($this->db->host, $this->db->username, $this->db->password);
        mysql_select_db($this->db->databasename, $conn) or array_push($this->errors, mysql_error());
        $sql = 'SELECT a.firstname
                FROM `' . $this->db->databasename . '`.`' . $this->db->tblprefix . 'users` a,
                `' . $this->db->databasename . '`.`' . $this->db->tblprefix . 'user_crucials` b
                WHERE b.`email` = "' . $email . '"';

        $result = mysql_query($sql, $conn) or array_push($this->errors, mysql_error());
        $row = mysql_fetch_assoc($result);
        return $row['firstname'];
    }

    /**
     *
     * @param type $email
     * @return type 
     */
    public function getUserType($email){
        $conn = mysql_connect($this->db->host, $this->db->username, $this->db->password);
        mysql_select_db($this->db->databasename, $conn) or array_push($this->errors, mysql_error());
        $sql = 'SELECT a.type
                FROM `' . $this->db->databasename . '`.`' . $this->db->tblprefix . 'user_details` a,
                `' . $this->db->databasename . '`.`' . $this->db->tblprefix . 'user_crucials` b
                WHERE b.`email` = "' . $email . '"';

        $result = mysql_query($sql, $conn) or array_push($this->errors, mysql_error());
        $row = mysql_fetch_assoc($result);
        return $row['type'];        
    }
    
    
    public function deleteUser($email) {
        
    }

}

?>
