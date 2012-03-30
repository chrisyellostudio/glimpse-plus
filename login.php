<?php

/**
 * 
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';
include 'APIFunctions.php';

class login {

    public static function logmein() {
        $s = new APIFunctions();
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'search.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'login.php' => 'Login');
        $bodyContent = '<form class="login" method="post" action="login.php">
                    <div class="login">
                        <input type="text" autocomplete=off size="30" maxlength="255" required="true" autofocus="true" name="user"/> 
                        <br/>
                        <input type="password" size="30" required="true" name="password"/>
                        <br/>
                        <input type="submit" value="Login" /><br/>
                    </div>
                </form>';

        $body = new ApplicationWebBody('Login', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('Login');
        echo $page->body($body);
        echo $page->footer();
    }

}
session_start();
if (isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
    header('Location: account.php');
}
login::logmein();
?>
