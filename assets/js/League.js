alertify.set('notifier', 'position', 'top-center');
var rowId = null;

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $.GetTeams();

    $('#league > .card-body').on('click', 'tbody tr', function () {
        rowId = $(this).attr("team-data");
        $.GetTeamData(rowId);
    });

    $('.modal-footer > button#updateBtn').on('click', () => {
        var team = $("#team");
        var offensive = $("#offensive");
        var defensive = $("#defensive");

        $.UpdateTeamData(rowId, team, offensive, defensive);
    });

    $.InputRemoveClass();

})
/* 
*basit bir async ajax işlemi yapıp sonuç başarılıysa card-body classına sahip elementin içine tablerepositoryi yazdırıyoruz
*/
$.GetTeams = () => {
    $.ajax({
        url: "/ajax/Leagueajax/",
        type: "post",
        success: (data) => {
            var myData = JSON.parse(data);
            if (myData.situation == 1) {
                $("#league > .card-body").html(myData.val)
            }
        },
        error: () => {
            alertify.error("Beklenmedik bir hata oluştu");
        }
    })
}
/*
*async ajax ile modal-body içine her takımın id sine göre çekip yerleştirdik.  
*/
$.GetTeamData = (rowId) => {

    teamId = $.trim(rowId);

    if (teamId != "") {
        $.ajax({
            url: "/ajax/Teamgetajax/",
            data: { teamId: teamId },
            type: "post",
            success: (data) => {
                var myData = JSON.parse(data);
                if (myData.situation == 1) {
                    $("#GeneralModal .modal-body").html(myData.val)
                } else {
                    alertify.error(myData.msg);
                }
            },
            error: () => {
                alertify.error("Beklenmedik bir hata oluştu");
            }
        })
    } else {
        alertify.error("team-data Boş olamaz");
    }
}

$.UpdateTeamData = (rowId, team, offensive, defensive) => {


    var teamId = $.trim(rowId);
    team.val($.trim(team.val()));
    offensive.val($.trim(offensive.val()));
    defensive.val($.trim(defensive.val()));

    var formInput = Array(team, offensive, defensive);

    if ($.InputEmptyControl(formInput)) {
        var jData = {
            team: team,
            offensive: offensive,
            defensive: defensive,
            teamId: teamId
        };

        $.ajax({
            url: "/ajax/Teamupdateajax/",
            data: jData,
            type: "post",
            success: (data) => {
                var myData = JSON.parse(data);
                if (myData.situation == 1) {
                    alertify.success(myData.msg);
                } else {
                    alertify.error(myData.msg);
                }
            },
            error: () => {
                alertify.error("Beklenmedik bir hata oluştu");
            }
        })
    }
}
