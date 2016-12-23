$(document).ready(function(){

    //------------SETTING ERRORS TO EMPTY----------//

    $("#lecture_Name").focus(function(){
        document.getElementById("lectureName_Error").innerHTML = "";
    });

    $("#lecture_Description").focus(function(){
        document.getElementById("lectureDescription_Error").innerHTML = "";
    });

    //--------------- VALIDATION  ----------------//




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