<?php

/**
 * Description of AccountFunctions
 *
 * @author RIF01
 */
class AccountFunctions {
    
    public $user = '';
    
    public static function checkIfUserSet(){
        if(isset($_GET['user']) == 1){
            return TRUE;
        } else {
            return FALSE;            
            }
        }
        
    public static function displayUser(){
        $user = '';
        if(isset($_GET['user']) == 1){
            $user .= '<span class="right userinfo"><a href="my_account.php">'.$_POST['user'].'</a>
                | <a href="my_account.php?logout">Logout</a>';
        } else {
            $user .= '<span class="right userinfo"><a href="my_account.php?login"> Login </a></span><br/>';
        }
        
        return $user;
    }
    
}

?>
