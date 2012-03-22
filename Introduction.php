<?php


/**
 * Description of Introduction
 *
 * @author cir8
 */

include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';

class Introduction {

    public static function createPage(){        
        $links = array('home.php'=>'Home','intro.php'=>'Introduction');
        $bodyContent = 'I like pandas';
        
        $body = new ApplicationWebBody('Introduction',$bodyContent);
        $body->setCurrentBranch('home');
        $body->setbreadArray(array('Home','Introduction'));
        $body->setRightTitle('Introduction');
        $body->setRightContentLinks($links);
        
        $page = new ApplicationWebPage();
        $page->head('Introduction','styles','');
        $page->body($body);
        $page->footer();
    }
}

Introduction::createPage();

?>
