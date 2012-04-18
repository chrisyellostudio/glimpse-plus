<?php

/**
 * Description of account
 *
 * @author cir8
 */
include 'bootstrap.php';
run();
include $application->getDirConfig('controllers') . 'ApplicationWebBody.php';
include $application->getDirConfig('controllers') . 'ApplicationWebPage.php';

class account {

    private $app;
    
    public function __construct($application){
        $this->app = $application;
    }
    public function userpage() {
        $links = array('account.php?logout' => 'Logout', 'account.php?settings' => 'My Settings');
        $currentLocation = array('account.php' => 'My Account');
        $bodyContent = 'Welcome: ' . $_SESSION['user'];

        $body = new ApplicationWebBody($this->app,'My Account', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('My Account');
        echo $page->body($body);
        echo $page->footer();
    }

    public function logout() {
        session_destroy();
        header('Location: login.php');
    }

}

session_start();
$a = new Account();
if (isset($_SESSION['user'])) {
    $a->userpage();
} elseif (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
if (isset($_GET['logout'])) {
    $a->logout();
}
?>
