$(document).ready(function(){

//------------SETTING ERRORS TO EMPTY---------//

    $("#category_Name").focus(function(){
        document.getElementById("categoryName_Error").innerHTML = "";
    });

    $("#category_name_edit").focus(function(){
        document.getElementById("categoryName_Error").innerHTML = "";
    });

//---------------VALIDATION----------------//

    //Call this as soon as user finishes typing category_Name -- Add Category Form
    $("#category_Name").focusout(function(){
        var categoryName = $("#category_Name").val();
        if(categoryName)
        {
            if(!validateText(categoryName)) //Validating category Name
            {
                document.getElementById("categoryName_Error").innerHTML = "Not a valid category Name";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("categoryName_Error").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Second-Screen-API-v3/Helper/categoryNameExist?q=" + categoryName, true);
            xmlhttp.send();
        }
    });


    //Call this as soon as user finishes typing category_Name -- Edit Category Form
    $("#category_name_edit").focusout(function(){
        var categoryName = $("#category_name_edit").val();
        if(categoryName)
        {
            if(!validateText(categoryName)) //Validating category Name
            {
                document.getElementById("categoryName_Error").innerHTML = "Not a valid category Name";
                return;
            }
        }
    });



//---------------HELPER FUNCTIONS------------//
    function validateText(text){
        var regex = /^[a-zA-Z0-9 ]*$/;
        return regex.test(text);
    }

});