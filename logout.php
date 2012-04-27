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

class logout {

    private $app;

    public function __construct($application) {
        $this->app = $application;
    }

    public function countdownredirect() {
        for ($i = 5; $i > 0; $i--) {
            echo "$i..";
            sleep(1);
        }
        header("refresh:5;url=wherever.php");
    }

    public function logoutpage() {
        //unset user member type and set to guest
        $this->app->setUserConfig('type', 'guest');
        $this->app->setUserConfig('name', '');
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'search.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account');
        $bodyContent = 'You have been logged out.... Come back again soon okay?
                        <br/><br/>
                        Would you like to go <a href="home.php">home?</a>.....
                        Tough, I\'m taking you there in 5 seconds anyway :D';
        
        header("refresh:5;url=home.php");
        
        $body = new ApplicationWebBody($this->app, 'Logged Out', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('My Account');
        echo $page->body($body);
        echo $page->footer();
    }

}

$s = new logout($application);
$s->logoutpage();
?>
