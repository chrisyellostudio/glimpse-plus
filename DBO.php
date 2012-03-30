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
        mysql_connect($this->host, $this->username, $this->password) or die(mysql_error());
        mysql_select_db($this->databasenamename) or die(mysql_error());
    }

}

?>
