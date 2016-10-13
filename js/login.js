$(document).ready(function(){

    //Setting Errors to empty when user types in again
    $("#email").focus(function(){
        document.getElementById("emailError").innerHTML = "";
    });

    $("#password").focus(function(){
        document.getElementById("passwordError").innerHTML = "";
    });

    //Call this as soon as user finishes typing PASSWORD
    $("#password").focusout(function(){
        var password = $("#password").val();
        if(password)
        {
            var passwordLength = $("#password").val().length;

            if(passwordLength < 6) //Validating Password
            {
                document.getElementById("passwordError").innerHTML = "Minimum length of password : 6";
                return;
            }
        }
    });

    //Call this as soon as user finishes typing Email
    $("#email").focusout(function(){
        var email = $("#email").val();
        if(email)
        {
            if(!validateEmail(email)) //Validating Email
            {
                document.getElementById("emailError").innerHTML = "Not a valid Email ID";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("emailError").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/Login/userExist?q=" + email, true);
            xmlhttp.send();
        }
    });

    //--------------------------------------------------------------------------------------------------------//

    function validateEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

});


