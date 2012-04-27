<?php

/**
 * @author cir8
 */

include('core/Application.php'); //DO NOT CHANGE!
session_start();

$application;

/**
 * This function runs the Application by creating the 
 * Application Class, which then constructs the Application
 * configuration running the web application.
 * 
 * @global object $application
 * @return object $application
 */
function run() {
    global $application;
    if (isset($_SESSION['app'])) {
        return $application = $_SESSION['app']; //Application Session already exists
    } else {   
        $_SESSION['app'] = new Application();  
        new DBO($_SESSION['app']);
        return $application = $_SESSION['app'];
    }
}


?>
