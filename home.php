<?php


/**
 * Description of Introduction
 *
 * @author cir8
 */

include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';

class home {

    public static function createPage(){        
        $links = array('intro.php'=>'Introduction',
            'tour.php'=> 'Guided Tour');
        $currentLocation = array('home.php'=>'Home');
        $bodyContent = '';
        
        $body = new ApplicationWebBody('Home',$bodyContent);
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