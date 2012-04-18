<?php

/**
 * @author cir8
 */
include 'core/Application.php'; //DO NOT CHANGE!
$application;

function run() {
    global $application;
    if (!isset($application)) {
        $application = new Application();
        return $application;
    }
}

?>
