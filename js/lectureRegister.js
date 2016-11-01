$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    $("#lecture_Name").focus(function(){
        document.getElementById("lectureName_Error").innerHTML = "";
    });

    $("#lecture_Description").focus(function(){
        document.getElementById("lectureDescription_Error").innerHTML = "";
    });

    //--------------- VALIDATION  ----------------//

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
            xmlhttp.open("GET", "http://localhost:8080/Second-Screen-API-v3/Helper/lectureNameExist?q=" + lectureName, true);
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