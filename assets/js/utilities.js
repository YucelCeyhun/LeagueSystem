$.InputEmptyControl = (inputArray) => {
    var returnVal = true;
    inputArray.some((val) => {
        if (val.val() == "") {
            alertify.error("Gerekli alanları doldurunuz.");
            val.addClass("input-error");
            returnVal = false;
            
            return true;
        }
    })
    return returnVal;
}

$.InputRemoveClass = function () {
    $("input").focus(function () {
        if ($(this).hasClass("input-error")) {
            $(this).removeClass("input-error");
        }
    })
}