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

$.InputRemoveClass = () => {
    $('#GeneralModal').on('shown.bs.modal', function () {
        $('input').focus(() => {
            $('input').removeClass("input-error");
        });
    })
}