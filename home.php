<?php

/**
 * Description of Introduction
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';

class home {

    public static function createPage() {
        $links = array('intro.php' => 'Introduction',
            'tour.php' => 'Guided Tour');
        $currentLocation = array('home.php' => 'Home');
        $bodyContent = '        
        <p>Welcome to GlimPSE! Your resource for added functionality and features!</p>
        <h2>What is this about</h2>
        <p>This site does</p>
        <h2>Hello</h2>
        <p>Something else goes down here...</p>';

        $body = new ApplicationWebBody('Home', $bodyContent);
        $body->setCurrentBranch('home');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('Home');
        echo $page->body($body);
        echo $page->footer();
    }

}

session_start();
home::createPage();