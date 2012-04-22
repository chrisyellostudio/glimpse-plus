<?php

/**
 * Description of logout
 *
 * @author cir8
 */
include 'bootstrap.php';
run();
include $application->getDirConfig('controllers') . 'ApplicationWebBody.php';
include $application->getDirConfig('controllers') . 'ApplicationWebPage.php';
include $application->getDirConfig('controllers') . 'AccountFunctions.php';

class logout {

    private $app;

    public function __construct($application) {
        $this->app = $application;
    }

    public function logoutpage() {
        
        //unset user member type and set to guest
        $currentLocation = array('account.php' => 'My Account');
        $bodyContent = 'You have been logged out.';

        $body = new ApplicationWebBody($this->app, 'My Account', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('My Account');
        echo $page->body($body);
        echo $page->footer();
    }
}

?>
