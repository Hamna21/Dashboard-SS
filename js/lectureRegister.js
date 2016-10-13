$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    //Setting Errors to empty when user types in again

    $("#lecture_ID").focus(function(){
        document.getElementById("lectureID_Error").innerHTML = "";
    });

    $("#lecture_Name").focus(function(){
        document.getElementById("lectureName_Error").innerHTML = "";
    });

    $("#lecture_Description").focus(function(){
        document.getElementById("lectureDescription_Error").innerHTML = "";
    });

    //--------------- VALIDATION  ----------------//

    //Call this as soon as user finishes typing lecture_ID
    $("#lecture_ID").focusout(function(){
        var lectureID = $("#lecture_ID").val();
        if(lectureID)
        {
            if(!validateDigit(lectureID)) //Validating First Name
            {
                document.getElementById("lectureID_Error").innerHTML = "Not a valid lecture ID";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("lectureID_Error").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/lecture/lectureIDExist?q=" + lectureID, true);
            xmlhttp.send();
        }
    });

    //Call this as soon as user finishes typing lecture_Name
    $("#lecture_Name").focusout(function(){
        var lectureName = $("#lecture_Name").val();
        if(lectureName)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("lectureName_Error").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/lecture/lectureNameExist?q=" + lectureName, true);
            xmlhttp.send();
        }
    });



    //------------HELPER FUNCTIONS-----------//
    function validateText(text){
        var regex = /^[a-zA-Z0-9 ]*$/;
        return regex.test(text);
    }

    function validateDigit(text){
        var regex = /^[0-9 ]*$/;
        return regex.test(text);
    }

});