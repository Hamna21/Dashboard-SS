$(document).ready(function(){

//------------SETTING ERRORS TO EMPTY---------//

//Setting Errors to empty when user types in again

    $("#category_ID").focus(function(){
        document.getElementById("categoryID_Error").innerHTML = "";
    });

    $("#category_Name").focus(function(){
        document.getElementById("categoryName_Error").innerHTML = "";
    });


//---------------VALIDATION----------------//

    //Call this as soon as user finishes typing category_ID
    $("#category_ID").focusout(function(){
        var categoryID = $("#category_ID").val();
        if(categoryID)
        {
            if(!validateDigit(categoryID)) //Validating First Name
            {
                document.getElementById("categoryID_Error").innerHTML = "Not a valid category ID";
                return;
            }

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("categoryID_Error").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/Category/categoryIDExist?q=" + categoryID, true);
            xmlhttp.send();
        }
    });

    //Call this as soon as user finishes typing category_Name
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
            xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/Category/categoryNameExist?q=" + categoryName, true);
            xmlhttp.send();
        }
    });



//---------------HELPER FUNCTIONS------------//
    function validateText(text){
        var regex = /^[a-zA-Z0-9 ]*$/;
        return regex.test(text);
    }

    function validateDigit(text){
        var regex = /^[0-9 ]*$/;
        return regex.test(text);
    }

});