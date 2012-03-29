<?php

/**
 * Description of searchresults
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';
include 'APIFunctions.php';

class searchresults {

    public static function createPage() {
        $s = new APIFunctions();
        $safequery = urlencode($_POST['searchquery']);
        $inputquery = $_POST['searchquery'];

        $links = array('advsearch.php' => 'Advanced Search',
            'searchpref.php' => 'Search Preferences');
        $currentLocation = array('search.php' => 'Search', '#' => '"' . $inputquery . '"');
        $bodyContent = $s->parseJSONObject($s->fetchJSONObject($s->buildAPIURL($safequery)));

        $body = new ApplicationWebBody('Search', $bodyContent);
        $body->setCurrentBranch('search');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('Search');
        echo $page->body($body);
        echo $page->footer();
    }

}
session_start();
if ($_POST['searchquery'] == '') {
    header('Location: search.php');
} else {
    searchresults::createPage();
}