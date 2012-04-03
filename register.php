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

    public static function complete() {
        //TODO finalise registration process
    }

    public static function verifySecondPage() {
        if (isset($_POST['location'])) {
            if ($_POST['location'] == 'select') { //Show Google Maps page
                register::registerlocation();
            } elseif ($_POST['location'] == 'auto') {
                if (isset($_SESSION['country'])) {
                    if (in_array($_SESSION['country'], $availcountries)) {
                        
                    }
                }
                register::complete();
            } elseif ($_POST['location'] == 'nostore') {
                register::complete();
            } else {
                header('Location: register.php?2');
            }
        } else {
            header('Location: register.php?2');
        }
    }

    public static function registerUser() {
        $script = array('http://code.jquery.com/jquery-1.7.1.min.js', 'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js');
        $s = new APIFunctions();
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'searh.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'register.php' => 'Register');
        $bodyContent = '<form class="register" name="register" action="register.php?2" method="post">
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
                <div id="captcha">
                    <script type="text/javascript">
                            Recaptcha.create("6Ld4iQsAAAAAAM3nfX_K0vXaUudl2Gk0lpTF3REf", "captcha", {
                           
                            tabindex: 1,
                            theme: "clean",
                            callback: Recaptcha.focus_response_field
                        });
                    </script>
                    <noscript>
                        <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LeLe84SAAAAANau1wtRtkCrZxxVo_PGHN04SCvp"
                        height="300" width="500" frameborder="0"></iframe><br>
                        <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                        <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                    </noscript>
                </div>
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
        if (isset($_POST['email']) && isset($_POST['confemail']) &&
                isset($_POST['firstname']) && isset($_POST['password']) &&
                isset($_POST['confpassword']) && isset($_POST['recaptcha_challenge_field'])
                && isset($_POST['recaptcha_response_field'])) {
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
                register::verifyUser();
            }
        } else {
            header('Location: register.php');
        }
    }

    /**
     * 
     */
    public static function verifyUser() {
        if ($result) {
            $to = htmlspecialchars(stripslashes(strip_tags($email)));
            $subject = '';
            $header = '';
            $message = '';

            $mail_result = mail($to, $subject, $message, $header);
        } else {
            $this->errors[] = 'Failed to send email, no user ';
        }
    }

    public static function locationchoice() {
        $s = new APIFunctions();
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'searh.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'register.php' => 'Register');
        $bodyContent = '<form method="POST" action="register.php?3">
                        <ul>
                            <li><input id="auto" name="location" value="auto" type="radio">
                            <label for=auto>Auto-detect using my IP Address!</label></li>
                            <li><input id="select" name="location" value="select" type="radio">
                            <label for=select>Select current location from Google Maps</label></li>
                            <li><input id="nostore" name="location" value="nostore" type="radio">
                            <label for=nostore>Don\'t store my location.</label></li>
                        </ul>
                        <input class="submit right" type="submit" value="Continue > " />
                        </form>';

        $body = new ApplicationWebBody('Register Location', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('Register Location');
        echo $page->body($body);
        echo $page->footer();
    }

    public static function registerlocation() {
        $s = new APIFunctions();
        $script = array('googlemapcanvas.js', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=places');
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'searh.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'register.php' => 'Register',
            'registerlocation.php' => 'Location');
        $bodyContent = '<form method="POST" action="location.php">
                            <input id="searchTextField" required="true" type="text" size="50"
                            title="Enter a valid address from the drop down menu" 
                            placeholder="Enter your location..." name="location">
                            <button id="start" onclick="<script>initialize();</script>">This is my location!</button> 
                        </form>
                        <div id="map_canvas"></div><br/>
                        <script>google.maps.event.addDomListener(window, "load", initialize);</script>';

        $body = new ApplicationWebBody('Register Location', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('Register Location', '', $script);
        echo $page->body($body);
        echo $page->footer();
    }

}

if (isset($_GET['2'])) {
    register::verifyFirstPage();
} elseif (isset($_GET['3'])) {
    register::verifySecondPage();
} elseif(isset($_GET['auth'])){
    register::verifyUser();
}else {
    register::registerUser();
}
?>
