<?php

/**
 * Creates JQuery notifications based off the JGrowl Plugin from Stan Lemon.
 *
 * @author cir8
 */
 class NotificationHandler {
    
    public $notiffile; //default name of the notifications file.
    private $notifsFileHandle;
    private $app;
    
    /**
     *
     * @param object $application 
     */
    public function __construct($application) {
        $this->app = $application;
        $this-> notiffile = $this->app->getDirConfig('libs').'notifications.js';
        $this->notifsFileHandle = fopen($this->notiffile, 'w');
        $credit = '// JGrowl JQuery via http://stanlemon.net/projects/jgrowl.html
                  (function($){
                  $(document).ready(function(){
                            ';
        fwrite($this->notifsFileHandle, $credit);
        fclose($this->notifsFileHandle); //create file and close
    }

    public function __destroy() {
        unlink($this->notiffile);
    }

    /**
     * Creates an error notification from an inputted array and writes it to the
     * notifcations file.
     * 
     * @param array $errorArr 
     */
    public function createErrorNotif($errorArr = array()) {
        if (sizeof($errorArr) > 0) {
            if (!file_exists($this->notiffile)) {
                $this->__construct();
            }
            $this->notifsFileHandle = fopen($this->notiffile, 'a'); //pointer at EOF
            $errrorInfo = '';
            $errrorInfo .= '<ul>';
            foreach ($errorArr as $error) {
                $errrorInfo .= '<li>' . $error . '</li>';
            }
            $errrorInfo .= '</ul>';

            $NotifInfo = '';
            $NotifInfo .= '$.jGrowl("' . $errrorInfo . '", { 
				theme: "errors",
				header: "Errors",
				sticky: true,
				closer: true
                            });
                            });
                            })(jQuery);';
            fwrite($this->notifsFileHandle, $NotifInfo);
            fclose($this->notifsFileHandle);
        }
    }

    /**
     *
     * @param array $warningArr 
     */
    public function createWarningNotif($warningArr = array()) {
        if (sizeof($warningArr) > 0) {
            if (!file_exists($this->notiffile)) {
                $this->__construct();
            }
            $this->notifsFileHandle = fopen($this->notiffile, 'a'); //pointer at EOF
            $warningInfo = '';
            $warningInfo .= '<ul>';
            foreach ($warningArr as $warning) {
                $warningInfo .= '<li>' . $warning . '</li>';
            }
            $warningInfo .= '</ul>';

            $NotifInfo = '';
            $NotifInfo .= '$.jGrowl("' . $warningInfo . '", { 
				theme: "warnings",
				header: "Warnings",
				sticky: true,
				closer: true
                            });
                            });
                        })(jQuery);';
            fwrite($this->notifsFileHandle, $NotifInfo);
            fclose($this->notifsFileHandle);
        }
    }

    public function requiredJSFiles() {
        $required = array('jquery-1.4.2.js','jquery.jgrowl.js');
        return $required;
    }

    public function requiredStyleFiles() {
        $required = array('jquery.jgrowl2.css');
        return $required;
    }

}

?>
