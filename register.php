<?php

/**
 * Description of register
 *
 * @author cir8 
 */
include 'bootstrap.php';
run();
include $application->getDirConfig('controllers').'ApplicationWebBody.php';
include $application->getDirConfig('controllers').'ApplicationWebPage.php';
include $application->getDirConfig('controllers').'FormValidation.php';
include $application->getDirConfig('controllers').'NotificationHandler.php';

class register {

    private $script = array();
    private $styles = array();
    private $errors = array();
    private $notifications;
    public $application;
    private $app;
    
    public function __construct($application){
        $this->app = $application;
        $this->notifications = new NotificationHandler($application);
    }
    /**
     * 
     */
    public function complete() {
        //TODO finalise registration process
    }

    /**
     * 
     */
    public function verifySecondPage() {
        if (isset($_POST['location'])) {
            if ($_POST['location'] == 'select') { //Show Google Maps page
                $this->registerlocation();
            } elseif ($_POST['location'] == 'auto') {
                if (isset($_SESSION['country'])) {
                    if (in_array($_SESSION['country'], $availcountries)) {
                        
                    }
                }
                $this->complete();
            } elseif ($_POST['location'] == 'nostore') {
                $this->complete();
            } else {
                header('Location: register.php?2');
            }
        } else {
            header('Location: register.php?2');
        }
    }

    /**
     * 
     */
    public function verifyFirstPage() {
        
        $email = $confemail = $fname = $sname = $pass = $confpass = $rcf = $rrf = '';
       
        if(isset($_POST['email'])){$email = $_POST['email'];}
        if(isset($_POST['confemail'])){$confemail = $_POST['confemail'];}
        if(isset($_POST['firstname'])){$fname = $_POST['firstname'];}
        if(isset($_POST['surname'])){$sname = $_POST['surname'];}
        if(isset($_POST['password'])){$pass = $_POST['password'];}
        if(isset($_POST['confpassword'])){$confpass = $_POST['confpassword'];}
        if(isset($_POST['recaptcha_challenge_field'])){$rcf = $_POST['recaptcha_challenge_field'];}
        if(isset($_POST['recaptcha_response_field'])){$rrf = $_POST['recaptcha_response_field'];}
        
        if($email && $confemail && $fname && $sname && $pass && $confpass && $rcf && $rrf){
            $s = new FormValiadation($email, $confemail, $fname, $sname, $pass, $confpass, $rcf, $rrf);
            if ($s->validateForm()) {
                if (file_exists($this->notifications->notiffile)){
                    $this->notifications->__destroy();
                }    
                $this->verifyUser();
                //insert into temp db 
                } else {
                    $this->notifications->createErrorNotif($s->validateForm());
                    array_push($this->script, $this->notifications->notiffile); //Add notifications.js to scripts to run for the page
                }
         } else {
             header('Location: register.php');
         }
    }

    /**
     * 
     */
    public function registerUser() {

        $links = array('home.php' => 'Home', 'about.php' => 'About', 'search.php' => 'Search');
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
                            theme: "clean"
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
        <script type="text/javascript" src="'.$this->app->getDirConfig('libs').'validate.js"></script>';

        $body = new ApplicationWebBody($this->app,'My Account', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        array_push($this->script, 'http://code.jquery.com/jquery-1.7.1.min.js', 'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js');
        echo $page->head('Register', $this->styles, $this->script);
        echo $page->body($body);
        echo $page->footer();
    }

    /**
     * 
     */
    public function verifyUser() {
        //do a db check on the user - by email field
        //pass result into result
        //if user already exists, give option to email password if forgotten or link to login
        //if user does not exist on the system send out an email
        //insert data into temp_user table
        if (false) {
            $to = htmlspecialchars(stripslashes(strip_tags($email)));
            $subject = '';
            $header = '';
            $message = '';

            $mail_result = mail($to, $subject, $message, $header);
        } else {     
            array_push($this->errors, 'Failed to send email, no user. Try registering again.');
            $this->checkErrors();
            $this->script = array_merge($this->script, $this->notifications->requiredJSFiles());
            $this->styles = array_merge($this->styles, $this->notifications->requiredStyleFiles());
            array_push($this->script, $this->notifications->notiffile);   
            $this->registerUser();
        }
    }

    public function locationchoice() {

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

        $body = new ApplicationWebBody($this->app,'Register Location', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('Register Location');
        echo $page->body($body);
        echo $page->footer();
    }

    public function registerlocation() {

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

        $body = new ApplicationWebBody($this->app,'Register Location', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage($this->app);
        echo $page->head('Register Location', array(), $script);
        echo $page->body($body);
        echo $page->footer();
    }

    public function checkErrors(){
        if(sizeof($this->errors) > 0){
            $this->notifications->createErrorNotif($this->errors);
        }
    }
}

$r = new register($application);
if (isset($_GET['2'])) {
    $r->verifyFirstPage();
} elseif (isset($_GET['3'])) {
    $r->verifySecondPage();
} elseif (isset($_GET['auth'])) {
    $r->verifyUser();
} else {
    $r->registerUser();
}
?>
