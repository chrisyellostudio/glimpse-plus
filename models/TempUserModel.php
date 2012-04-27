<?php

include 'DBO.php';

/**
 * Model class for the
 *
 * @param 
 * @author cir8
 */
class TempUserModel {

    private $db;

    public function __construct($dbConfig) {
        $this->db = DBO::getInstance($application);
    }

    public function insertTempUser($valuesArray = array()) {
        
    }

    public function upsertTempUser($valuesArray = array()) {
        
    }

    public function selectTempUser($email = '') {
        
    }

    public function deleteTempUser($email = '') {
        
    }

}

?>
