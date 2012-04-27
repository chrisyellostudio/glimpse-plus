<?php

/**
 * Description of DBO
 *
 * @author cir8
 */
class DBO {

    public $type;
    public $host;
    public $databasename;
    public $username;
    public $password;
    public $tblprefix;
    public $connect_status;
    private static $instance;
    private $errors = array();
    private $app;

    public function __construct($application) {
        $this->app = $application;
        $this->init();
    }

    public function init() {
        $this->type = $this->app->getDBConfig('type');
        $this->collation = $this->app->getDBConfig('collation');
        $this->host = $this->app->getDBConfig('host');
        $this->databasename = $this->app->getDBConfig('databasename');
        $this->username = $this->app->getDBConfig('username');
        $this->password = $this->app->getDBConfig('password');
        $this->tblprefix = $this->app->getDBConfig('tblprefix');

        if (!$this->dbExists()) {
            $this->connect();
            $this->createDB();
        } else {
            $this->connect();
        }
    }

    public static function getInstance($application) {
        if (!isset(self::$instance)) {
            //Creates new instance
            $className = __CLASS__;
            self::$instance = new $className($application);
        }
        return self::$instance;
    }

    public function dbExists() {
        $sql = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "' . $this->databasename . '"';
        $result = mysql_query($sql, mysql_connect($this->host, $this->username, $this->password));
        if (mysql_num_rows($result) == 0) {
            return false;   //DB does exist, return false
        } else {
            return true;
        }
    }

    public function connect() {
        $this->connect_status = mysql_connect($this->host, $this->username, $this->password) or array_push($this->errors, mysql_error());
        if ($this->connect_status) {
            $this->app->setDBConfig('connect_status', 'Connected');
        } else {
            $this->app->setDBConfig('connect_status', 'Connection Failed');
        }

        return $this->connect_status;
    }

    public function queryDB($query) {
        $conn = mysql_connect($this->host, $this->username, $this->password);
        mysql_query($query, $conn) or array_push($this->errors, mysql_error());
    }

    public function selectDB() {
        $conn = mysql_connect($this->host, $this->username, $this->password);
        mysql_select_db($this->databasename, $conn) or array_push($this->errors, mysql_error());
    }

    public function createDB() {
        $sql = 'CREATE DATABASE IF NOT EXISTS ' . $this->databasename;
        $this->queryDB($sql);
        $this->createTables();
    }

    public function destroyDB() {
        if ($this->dbExists()) {
            $this->dropTables();
            $this->selectDB();
            $sql = 'DROP DATABASE ' . $this->databasename;
            $this->queryDB($sql);
        }
        $this->returnErrors();
    }

    public function dropTables() {
        $this->selectDB();
        $sql = 'DROP TABLE IF EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'user_details`;
                DROP TABLE IF EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'user_crucial`;
                DROP TABLE IF EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'user_lists`;
                DROP TABLE IF EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'users`;
                DROP TABLE IF EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'products`;                 
                DROP TABLE IF EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'temp_users`';
        $this->queryDB($sql);

        $this->returnErrors();
    }

    public function returnErrors() {
        if (sizeof($this->errors) >= 1) {
            print_r($this->errors);
        }
    }

    public function createTables() {
        if ($this->dbExists()) {
            $this->selectDB();
            $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'users` (
            `id` INT NOT NULL AUTO_INCREMENT, 
            `firstname` VARCHAR(40) NOT NULL,
            `surname` VARCHAR(40) NOT NULL,
            PRIMARY KEY(`id`));';
            $this->queryDB($sql);
            $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'user_details` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `users_id` INT NOT NULL ,
            `town` VARCHAR(45) NULL ,
            `postcode` VARCHAR(11) NULL ,
            `country` VARCHAR(45) NOT NULL ,
            `type` VARCHAR(45) NOT NULL ,
            PRIMARY KEY (`id`, `users_id`) ,
            INDEX `fk_user_details_users` (`users_id` ASC) ,
            CONSTRAINT `fk_user_details_users`
              FOREIGN KEY (`users_id` )
              REFERENCES `' . $this->databasename . '`.`' . $this->tblprefix . 'users` (`id` )
              ON DELETE NO ACTION
              ON UPDATE NO ACTION);';
            $this->queryDB($sql);
            $sql = 'CREATE  TABLE IF NOT EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'user_crucials` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `users_id` INT NOT NULL ,
            `hashed_password` VARCHAR(256) NOT NULL ,
            `email` VARCHAR(100) NOT NULL ,
            PRIMARY KEY (`id`, `users_id`),
            UNIQUE KEY (`email`),
            INDEX `fk_user_crucial_users` (`users_id` ASC),
            CONSTRAINT `fk_user_crucial_users`
                FOREIGN KEY (`users_id`)    
                REFERENCES `' . $this->databasename . '`.`' . $this->tblprefix . 'users` (`id` )
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);';
            $this->queryDB($sql);
            $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'products` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `query_string` VARCHAR(255) NOT NULL ,
            `uid` VARCHAR(45) NOT NULL ,
            `title` VARCHAR(100) NOT NULL ,
            PRIMARY KEY (`id`),
            UNIQUE KEY (`uid`));';
            $this->queryDB($sql);
            $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'temp_users` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `firstname` VARCHAR(45) NULL ,
            `surname` VARCHAR(45) NULL ,
            `email` VARCHAR(45) NULL ,
            `hashed_password` VARCHAR(45) NULL ,
            `unique_id` VARCHAR(256) NULL ,
            PRIMARY KEY (`id`) ,
            UNIQUE KEY (`email`),
            UNIQUE KEY (`unique_id`));';
            $this->queryDB($sql);
            $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->databasename . '`.`' . $this->tblprefix . 'user_lists` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `users_id` INT NOT NULL,
            `product_id` INT NOT NULL,
            `name` VARCHAR(45) NOT NULL,
            `desc` VARCHAR(100) NOT NULL,
            PRIMARY KEY (`id`, `users_id`, `product_id`),
            INDEX `fk_user_lists_users` (`users_id` ASC),
            INDEX `fk_user_lists_product` (`product_id` ASC),
            CONSTRAINT `fk_user_lists_users`
                FOREIGN KEY (`users_id` )
                REFERENCES `' . $this->databasename . '`.`' . $this->tblprefix . 'users` (`id` )
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
            CONSTRAINT `fk_user_lists_product`
                FOREIGN KEY (`product_id`)
                REFERENCES `' . $this->databasename . '`.`' . $this->tblprefix . 'products` (`id` )
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);';
            $this->queryDB($sql);


            $this->returnErrors();
        }
    }

}

?>
