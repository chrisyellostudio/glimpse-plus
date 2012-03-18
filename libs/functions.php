<?php

/*
 *
 * 
 */

function countryNotif() {
    $gi = geoip_open('GeoIP.dat', GEOIP_MEMORY_CACHE);
    $country = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
    geoip_close($gi);

    echo 'Your IP: ' . $_SERVER['REMOTE_ADDR'] . '</br>';
    echo 'Your Country: ' . $country;
}
