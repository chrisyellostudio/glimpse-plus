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
    private static $instance;
    private $errors = array();
    private $log = array();
    private $app;

    public function __construct($application) {
        $this->app = $application;
        $this->dbConfig();
    }

    /**
     * Creates the database config for the application.
     * 
     */
    public function dbConfig() {
        $this->type = $this->app->getDBConfig('type');
        $this->collation = $this->app->getDBConfig('collation');
        $this->host = $this->app->getDBConfig('host');
        $this->databasename = $this->app->getDBConfig('databasename');
        $this->username = $this->app->getDBConfig('username');
        $this->password = $this->app->getDBConfig('password');
        $this->tblprefix = $this->app->getDBConfig('btlprefix');
    }

    public static function getInstance($application) {
        if (!isset(self::$instance)) {
            //Creating new instance
            $className = __CLASS__;
            self::$instance = new $className($application);
        }
        return self::$instance;
    }

    /**
     *
     * @return bool
     */
    public function dbExists() {
        $sql = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "' . $this->dabasename . '"';
        $result = mysql_query($sql, $this->connect() or array_push($this->errors, mysql_error()));
        if (mysql_num_rows($result) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function connect() {
        return $this->connect_status = mysql_connect($this->host, $this->username, $this->password) or die(mysql_error());
    }

    public function createDB() {
        $query = 'CREATE DATABASE IF NOT EXISTS ' . $this->databasename;
        if (!connect()) {
            array_push($this->errors, 'Failed to connect to the database: ' . $this->databasename);
        }
        if (mysql_query($query, $this->connect())) {
            array_push($this->log, 'Database created under the name: ' . $this->databasename);
        } else {
            array_push($this->errors, 'Error creating the database: ' . $this->databasename);
        }
    }

    public function createTables() {
        mysql_select_db($this->databasenamename, $this->connect()) or $this->errors[] = mysql_error();
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->tblprefix . 'user
            (
            id INT NOT NULL AUTO_INCREMENT, 
            firstname VARCHAR(40),
            surname VARCHAR(40),
            PRIMARY KEY(id),
            )';
        mysql_query($sql, $this->connect() or array_push($this->errors, mysql_error()));
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->tblprefix . 'user_details
            (
            id INT NOT NULL AUTO_INCREMENT, 
            hashpassword VARCHAR(255),
            user_type VARCHAR(40),
            email VARCHAR(100),
            location VARCHAR(100),
            user_id INT,
            PRIMARY KEY(id),
            INDEX (user_id),
            UNIQUE KEY (email),
            FOREIGN KEY (user_id) REFERENCES ' . $this->tblprefix . 'user(id)
            )';
        mysql_query($sql, $this->connect() or array_push($this->errors, mysql_error()));
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->tblprefix . 'temp_user
            (
            id INT NOT NULL AUTO_INCREMENT, 
            firstname VARCHAR(40),
            surname VARCHAR(40),
            email VARCHAR(100),
            hashpassword VARCHAR(255),
            unique_id VARCHAR(255),
            PRIMARY KEY(id),
            UNIQUE KEY (email),
            UNIQUE KEY (unique_id)
            )';
        mysql_query($sql, $this->connect() or array_push($$this->errors, mysql_error()));
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->tblprefix . 'list
            (
            id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(id),
            name VARCHAR(40),
            user_id INT,
            product_id INT,
            FOREIGN KEY (user_id) REFERENCES ' . $this->tblprefix . 'user(id),
            FOREIGN KEY (product_id) REFERENCES ' . $this->tblprefix . 'product(id),
            INDEX (user_id, product_id)
            )';
        mysql_query($sql, $this->connect() or array_push($this->errors, mysql_error()));
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->tblprefix . 'product
            (
            id INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(id),
            title VARCHAR(100),
            img_src VARCHAR(200),
            uid VARCHAR(100),
            UNIQUE KEY (uid)
            )';
        mysql_query($sql, $this->connect() or array_push($this->errors, mysql_error()));
    }

}

?>
