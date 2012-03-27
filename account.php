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
        $bodyContent = 'Welcome: '. $_POST['user'];

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
        if (isset($_POST['user'])) {
            unset($_POST['user']);
            unset($_POST['password']);
            header('Location: home.php');
        } else {
            header('Location: login.php');
        }
    }
}
if(isset($_POST['user']) && isset($_POST['password'])){
    account::userpage();
}
if (isset($_GET['login'])) {
    header('Location: login.php');
}
if (isset($_GET['logout'])) {
    account::logout();
} 
if(isset($_POST['user']) == FALSE){
  header('Location: login.php');   
}
?>
