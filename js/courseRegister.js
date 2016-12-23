$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    $("#course_Name").focus(function(){
        document.getElementById("courseName_Error").innerHTML = "";
    });

    //--------------- VALIDATION  ----------------//

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
        }
    });


    //------------HELPER FUNCTIONS-----------//
    function validateText(text){
    var regex = /^[a-zA-Z0-9 ]*$/;
    return regex.test(text);
    }

});