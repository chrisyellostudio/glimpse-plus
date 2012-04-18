<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Creates a Form Object of the Registration form and validates it before calling
 * on the model and inserting it into the database.
 * 
 * @author cir8
 */
class FormValiadation {

    public $email;
    public $confemail;
    public $firstname;
    public $surname;
    public $password;
    public $confpassword;
    private $recaptcha_challenge_field;
    private $recaptcha_response_field;
    public $errors = array();

    public function __construct($email, $confemail, $fname, $sname, $pass, $confpass, $rcf, $rrf) {
        $this->email = $email;
        $this->confemail = $confemail;
        $this->firstname = $fname;
        $this->surname = $sname;
        $this->password = $pass;
        $this->confpassword = $confpass;
        $this->recaptcha_challenge_field = $rcf;
        $this->recaptcha_response_field = $rrf;
    }

    public function validateEmail() {
        $this->validateConfirmEmail();
        if (preg_match('/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(
            ?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2}
            )?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2
            [0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2}
            )\]?$)/i', $this->email)) {
            return true;
        } else {
            array_push($this->errors, 'Email is not a valid email address!');
            return false;
        }
    }

    public function validateConfirmEmail() {
        if ($this->email != $this->confemail) {
            array_push($this->errors, 'Confirmation email does not match!');
            return false;
        } else {
            return true;
        }
    }

    public function validateFirstname() {
        if (strlen($this->firstname) < 4) {
            array_push($this->errors, 'Firstname must have more than 4 letters!');
            return false;
        } else {
            return true;
        }
    }

    public function validateSurname() {
        if (strlen($this->surname) > 4) {
            array_push($this->errors, 'Surname must have more than 4 letters!');
            return false;
        } else {
            return true;
        }
    }

    public function validatePassword() {
        if (strlen($this->password) < 5) {
            array_push($this->errors, 'Password must have more than 5 characters!');
            return false;
        } else {
            $this->validateConfirmPassword();
            return true;
        }
    }

    public function validateConfirmPassword() {
        if ($this->password != $this->confpassword) {
            array_push($this->errors, 'Confirmation password does not match!');
            return false;
        } elseif (strlen($this->confpassword) < 5) {
            array_push($this->errors, 'Confirmation password must have more than 5 characters!');
            return false;
        } else {
            return true;
        }
    }

    public function validateReCAPTCHA() {
        if ($this->recaptcha_challenge_field && $this->recaptcha_response_field != "") {
            require_once('recaptchalib.php');
            $privatekey = "6LeLe84SAAAAADjNcGS0Nom1QrYlkmlBJHL-5T23";
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $this->recaptcha_challenge_field, $this->recaptcha_response_field);

            if (!$resp->is_valid) {
                // What happens when the CAPTCHA is entered incorrectly
                array_push($this->errors, 'The reCAPTCHA wasn\'t entered correctly. Go back and try it again.');
                return false;
            } else {
                return true;
            }
        }
    }

    public function validateForm() {
        if ($this->validateEmail() && $this->validateFirstname()
                && $this->validateSurname() && $this->validatePassword()
                && $this->validateReCAPTCHA()) {
            print '
                validateEmail returned: ' . $this->validateEmail() . '!
                validateFirstName returned: ' . $this->validateFirstname() . '!
                validateEmail returned: ' . $this->validateSurname() . '!
                validateEmail returned: ' . $this->validatePassword() . '!
                validateEmail returned: ' . $this->validateReCAPTCHA() . '!';
            return true;
        } else {
            return $this->returnErrors();
        }
    }

    public function returnErrors() {
        if (sizeof($this->errors) > 0) {
            return $this->errors;
        }
    }

}

?>
