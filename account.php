<?php

/**
 * Description of account
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';
include 'APIFunctions.php';

class account {

    public static function userpage() {
        $s = new APIFunctions();
        $links = array('account.php?logout' => 'Logout', 'account.php?settings' => 'My Settings');
        $currentLocation = array('account.php' => 'My Account');
        $bodyContent = 'Welcome: ' . $_SESSION['user'];

        $body = new ApplicationWebBody('My Account', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('My Account');
        echo $page->body($body);
        echo $page->footer();
    }

    public static function logout() {
        session_destroy();
        header('Location: login.php');
    }

}

session_start();
if (isset($_SESSION['user'])) {
    account::userpage();
} elseif (!isset($_SESSION['user'])) {
    header('Location: login.php');
} 
if (isset($_GET['logout'])) {
    account::logout();
}

?>
