<?php

/**
 * Description of registerlocation
 *
 * @author cir8
 */
include 'ApplicationWebBody.php';
include 'ApplicationWebPage.php';
include 'APIFunctions.php';
include 'FormValidation.php';

class registerlocation {

    public static function registerloc() {
        $s = new APIFunctions();
        $script = array('googlemapcanvas.js','//maps.googleapis.com/maps/api/js?sensor=false&libraries=places');
        $links = array('home.php' => 'Home', 'about.php' => 'About', 'searh.php' => 'Search');
        $currentLocation = array('account.php' => 'My Account', 'register.php' => 'Register',
            'registerlocation.php' => 'Register Location');
        $bodyContent = '<form method="POST" action="location.php">
                            <input id="searchTextField" required="true" type="text" size="50"
                            title="Enter a valid address from the drop down menu" 
                            placeholder="Enter your location..." name="location">
                            <input>
                            <button id="start" onclick="<script>initialize();</script>">This is my location!</button> 
                        </form>
                        <div id="map_canvas"></div><br/>
                        <script>google.maps.event.addDomListener(window, "load", initialize);</script>';

        $body = new ApplicationWebBody('Register Location', $bodyContent);
        $body->setCurrentBranch('account');
        $body->setbreadArray($currentLocation);
        $body->setRightContentLinks($links);

        $page = new ApplicationWebPage();
        echo $page->head('Register Location','',$script);
        echo $page->body($body);
        echo $page->footer();
    }

}


registerlocation::registerloc();
?>
