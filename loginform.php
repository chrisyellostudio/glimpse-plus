<?php

include 'login.php';




$content = '';
$content .= '<h3>New Users</h3>
                <p>For a chance to take advantage of our advanced...</p>
                <form name="register" action="login.php" method="post">
                    <input type="submit" value="Register" />
                </form>
                <br/><hr/><br/>
                ';
$content .='<h3>Existing Users</h3>
            <form name="login" action="login.php" method="post">
                <label for="username">Username: </label>
                <input type="text" maxlength="25" required="true" title="Enter your username" name="username" /><br/>
                <label for="password">Password: </label>
                <input type="password" name="password" /><br/>
                <input type="submit" value="Login" />
            </form>';


$l = new login($content);
?>
