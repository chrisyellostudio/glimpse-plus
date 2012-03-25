<?php

/**
 * Description of search
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';

class search {

    public static function createPage() {
        $links = array('advsearch.php' => 'Advanced Search',
            'searchpref.php' => 'Search Preferences');
        $currentLocation = array('search.php' => 'Search');
        $bodyContent = '<form method="post" action="searchresults.php">
                    <div class="search">
                        <input type="text" autocomplete=off size="60" maxlength="255" required="true" autofocus="true" placeholder="I\'m looking for..." title="Enter your keywords and click the search button" name="searchquery" /> 
                        <input type="submit" value="Search" /><br/>
                    </div>
                </form>';

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

search::createPage();