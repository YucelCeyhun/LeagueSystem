var weekIndex = 0;
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $("#playAllBtn").on('click', $.PlayAllMatches);
})

$.PlayAllMatches = () => {

    $.ajax({
        url: "/ajax/Matchallajax/",
        type: "post",
        success: (data) => {
            var myData = JSON.parse(data);
            if (myData.situation == 1) {
                $("#league > .card-body").html(myData.val)
            }else{
                alertify.error(myData.msg);
            }
        },
        error: () => {
            alertify.error("Beklenmedik bir hata oluştu");
        }
    })
}