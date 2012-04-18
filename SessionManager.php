<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionManager
 *
 * @author cir8
 */
class SessionManager {

    private static $instance;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            //Creating new instance
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public function boo(){
        echo 'boo!';
    }
}

?>
