/*
 * author: cir8 
*/
//global vars
var form = $(".register");
var email = $(".email");
var emailvadlidation = $(".validemail");
var confirmemail = $(".confemail");
var confirmemailvalidation = $(".validemail2")
var firstname = $(".firstname");
var firstnamevalidation = $(".validname");
var surname = $(".surname");
var surnamevalidation = $(".validsurname");
var password = $(".password");
var passwordvalidation = $(".validpass");
var confirmpass = $(".confpassword");
var confirmpassvalidation = $(".validpass2");

function validateEmail(){
    var emailregex = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    //check if legit email
    if(!emailregex.test(email.val())){
        emailvadlidation.text("This is not a valid email address!")
        return false;
    } else{
        emailvadlidation.text("");
        validateConfirmEmail();
        return true;
    }
}

function validateConfirmEmail(){
    if(email.val() != confirmemail.val()){
        confirmemailvalidation.text("Emails do not match!");
        return false;
    } else {
        confirmemailvalidation.text("");
        return true;
    }
}

function validateFirstname(){
    if(firstname.val().length < 4){
        firstnamevalidation.text("Firstname must have more than 4 letters!");
        return false;
    }
    else{
        firstnamevalidation.text("");
        return true;
    }
}

function validateSurname(){
    if(surname.val().length < 4){
        surnamevalidation.text("Surname must have more than 4 letters!");
        return false;
    }
    else{
        surnamevalidation.text("");
        return true;
    }
}  

function validatePassword(){
    if(password.val().length < 5){
        passwordvalidation.text("Password must be at least 5 characters");
        return false;
    }
    //it's valid
    else{
        passwordvalidation.text("");
        validateCofirmPassword();
        return true;
    }
}
function validateCofirmPassword(){
    if( password.val() != confirmpass.val() ){
        confirmpassvalidation.text("Passwords do not match!");
        return false;
    }
    else {
        confirmpassvalidation.text("");
        return true;
    }
}

email.blur(validateEmail);
confirmemail.blur(validateConfirmEmail)
firstname.blur(validateFirstname);
surname.blur(validateSurname)
password.blur(validatePassword);
confirmpass.blur(validateCofirmPassword);

email.keyup(validateEmail);
confirmemail.keyup(validateConfirmEmail);
firstname.keyup(validateFirstname);
surname.keyup(validateSurname);
password.keyup(validatePassword);
confirmpass.keyup(validateCofirmPassword);

form.submit(function(){
    if(validateEmail() && validateConfirmEmail() && validateFirstname() && validateSurname() && validatePassword() && validateCofirmPassword())
        return true
    else
        return false;
});