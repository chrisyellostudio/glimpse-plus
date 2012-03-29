<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of about
 *
 * @author cir8
 */

include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';

class about {
    public static function createPage(){        

        $currentLocation = array('about.php'=>'About');
        $bodyContent = '';
        
        $body = new ApplicationWebBody('About',$bodyContent);
        $body->setCurrentBranch('about');
        $body->setbreadArray($currentLocation);
        
        $page = new ApplicationWebPage();
        echo $page->head('About');
        echo $page->body($body);
        echo $page->footer();
    }
}
session_start();
about::createPage();
