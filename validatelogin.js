/*
 * author: cir8 
*/
//global vars
var form = $(".login");
var email = $(".email");
var emailvalidation = $(".validemail");
var password = $(".password");
var passwordvalidation = $(".validpass");


function validateEmail(){
    var emailregex = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    //check if legit email
    if(!emailregex.test(email.val())){
        emailvalidation.text("This is not a valid email address!")
        return false;
    } else if(email.val().length == 0){
        emailvalidation.text("");
        return false;
    } else{
        emailvalidation.text("");
        return true;
    }
}

function validatePassword(){
    if(password.val().length < 5){
        passwordvalidation.text("Password must be at least 5 characters");
        return false;
    } else if(password.val().length == 0){
        passwordvalidation.text("");
        return false;
    }
    //it's valid
    else{
        passwordvalidation.text("");
        return true;
    }
}

email.blur(validateEmail);
password.blur(validatePassword);


email.keyup(validateEmail);
password.keyup(validatePassword);


form.submit(function(){
    if(validateEmail() && validatePassword())
        return true
    else
        return false;
});