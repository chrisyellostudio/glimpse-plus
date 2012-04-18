<?php

/**
 * Description of ApplicationFunctions
 *
 * @author cir8
 */
class ApplicationFunctions {

    private $app; 
    
    public function __construct($application) {
        $this->app = $application;
    }

    /**
     * Shortens the inputted text by the required length.
     * 
     * @param string $s String to be shortened
     * @param int $length Length of the shortened strong to return
     * @return string Returns shortened string.
     */
    public function shortenText($s, $length) {
        if (strlen($s) <= $length) {
            return $s;
        } else {
            return substr($s, 0, $length) . '...';
        }
    }

}

?>
