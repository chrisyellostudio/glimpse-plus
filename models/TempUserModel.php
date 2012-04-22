<?php

include 'DBO.php';

/**
 * Model class for the
 *
 * @param 
 * @author cir8
 */
class TempUserModel extends DBO {

    private $db;

    public function __construct($dbConfig) {
        $this->db = parent::getInstance($application);
        }

    public function insertTempUser($valuesArray = array()) {
        mysql_select_db($this->db->databasenamename, $this->db->connect()) or array_push($this->errors, mysql_error());
        $sql = 'INSERT INTO table_name (firstname, surname, email, hashpassword, unique_id)
                VALUES (' . implode(",", $valuesArray) . ')';
        return mysql_query($sql, $this->db->connect() or array_push($this->errors, mysql_error()));
    }

    public function upsertTempUser($valuesArray = array()) {
        mysql_select_db($this->db->databasenamename, $this->db->connect()) or array_push($this->errors, mysql_error());
        $result = $this->selectTempUser($valuesArray[2]);
        if($result){
            $result = insertTempUser($valuesArray);
        }
        return $result;
    }

    public function selectTempUser($email = '') {
        mysql_select_db($this->db->databasenamename, $this->db->connect()) or array_push($this->errors, mysql_error());
        $sql = 'INSERT INTO table_name (firstname, surname, email, hashpassword, unique_id)
                VALUES (' . implode(",", $valuesArray) . ')';
        return mysql_query($sql, $this->db->connect() or array_push($this->errors, mysql_error()));
    }

    public function deleteTempUser($email = '') {
        mysql_select_db($this->db->databasenamename, $this->db->connect()) or array_push($this->errors, mysql_error());
        $sql = '';
    }

}

?>
