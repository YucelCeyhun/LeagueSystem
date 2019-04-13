var weekIndex = 0;
var WeekCombination = Array(
    [[1, 2], [3, 4]],
    [[2, 4], [1, 3]],
    [[1, 4], [2, 3]],
    [[4, 3], [2, 1]],
    [[3, 1], [4, 2]],
    [[3, 2], [4, 1]]

);


$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $("#playAllBtn").on('click', $.PlayAllMatches);
    $("#nextBtn").on('click', $.PlayCurrentWeek);
})

$.PlayAllMatches = () => {

    $.ajax({
        url: "/ajax/Matchallajax/",
        type: "post",
        success: (data) => {
            var myData = JSON.parse(data);
            if (myData.situation == 1) {
                $("#league > .card-body").html(myData.val);
                weekIndex = 6;
            } else {
                alertify.error(myData.msg);
            }
        },
        error: () => {
            alertify.error("Beklenmedik bir hata oluştu");
        }
    })
}

$.PlayCurrentWeek = () => {

    if(weekIndex % 6 == 0){
        weekIndex = 0;
        WeekCombination = Array(
            [[1, 2], [3, 4]],
            [[2, 4], [1, 3]],
            [[1, 4], [2, 3]],
            [[4, 3], [2, 1]],
            [[3, 1], [4, 2]],
            [[3, 2], [4, 1]]
        
        );
    }
    var matchId = weekIndex * 2;
    jdata = {
        weekCombination: WeekCombination,
        matchId: matchId
    }

    $.ajax({
        url: "/ajax/Matchweekajax/",
        type: "post",
        data: jdata,
        success: (data) => {
            var myData = JSON.parse(data);
            if (myData.situation == 1) {
                WeekCombination.splice(myData.removeIndex, 1);
                $("#league > .card-body").html(myData.valLeague)
                $("#matches > .card-body").html(myData.valMatch)
                weekIndex++;
                console.log(weekIndex);
            } else {
                alertify.error(myData.msg);
            }
        },
        error: () => {
            alertify.error("Beklenmedik bir hata oluştu");
        }
    })
}