$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    $("#teacher_Designation").focus(function(){
        document.getElementById("teacherDesignation_Error").innerHTML = "";
    });


    //--------------- VALIDATION  ----------------//

    $("#teacher_Designation").focusout(function(){
        var teacherDesignation = $("#teacher_Designation").val();
        if(teacherDesignation)
        {
            if(!validateText(teacherDesignation)) //Teacher Designation
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