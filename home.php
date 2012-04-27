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
        <p>Welcome to GlimPSE! Your resource for added functionality and features! You 
        won\'t get this kind of experience elsewhere!</p>
        <h2>Errrrr.... What is GLimPSE?</h2>
        <p>Confused? You needen\'t be! If you\'re curious as to what this place is 
        all about, then look no further! Head on over to our <a href="about.php">about</a> section to learn more about what it is that GLimPSE actually does!</p>';

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