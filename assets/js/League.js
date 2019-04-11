$(function(){
    $.GetTeams();
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