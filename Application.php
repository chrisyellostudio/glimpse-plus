<?php

/**
 * Description of Application
 *
 * @author cir8
 */
class Application {
    /**
     * Constructor for the Application configuration.
     * 
     * @param string $base_dir 
     */
    const BASE_DIR = '/';

    public function __construct() {
        $this->getUserInfo();
    }
    
    public function constructConfig() {
        $this->base_dir = BASE_DIR;
        $this->conf['db'] = array();
        $this->conf['user'] = array();
    }

    /*
     * 
     */

    public function getUserInfo() {
        $gi = geoip_open('GeoIP.dat', GEOIP_MEMORY_CACHE);
        $ip = $_SERVER['REMOTE_ADDR'];
        $country = geoip_country_code_by_addr($gi, $ip);
        geoip_close($gi);
        
        session_start();
        $_SESSION['country'] = $country;
        $_SESSION['ip'] = $ip;       
    }
}

?>
