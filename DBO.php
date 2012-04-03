<?php

/**
 * Description of DBO
 *
 * @author cir8
 */
class DBO {

    private $type;
    private $host;
    private $databasename;
    private $username;
    private $password;
    private $path;
    private $tblprefix;
    private $configuration;
    private $connect_status;
    private $errors = array();

    public function __construct($dbConfig) {
        $this->type = $dbConfig->getDbConfig('type');
        $this->host = $dbConfig->getDbConfig('host');
        $this->databasename = $dbConfig->getDbConfig('name');
        $this->username = $dbConfig->getDbConfig('user');
        $this->password = $dbConfig->getDbConfig('pass');
        if ($dbConfig->getDbConfig('path')) {
            $this->path = $dbConfig->getDbConfig('path');
        }
        $this->tblprefix = $dbConfig->getDbConfig('tableprefix');
        //also store copy of dbConfig object
        $this->configuration = $dbConfig;
    }

    public function getDbConfig($setting='') {
        if ($setting) {
            if (isset($this->conf['db'][$setting])) {
                return $this->conf['db'][$setting];
            }
        } else {
            return $this->conf['db'];
        }
    }

    public function connect() {
        return $this->connect_status = mysql_connect($this->host, $this->username, $this->password) or die(mysql_error());
    }

    public function createDB() {
        $query = 'CREATE DATABASE ' . $this->databasename;
        if (!connect()) {
            die('Couldn\'t connect to the named databse.');
            $this->errors[] = 'Failed to connect to the database: ' . $this->databasename;
        }
        if (mysql_query($query, $this->connect())) {
            $this->log[] = 'Database created under the name: ' . $this->databasename;
        } else {
            $this->errors[] = 'Error creating the database: ' . $this->databasename;
        }
    }

    public function createTables() {
        mysql_select_db($this->databasenamename, $this->connect()) or $this->errors[] = mysql_error();
        $sql = 'CREATE TABLE ' . $this->tblprefix . 'user
            (
            id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(id),
            firstname VARCHAR(40),
            surname VARCHAR(40)
            )';
        mysql_query($sql,$this->connect() or $this->errors[] = mysql_error());
        $sql = 'CREATE TABLE ' . $this->tblprefix . 'user_details
            (
            id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(id),
            hashpassword VARCHAR(255),
            email VARCHAR(100),
            location VARCHAR(100),
            user_id INT,
            INDEX (user_id),
            FOREIGN KEY (user_id) REFERENCES '.$this->tblprefix.'user(id)
            )';
        mysql_query($sql,$this->connect() or $this->errors[] = mysql_error());
        $sql = 'CREATE TABLE ' . $this->tblprefix . 'temp_user
            (
            id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(id),
            firstname VARCHAR(40),
            surname VARCHAR(40),
            email VARCHAR(100),
            hashpassword VARCHAR(255),
            unique_id VARCHAR(255)
            )';
        mysql_query($sql,$this->connect() or $this->errors[] = mysql_error());
        $sql = 'CREATE TABLE ' . $this->tblprefix . 'list
            (
            id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(id),
            name VARCHAR(40),
            user_id INT,
            product_id INT,
            FOREIGN KEY (user_id) REFERENCES '.$this->tblprefix.'user(id),
            FOREIGN KEY (product_id) REFERENCES '.$this->tblprefix.'product(id),
            INDEX (user_id, product_id)
            )';
        mysql_query($sql,$this->connect() or $this->errors[] = mysql_error());
        $sql = 'CREATE TABLE ' . $this->tblprefix . 'product
            (
            id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(id),
            title VARCHAR(100),
            img_src VARCHAR(200),
            uid VARCHAR(100)
            )';
        mysql_query($sql,$this->connect() or $this->errors[] = mysql_error());
    }

}

?>
