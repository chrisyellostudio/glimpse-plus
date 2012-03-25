<?php

/**
 * Description of my_account
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';
include 'APIFunctions.php';

class my_account {

    public static function login() {
        $s = new APIFunctions();
        $links = array('my_account?login.php' => 'Login');
        $currentLocation = array('my_account.php' => 'My Account', 'my_account?login.php' => 'Login');
        $bodyContent = '<form method="post" action="login.php">
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

if (isset($_GET['login']) == 1) {
    my_account:: login();
}
?>
