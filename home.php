<?php

/**
 * Description of Introduction
 *
 * @author cir8
 */
include 'bootstrap.php';
run();
include $application->getDirConfig('controllers') . 'ApplicationWebBody.php';
include $application->getDirConfig('controllers') . 'ApplicationWebPage.php';

class home {

    private $app;

    public function __construct($application) {
        $this->app = $application;

        $links = array('about.php' => 'About',
            'tour.php' => 'Guided Tour');
        $currentLocation = array('home.php' => 'Home');
        $bodyContent = '        
        <p>Welcome to GlimPSE! Your resource for added functionality and features!</p>
        <h2>What is this about</h2>
        <p>This site does</p>
        <h2>Hello</h2>
        <p>Something else goes down here...</p>';

        $body = new ApplicationWebBody($this->app, 'Home', $bodyContent);
        $body->setCurrentBranch('home');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('Home');
        echo $page->body($body);
        echo $page->footer();
    }

}

new home($application);