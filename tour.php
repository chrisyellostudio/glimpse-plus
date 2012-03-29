<?php

/**
 * Description of tour
 *
 * @author cir8
 */

include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';

class tour {
    
    public static function createPage(){        
        $links = array('intro.php'=>'Introduction',
            'tour.php'=> 'Guided Tour');
        $currentLocation = array('home.php'=>'Home', 'tour.php'=> 'Guided Tour');
        $bodyContent = '';
        
        $body = new ApplicationWebBody('Guided Tour',$bodyContent);
        $body->setCurrentBranch('home');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);
        
        $page = new ApplicationWebPage();
        echo $page->head('Guided Tour');
        echo $page->body($body);
        echo $page->footer();
    }
}
session_start();
tour::createPage();
