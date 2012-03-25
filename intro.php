<?php


/**
 * Description of Introduction
 *
 * @author cir8
 */

include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';

class intro {

    public static function createPage(){        
        $links = array('intro.php'=>'Introduction',
            'tour.php'=> 'Guided Tour');
        $currentLocation = array('home.php'=>'Home','intro.php'=>'Introduction');
        $bodyContent = '<p>This website aims to be better than the current Google
            Product Search. Yes, that right. Better. This webiste uses Google\'s 
            Product Search API to it\'s limits by gathering as much information 
            about a product as possible and squishing it into a nice presentable
            user friendly format without confusing you.
            </p>
            
            <p>We aim to provide you with a website that gives you more "bang for 
            your buck" by giving you lots of information, but in a nice friendly
            format that\'s easy to digest';
        
        $body = new ApplicationWebBody('Introduction',$bodyContent);
        $body->setCurrentBranch('home');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);
        
        $page = new ApplicationWebPage();
        echo $page->head('Introduction');
        echo $page->body($body);
        echo $page->footer();
    }
}

intro::createPage();

?>
