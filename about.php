<?php

/**
 * Description of about
 *
 * @author cir8
 */
include 'bootstrap.php';
run();
include $application->getDirConfig('controllers') . 'ApplicationWebBody.php';
include $application->getDirConfig('controllers') . 'ApplicationWebPage.php';

class about {

    private $app;

    public function __construct($application) {
        $this->app = $application;

        $currentLocation = array('about.php' => 'About');
        $bodyContent = '';

        $body = new ApplicationWebBody($this->app, 'About', $bodyContent);
        $body->setCurrentBranch('about');
        $body->setbreadArray($currentLocation);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('About');
        echo $page->body($body);
        echo $page->footer();
    }

}

session_start();
new About($application);
