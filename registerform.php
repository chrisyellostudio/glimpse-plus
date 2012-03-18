<?php

include 'register.php';

$content = '';
$content .=  '<form name="login" action="resgister.php" method="post">
                <table border="0">
                <tr>
                    <td><label for="email">Email: </label></td>
                    <td><input type="email" maxlength="100" required="true" title="Enter your email adress" name="email" /></td>
                </tr>
                <tr>
                    <td><label for="confemail">Confirm Email: </label></td>
                    <td><input type="email" maxlength="100" autocomplete="off" required="true" title="Confirm your email address" name="confemail" /></td>
                </tr>    
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><label for="username">Firstname: </label></td>
                    <td><input type="text" maxlength="25" required="true" title="Enter your firstname" name="firstname" /></td>
                </tr> 
                <tr>
                    <td><label for="username">Surname: </label></td>
                    <td><input type="text" maxlength="25" title="Enter your surname" name="surname" /></td>
                </tr> 
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><label for="password">Password: </label></td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td><label for="confpassword">Confirm password: </label></td>
                    <td><input type="password" autocomplete="off" name="confpassword" /></td>
                </tr>       
                </table>
                <br/>
                    <script type="text/javascript"
       src="http://www.google.com/recaptcha/api/challenge?k=6LeLe84SAAAAANau1wtRtkCrZxxVo_PGHN04SCvp">
    </script>
    <noscript>
       <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LeLe84SAAAAANau1wtRtkCrZxxVo_PGHN04SCvp"
           height="300" width="500" frameborder="0"></iframe><br>
       <textarea name="recaptcha_challenge_field" rows="3" cols="40">
       </textarea>
       <input type="hidden" name="recaptcha_response_field"
           value="manual_challenge">
    </noscript>
                    <td><input type="submit" value="Continue > " />
              </form>';


$l = new register($content);
?>
