<?php

/**
 * 
 *
 * @author cir8
 */
include 'bootstrap.php';
run();

include $application->getDirConfig('controllers') . 'ApplicationWebBody.php';
include $application->getDirConfig('controllers') . 'ApplicationWebPage.php';
include $application->getDirConfig('models') . 'UserModel.php';
include $application->getDirConfig('controllers') . 'NotificationHandler.php';

class login {

    private $app;
    public $errors = array();
    public $notifications;
    public $script = array();
    public $styles = array();

    public function __construct($application) {
        $this->app = $application;
        $this->notifications = new NotificationHandler($application);
    }

    public function loginpage($location = '') {
        if ($location != '') {
            $location = '&redirect=' . $location;
        }
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'search.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'login.php' => 'Login');
        $bodyContent = '
            <form class="login" name="login" action="login.php?login' . $location . '" method="post"">
                <table border="0">
                    <tr>
                        <td class=label><label for="email">Email: </label></td>
                        <td class=input><input class="email" type="email" maxlength="100" required="true" title="Enter your email adress" name="email" /></td>
                        <td class=validation><span class=validemail text></span></td>
                    </tr>
                    <tr>
                        <td class=label><label for="password">Password: </label></td>
                        <td class=input><input class="password" type="password" name="password" /></td>
                        <td class=validation><span class=validpass text></span></td>
                    </tr>
                </table>
                <input type="submit" value="Login" /><br/>
            </form>
            <script type="text/javascript" src="'.$this->app->getDirConfig('libs').'validatelogin.js"></script>';

        $body = new ApplicationWebBody($this->app, 'Login', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);        
        array_push($this->script , $this->app->getDirConfig('libs').'jquery-1.7.2.js');
        echo $page->head('Login', $this->styles, $this->script);
        echo $page->body($body);
        echo $page->footer();
    }

    public function login($location) {
        $email = mysql_real_escape_string(stripslashes($_POST['email']));
        $password = mysql_real_escape_string(stripslashes($_POST['password']));
        
        $u = new UserModel($this->app);
        if ($u->checkUser($email, $password)) {
            if (file_exists($this->notifications->notiffile)) {
                $this->notifications->__destroy();
            }
            $this->app->setUserConfig('type', $u->getUserType($email));
            $this->app->setUserConfig('name', $u->getUserName($email));

            if ($location != '') {
                header('Location: ' . $location);
            } else {
                header('Location: account.php');
            }
        } else {
            array_push($this->errors, 'No User found! Try logging in again.');
            $this->notifications->createErrorNotif($this->errors);
            $this->script = array_merge($this->script, $this->notifications->requiredJSFiles());
            $this->styles = array_merge($this->styles, $this->notifications->requiredStyleFiles());
            array_push($this->script, $this->notifications->notiffile);
            $this->loginpage($location);
        }
    }

}

$l = new Login($application);
if (isset($_GET['login'])) {
    if (isset($_GET['redirect'])) {
        $location = $_GET['redirect'];
    } else {
        $location = '';
    }
    $l->login($location);
} else {
    if (isset($_GET['redirect'])) {
        $location = $_GET['redirect'];
    } else {
        $location = '';
    }
    $l->loginpage($location);
}
?>
