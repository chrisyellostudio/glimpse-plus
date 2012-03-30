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
    
    public function constructConfig() {
        $this->base_dir = BASE_DIR;

        $this->conf['db'] = array();
        $this->conf['user'] = array();
    }
    
    /*
     * 
     */
    public function getUserInfo(){
        
    }
}

?>
