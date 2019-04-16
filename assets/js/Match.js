var weekIndex = 0;
var WeekCombination = Array(
    [[1, 2], [3, 4]],
    [[2, 4], [1, 3]],
    [[1, 4], [2, 3]],
    [[4, 3], [2, 1]],
    [[3, 1], [4, 2]],
    [[3, 2], [4, 1]]

);
var myChart = null;

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
                $("#matches > .card-body .main").html("")
                $(".card-title").html("");
                weekIndex = 6;
                $.ChartAnimation(weekIndex);
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

    if (weekIndex % 6 == 0) {
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
                $("#matches > .card-body .main").html(myData.valMatch)
                weekIndex++;
                $(".card-title").html('<span>'+weekIndex+'</span><sup>th</sup> of Week');
                if (weekIndex == 4 || weekIndex == 5) {
                    $.Chance(jdata);
                }
                $.ChartAnimation(weekIndex);
            } else {
                alertify.error(myData.msg);
            }
        },
        error: () => {
            alertify.error("Beklenmedik bir hata oluştu");
        }
    })
}

$.Chance = (jdata) => {
    $.ajax({
        url: "/ajax/Chanceajax/",
        type: "post",
        data: jdata,
        success: (data) => {
            var myData = JSON.parse(data);
            if (myData.situation == 1) {
                $.Chart(myData);

            } else {
                alertify.error("hata oluştu");
            }
        },
        error: () => {
            alertify.error("Beklenmedik bir hata oluştu");
        }
    })
}


$.Chart = (myData) => {
    var ctx = document.getElementById('chart-area').getContext('2d');
    if (myChart != null)
        myChart.destroy();

    myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [myData.val[3].team, myData.val[2].team, myData.val[1].team, myData.val[0].team],
            datasets: [{
                label: "Championship probability %",
                backgroundColor: ['red', 'green', 'blue', 'orange'],
                data: [myData.val[3].chance, myData.val[2].chance, myData.val[1].chance, myData.val[0].chance]
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: '%',
                    },

                    ticks: {
                        min: 0,
                        max: 100
                    }
                }],
            }
        }
    });
}