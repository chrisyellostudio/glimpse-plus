<?php

/**
 * Description of tour
 *
 * @author cir8
 */
include 'bootstrap.php';
run();
include $application->getDirConfig('controllers').'ApplicationWebBody.php';
include $application->getDirConfig('controllers').'ApplicationWebPage.php';

class tour {
    
    private $app;

    public function __construct($application){
        $this->app = $application;
    
        $links = array('about.php' => 'About', 'tour.php' => 'Guided Tour');
        $currentLocation = array('home.php' => 'Home', 'tour.php' => 'Guided Tour');
        $bodyContent = '';

        $body = new ApplicationWebBody($this->app, 'Guided Tour', $bodyContent);
        $body->setCurrentBranch('home');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('Guided Tour');
        echo $page->body($body);
        echo $page->footer();
    }
}

new Tour($application);
