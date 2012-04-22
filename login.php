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

class login {

    private $app;

    public function __construct($application) {
        $this->app = $application;
    }

    public function loginpage($location = '') {
         if($location != ''){
            $location = '?redirect='.$location;
        }
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'search.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'login.php' => 'Login');
        $bodyContent = '
            <form class="login" name="login" action="login.php?login"'.$location.' method="post"">
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
            <script type="text/javascript" src="libs/validatelogin.js"></script>';

        $body = new ApplicationWebBody($this->app, 'Login', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        $scripts = array('http://code.jquery.com/jquery-1.7.1.min.js');
        echo $page->head('Login', array(), $scripts);
        echo $page->body($body);
        echo $page->footer();
    }

    public function login($location = '') {

        $email = mysql_real_escape_string(stripslashes($_POST['email']));
        $password = mysql_real_escape_string(stripslashes($_POST['password']));

        $this->app->debug();        
        $this->app->setUserConfig('type', 'member');
        $this->app->setUserConfig('name', $email);
        
        if ($location != '') {
            echo $location;
            header('Location: ' . $location);
        } else {
            echo 'No location';
            header('Location: account.php');
        }


        /*
          //query db to see if exists
          //if so
          $u = new UserModel();
          $u->selectUser();
          $sql = "SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
          $result = mysql_query($sql);

          // Mysql_num_row is counting table row
          $count = mysql_num_rows($result);
          // If result matched $myusername and $mypassword, table row must be 1 row

          if ($count == 1) {
          // Register $myusername, $mypassword and redirect to file "login_success.php"
          session_register("myusername");
          session_register("mypassword");
          header("location:login_success.php");
          } */
    }

}


$l = new Login($application);
if (isset($_GET['login'])) {
    if (isset($_GET['redirect'])) {
        $location = isset($_GET['redirect']);
    } else {
        $location = '';
    }
    $l->login($location);
} else {
    if (isset($_GET['redirect'])) {
        $location = isset($_GET['redirect']);
    } else {
        $location = '';
    }
    $l->loginpage($location);
}
?>
