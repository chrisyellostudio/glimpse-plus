<?php

/**
 * @author cir8
 */

include 'core/Application.php'; //DO NOT CHANGE!

session_start();
$application;
    
function run() {
    global $application;
    if (!isset($application)) {
        return $application = new Application();
    }
}

?>
