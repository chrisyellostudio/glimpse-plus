<?php

/**
 * Description of search
 *
 * @author cir8
 */

include 'bootstrap.php';
run();
include $application->getDirConfig('controllers').'ApplicationWebBody.php';
include $application->getDirConfig('controllers').'ApplicationWebPage.php';

class search {
    private $app;
    
    public function __construct($application){
        $this->app = $application;
    }
    
    public function checkUser(){
        $type = $this->app->getUserConfig('type');
        if($type == 'member'){
            $this->createPage();
            
            } else {
            header('Location: login.php?redirect=search.php');
        }
    }
    
    public function createPage() {
        $this->app->debug();
        $links = array('advsearch.php' => 'Advanced Search',
            'searchpref.php' => 'Search Preferences');
        $currentLocation = array('search.php' => 'Search');
        $bodyContent = '<form method="post" action="results.php">
                    <div class="search">
                        <input type="text" autocomplete=off size="60" maxlength="255" required="true" autofocus="true" placeholder="I\'m looking for..." title="Enter your keywords and click the search button" name="searchquery" /> 
                        <input type="submit" value="Search" /><br/>
                    </div>
                </form>';

        $body = new ApplicationWebBody($this->app,'Search', $bodyContent);
        $body->setCurrentBranch('search');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('Search');
        echo $page->body($body);
        echo $page->footer();
    }
}

$s = new Search($application);
$s->checkUser();