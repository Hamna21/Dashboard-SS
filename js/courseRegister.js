$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    //Setting Errors to empty when user types in again

    $("#course_ID").focus(function(){
        document.getElementById("courseID_Error").innerHTML = "";
    });

    $("#course_Name").focus(function(){
        document.getElementById("courseName_Error").innerHTML = "";
    });

    //--------------- VALIDATION  ----------------//

    //Call this as soon as user finishes typing COURSE_ID
    $("#course_ID").focusout(function(){
        var courseID = $("#course_ID").val();
        if(courseID)
        {
            if(!validateDigit(courseID)) //Validating First Name
            {
                document.getElementById("courseID_Error").innerHTML = "Not a valid Course ID";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("courseID_Error").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/Course/courseIDExist?q=" + courseID, true);
            xmlhttp.send();
        }
    });

    //Call this as soon as user finishes typing Course_Name
    $("#course_Name").focusout(function(){
        var courseName = $("#course_Name").val();
        if(courseName)
        {
            if(!validateText(courseName)) //Validating First Name
            {
                document.getElementById("courseName_Error").innerHTML = "Not a valid Course Name";
                return;
            }

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    document.getElementById("courseName_Error").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/Course/courseNameExist?q=" + courseName, true);
            xmlhttp.send();
        }
    });



    //-------MODAL--------------//

    $('#deleteProductModal').on('show.bs.modal', function (event) { // id of the modal with event
        alert("Hamna");
    })



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