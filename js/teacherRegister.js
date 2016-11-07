$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    $("#teacher_Name").focus(function(){
        document.getElementById("teacherName_Error").innerHTML = "";
    });

    $("#teacher_Designation").focus(function(){
        document.getElementById("teacherDesignation_Error").innerHTML = "";
    });


    //--------------- VALIDATION  ----------------//

    //Call this as soon as user finishes typing teacher_Name
    /*$("#teacher_Name").focusout(function(){
        var teacherName = $("#teacher_Name").val();
        if(teacherName)
        {
            if(!validateText(teacherName)) //Validating First Name
            {
                document.getElementById("teacherName_Error").innerHTML = "Not a valid teacher Name";
                return;
            }

        }
    });*/

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

});