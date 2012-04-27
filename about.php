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
        $bodyContent = '
            <h2>Hello!</h2>
            <p>This website aims to be better than the current Google
            Product Search. Yes, that right. Better. This webiste uses Google\'s 
            Product Search API to it\'s limits by gathering as much information 
            about a product as possible and squishing it into a nice presentable
            user friendly format without confusing you.
            </p>
            
            <h2>So, come on what is GLimPSE?</h2>
            <p><a href="#">GLimPSE...</a> wandering where the name came from?
            Well, let us tell you! Since this web site uses the Google Product 
            Search API we thought we would pay somehomage to the 
            <a href="http://www.google.co.uk/shopping">Magnificent Overlord Google
            </a> and make an acronym out of the web site\'s name!</p>             

            <h2>What do we do?</h2>
            <p>We aim to provide you with a website that gives you more "bang for 
            your buck" by giving you lots of information, but in a nice friendly
            format that\'s easy to digest hopefully better than the Google Product Search.';

        $body = new ApplicationWebBody($this->app, 'About', $bodyContent);
        $body->setCurrentBranch('about');
        $body->setbreadArray($currentLocation);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('About');
        echo $page->body($body);
        echo $page->footer();
    }

}

new About($application);
