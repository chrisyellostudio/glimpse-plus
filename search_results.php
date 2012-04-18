<?php

/**
 * Description of searchresults
 *
 * @author cir8
 */
include 'bootstrap.php';
run();
include $application->getDirConfig('controllers').'ApplicationWebBody.php';
include $application->getDirConfig('controllers').'ApplicationWebPage.php';
include $application->getDirConfig('controllers').'APIFunctions.php';

class searchresults {
    
    private $app;
    
    public function __construct($application){
        $this->app = $application;
    }

    public function createPage() {
        $s = new APIFunctions();
        $safequery = urlencode(stripslashes(($_POST['searchquery'])));
        $inputquery = $_POST['searchquery'];

        $links = array('advsearch.php' => 'Advanced Search',
            'searchpref.php' => 'Search Preferences');
        $currentLocation = array('search.php' => 'Search', '#' => '"' . $inputquery . '"');
        $bodyContent = $s->parseJSONObject($s->fetchJSONObject($s->buildAPIURL($safequery)));

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
session_start();
$s = new Searchresults($application);
if ($_POST['searchquery'] == '') {
    header('Location: search.php');
} else {
    $s->createPage();
}