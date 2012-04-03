<?php

/**
 * Description of Application
 *
 * @author cir8
 */

include 'libs/geoip.inc';

class Application {
    /**
     * Constructor for the Application configuration.
     * 
     * @param string $base_dir 
     */
    const BASE_DIR = '/';

    public $availcountries = array('US', 'GB', 'AU', 'DE', 'FR', 'JP', 'CN', 'IT', 'NL', 'ES');
    public $countrycurrencycode = array('US' => 'USD', 'GB' => 'GBP', 'AU' => 'AUD', 'DE' => 'EUR', 'FR' => 'EUR',
        'JP' => 'JPY', 'JP' => 'HKD', 'CN' => 'CNY', 'IT' => 'EUR', 'NL' => 'EUR', 'ES' => 'EUR');
    public $countrycurrency = array('USD' => 'US Dollars', 'GBP' => 'British Sterling',
        'AUD' => 'Australian Dollar', 'EUR' => 'Euros', 'JP' => 'Japanese Yen', 'CNY' => 'Yuan Renminbi',
        'HKD' => 'Hong Kong Dollar');
    public $errors = array();
    public $warnings = array();
    public $ip;
    public $countrycode;
    public $country;

    public function __construct() {
        $this->getUserInfo();
        $this->constructConfig();
    }
    
    public function constructConfig() {
        $this->base_dir = 'BASE_DIR';
        $this->conf['db'] = array();
        $this->conf['user'] = array();
    }

    public function debug() {
        echo 'IP: '.$this->ip.'</br>';
        echo 'Country: '.$this->country.'</br>';
        echo 'Country Code: '.$this->countrycode.'</br>';
        echo 'Currency: '.$_SESSION['currency'].'</br>';
    }

    /**
     * 
     */
    public function getUserInfo() {
        $gi = geoip_open('libs/GeoIP.dat', GEOIP_MEMORY_CACHE);
        $this->ip = '210.158.6.201'; //$_SERVER['REMOTE_ADDR'];
        $this->countrycode = geoip_country_code_by_addr($gi, $this->ip);
        $this->country = geoip_country_name_by_addr($gi, $this->ip);
        geoip_close($gi);

        session_start();
        $_SESSION['countrycode'] = $this->countrycode;
        $_SESSION['country'] = $this->country;
        $_SESSION['ip'] = $this->ip;
        $_SESSION['currency'] = $this->getCurrency();
    }

    public function getCurrency() {
        if (isset($_SESSION['countrycode'])) {
            $ccc_key = $this->countrycurrencycode[$_SESSION['countrycode']];
            return $cntry_currency = $this->countrycurrency[$ccc_key];
        } else {
            $this->errors[] = "User country not set, requires setting manually.";
        }
    }

}

?>
