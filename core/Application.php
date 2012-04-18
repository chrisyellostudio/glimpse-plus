<?php

/**
 * Description of Application
 *
 * @author cir8
 */
global $instance;

include 'libs/geoip.inc';
include '/controllers/DBO.php';

class Application {
    const BASE_DIR = '/';
    const LIBS_DIR = 'libs/';
    const MODELS_DIR = 'models/';
    const CONT_DIR = 'controllers/';
    const STYLE_DIR = 'styles/';
    const IMG_DIR = 'imgs/';
    const TEST_DIR = 'test/';

    public $availcountries = array('US', 'GB', 'AU', 'DE', 'FR', 'JP', 'CN', 'IT', 'NL', 'ES');
    public $countrycurrencycode = array('US' => 'USD', 'GB' => 'GBP', 'AU' => 'AUD', 'DE' => 'EUR', 'FR' => 'EUR',
        'JP' => 'JPY', 'CN' => 'CNY', 'IT' => 'EUR', 'NL' => 'EUR', 'ES' => 'EUR');
    public $countrycurrency = array('USD' => 'US Dollars', 'GBP' => 'British Sterling',
        'AUD' => 'Australian Dollar', 'EUR' => 'Euros', 'JP' => 'Japanese Yen', 'CNY' => 'Yuan Renminbi',
        'HKD' => 'Hong Kong Dollar');
    public $errors = array();
    public $warnings = array();
    public $configuration;
    public $db;
    public $gi;
    public $ip;

    /**
     * Loads libraries used in the Class and load global configuration.
     * 
     */
    public function __construct() {
        $this->gi = geoip_open('libs/GeoIP.dat', GEOIP_MEMORY_CACHE);
        $this->ip = $this->checkIP($this->getIP());
        $this->constructConfig();
        $this->setPerms();
    }

    public function constructConfig() {
        $config = array();
        $config['user'] = array();
        $config['user']['ip'] = $this->ip;
        $config['user']['auth'] = $this->checkCountry();
        $config['user']['countryname'] = $this->getCountryName();
        $config['user']['countrycode'] = $this->getCountryCode();
        $config['user']['currency'] = $this->getCurrency();
        $config['user']['type'] = $this->getUserType();
        $config['user']['name'] = '';

        $config['dir'] = array();
        $config['dir']['base_dir'] = self::BASE_DIR;
        $config['dir']['libs'] = self::LIBS_DIR;
        $config['dir']['models'] = self::MODELS_DIR;
        $config['dir']['controllers'] = self::CONT_DIR;
        $config['dir']['styles'] = self::STYLE_DIR;
        $config['dir']['imgs'] = self::IMG_DIR;
        $config['dir']['tests'] = self::TEST_DIR;

        $config['db']['type'] = 'InnoDB';
        $config['db']['collation'] = 'utf8_general_ci';
        $config['db']['host'] = 'localhost';
        $config['db']['databasename'] = 'glimpse';
        $config['db']['username'] = 'admin';
        $config['db']['password'] = 'password1';
        $config['db']['tblprefix'] = 'glimpse_';

        $this->configuration = $config;
    }

    public function setPerms($path = '.', $level = 0 ) {
        ///chmod perms here
/*
        $ignore = array('cgi-bin', '', '..');
        $dh = @opendir($path);
        while (false !== ($file = readdir($dh))) { // Loop through the directory 
            if (!in_array($file, $ignore)) {
                if (is_dir("$path/$file")) {
                    chmod("$path/$file ",0777);
                    $this->setPerms("$path/$file ", ($level + 1));
                } else {
                    chmod("$path/$file ",0777); // desired permission settings
                }//elseif 
            }//if in array 
        }//while 

        closedir($dh);*/
    }

    public function debug() {
        print_r($this->configuration);
    }

    public function getUserConfig($setting = '') {
        return $this->configuration['user'][$setting];
    }

    public function setUserConfig($setting ='', $value ='') {
        $this->configuration['user'][$setting] = $value;
    }

    public function getDirConfig($setting = '') {
        return $this->configuration['dir'][$setting];
    }

    public function getDBConfig($setting = '') {
        return $this->configuration['db'][$setting];
    }

    public function getIP() {
        if ($this->ip) {
            return $this->ip;
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function getUserType() {
        //check user type
    }

    /**
     * Check for debugging purposes.
     * 
     * @param string $ip IP Address to check
     * @return string $ip Checked IP Address 
     */
    public function checkIP($ip) {
        if ($ip == 'localhost' || '120.0.0.1') {
            return '210.158.6.201';
        } elseif ($ip != 'localhost') {
            return $ip;
        } else {
            array_push($this->errors, "Unable to determine User's IP!");
            return false;
        }
    }

    public function checkCountry() {
        if ($this->getCountryCode()) {
            if (in_array($this->getCountryCode(), $this->availcountries)) {
                return true;
            }
        } else {
            array_push($this->errors, "Search is not available for User's country!");
            return false;
        }
    }

    public function getCountryName() {
        if ($this->ip) {
            return geoip_country_name_by_addr($this->gi, $this->ip);
            geoip_close($this->gi);
        } else {
            array_push($this->errors, "Unable to determine User's country name!");
            return false;
        }
    }

    public function getCountryCode() {
        if ($this->ip) {
            return geoip_country_code_by_addr($this->gi, $this->ip);
            geoip_close($this->gi);
        } else {
            array_push($this->errors, "Unable to determine User's country code!");
            return false;
        }
    }

    public function getCurrency() {
        if ($this->getCountryCode()) {
            return $this->countrycurrency[$this->getCountryCode()];
        } else {
            array_push($this->errors, "Unable to determine User's currency!");
            return false;
        }
    }

}

?>
