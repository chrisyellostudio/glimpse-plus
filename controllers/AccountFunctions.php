<?php

/**
 * Description of AccountFunctions
 *
 * @author RIF01
 */
class AccountFunctions {

    public $user = '';
    private $app;
    
    public function __construct($application){
        $this->app = $application;
    }

    public function checkIfUserSet() {
        if ($this->app->getUserConfig('type') == 'member') {
            return true;
        } else {
            return false;
        }
    }

    public function displayUser() {
        $user = '';
        $userset = $this->checkIfUserSet();
        
        if ($userset) {
            $name = $this->app->getUserConfig('name');
            $user .= '<span class="right">Welcome<a href="account.php">' . $name . '</a>
                | <a href="logout.php">Logout</a>';
        } else {
            $user .= '<span class="right"><a href="login.php">Login</a>
                &nbsp;&nbsp;<a href="register.php">Register</a></span>';
        }

        return $user;
    }
    
    
    public function logout() {
        header('Location: login.php');
    }

}

?>
