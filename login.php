<?php

/**
 * 
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';
include 'APIFunctions.php';
include 'UserModel.php';

class login {

    public static function loginpage() {
        $s = new APIFunctions();
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'search.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'login.php' => 'Login');
        $bodyContent = '
            <form class="login" name="login" action="login.php?login" method="post"">
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
            <script type="text/javascript" src="validatelogin.js"></script>';

        $body = new ApplicationWebBody('Login', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        $scripts = array('http://code.jquery.com/jquery-1.7.1.min.js');
        echo $page->head('Login', array(), $scripts);
        echo $page->body($body);
        echo $page->footer();
    }

    public function login() {
        $email = mysql_real_escape_string(stripslashes($_POST['email']));
        $password = mysql_real_escape_string(stripslashes($_POST['password']));

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
        }
    }

}

session_start();
if (isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
    header('Location: account.php');
}

login::loginpage();
?>
