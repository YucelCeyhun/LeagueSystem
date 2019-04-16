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

$.ChartAnimation = (weekIndex) => {

    if (weekIndex == 4 || weekIndex == 5) {
        if (!$("#champrate-box").hasClass("active")) {
            $("#champrate-box").addClass("active");
            $("#champrate-box").animate({
                "left": "470px"
            }, {
                duration: 1000,
                complete: () => {
                    $("#champrate-box").css("z-index","0");
                }
            })
        }
    } else {
        if ($("#champrate-box").hasClass("active")) {
            $("#champrate-box").animate({
                "left": "0"
            }, {
                    duration: 1000,
                    complete: () => {
                        $("#champrate-box").removeClass("active");
                    }
            });
            $("#champrate-box").css("z-index","-5");
        }
    }
}