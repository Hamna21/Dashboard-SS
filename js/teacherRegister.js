$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    //Setting Errors to empty when user types in again

    $("#teacher_ID").focus(function(){
        document.getElementById("teacherID_Error").innerHTML = "";
    });

    $("#teacher_Name").focus(function(){
        document.getElementById("teacherName_Error").innerHTML = "";
    });

    $("#teacher_Designation").focus(function(){
        document.getElementById("teacherDesignation_Error").innerHTML = "";
    });


    //--------------- VALIDATION  ----------------//

    //Call this as soon as user finishes typing teacher_ID
    $("#teacher_ID").focusout(function(){
        var teacherID = $("#teacher_ID").val();
        if(teacherID)
        {
            if(!validateDigit(teacherID)) //Validating First Name
            {
                document.getElementById("teacherID_Error").innerHTML = "Not a valid teacher ID";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("teacherID_Error").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/teacher/teacherIDExist?q=" + teacherID, true);
            xmlhttp.send();
        }
    });

    //Call this as soon as user finishes typing teacher_Name
    $("#teacher_Name").focusout(function(){
        var teacherName = $("#teacher_Name").val();
        if(teacherName)
        {
            if(!validateText(teacherName)) //Validating First Name
            {
                document.getElementById("teacherName_Error").innerHTML = "Not a valid teacher Name";
                return;
            }

        }
    });

    $("#teacher_Designation").focusout(function(){
        var teacherDesignation = $("#teacher_Designation").val();
        if(teacherDesignation)
        {
            if(!validateText(teacherDesignation)) //Validating First Name
            {
                document.getElementById("teacherDesignation_Error").innerHTML = "Not a valid teacher Designation";
                return;
            }

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