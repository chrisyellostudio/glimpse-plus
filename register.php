<?php

/**
 * Description of register
 *
 * @author cir8 
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';
include 'APIFunctions.php';
include 'FormValidation.php';

class register {

    public static function registerUser() {
        $script = 'http://code.jquery.com/jquery-1.7.1.min.js';
        $s = new APIFunctions();
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'searh.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'register.php' => 'Register');
        $bodyContent = '<form class="register" name="register" action="register.php?validate" method="post">
                <table border="0">
                <tr>
                    <td class=label><label for="email">Email: </label></td>
                    <td class=input><input class="email" type="email" maxlength="100" required="true" title="Enter your email adress" name="email" /></td>
                    <td class=validation><span class=validemail text></span></td>
                    </tr>
                <tr>
                    <td class=label><label for="confemail">Confirm Email: </label></td>
                    <td class=input><input class="confemail" type="email" maxlength="100" autocomplete="off" required="true" title="Confirm your email address" name="confemail" /></td>
                    <td class=validation><span class=validemail2 text></span></td>
                </tr>    
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class=label><label for="firstname">Firstname: </label></td>
                    <td class=input><input class="firstname" type="text" maxlength="25" required="true" title="Enter your firstname" name="firstname" /></td>
                    <td class=validation><span class=validname text></span></td>
                </tr> 
                <tr>
                    <td class=label><label for="surname">Surname: </label></td>
                    <td class=input><input class="surname" type="text" maxlength="25" title="Enter your surname" name="surname" /></td>
                    <td class=validation><span class=validsurname text></span></td>
                </tr> 
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class=label><label for="password">Password: </label></td>
                    <td class=input><input class="password" type="password" name="password" /></td>
                    <td class=validation><span class=validpass text></span></td>
                </tr>
                <tr>
                    <td class=label><label for="confpassword">Confirm password: </label></td>
                    <td class=input><input class="confpassword" type="password" autocomplete="off" name="confpassword" /></td>
                    <td class=validation><span class=validpass2 text></span></td>
                </tr>       
                </table>
                    <script type="text/javascript"
                        src="http://www.google.com/recaptcha/api/challenge?k=6LeLe84SAAAAANau1wtRtkCrZxxVo_PGHN04SCvp">
                    </script>
                    <noscript>
                        <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LeLe84SAAAAANau1wtRtkCrZxxVo_PGHN04SCvp"
                        height="300" width="500" frameborder="0"></iframe><br>
                        <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                        <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                    </noscript>
                <input class="submit right" type="submit" value="Continue > " />
                </form>
        <script type="text/javascript" src="validate.js"></script>';

        $body = new ApplicationWebBody('My Account', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('Register', '', $script);
        echo $page->body($body);
        echo $page->footer();
    }

    public static function verifyFirstPage() {
        $email = $_POST['email'];
        $confemail = $_POST['confemail'];
        $fname = $_POST['firstname'];
        $sname = $_POST['surname'];
        $pass = $_POST['password'];
        $confpass = $_POST['confpassword'];
        $rcf = $_POST['recaptcha_challenge_field'];
        $rrf = $_POST['recaptcha_response_field'];
        $s = new FormValiadation($email, $confemail, $fname, $sname, $pass, $confpass, $rcf, $rrf);
        if ($s->validateForm()) {
            header('Location: registerlocation.php');
        } else {
            echo 'failed verification';
        };
    }

}

if (isset($_GET['validate'])) {
    register::verifyFirstPage();
} else {
    register::registerUser();
}
?>
