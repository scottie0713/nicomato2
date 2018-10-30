$(function(){

var url = location.href;

// ----------------------------------------
// APIアクセス系
// ----------------------------------------
// 認証
var Auth = {
  check : function(password){
    $.ajax({
      type: "GET",
      url: "/api/auth/"+user_id+"/"+password,
      datatype: "json",
      success: function(data) {
          console.log("KIM",data);
          if (data != undefined && data.length>0) {
            alert("AUTH OK");
          } else {
              alert("AUTH NG");
          }
      },
    });
  }
};
// 取得
var Ranking = {
  get : function(user_ranking_id,category_id,mask){
    $.ajax({
      type: "GET",
      url: "/user/apiGetRanking/"+category_id+"/"+mask,
      datatype: "json",
      success: function(data) {
        var target = $("div[user_ranking_id="+user_ranking_id+"]").parent().find("div.ranking_list");
        data.forEach(function(elem) {
          var movie_id = elem.RankingNicovideo.movie_id;
          var image_url= 'http://tn-skr3.smilevideo.jp/smile?i='+movie_id.substr(2);
          var title    = elem.RankingNicovideo.title;
          target.append('<div class="ranking_content"><a href="http://www.nicovideo.jp/watch/'+movie_id+'" target="blank"><img src="'+image_url+'"><span>'+title+'</span></a></div>');
        });
      },
    });
  },
};

// ----------------------------------------
// マイリスト動作系
// ----------------------------------------

// ページロード時
$(document).ready(function(){

    // 各カテゴリごと
    $(".row_edit").each(function(){
        // フォームをロック(認証前)
        $(this).find("select").attr("disabled","disabled");
        $(this).find("input").attr("disabled","disabled");
        var user_ranking_id = $(this).attr('user_ranking_id');
        var category_id = $(this).find("option:selected").val();
        var mask = $(this).find("input").val();
        // ランキングデータ取得
        Ranking.get(user_ranking_id, category_id, mask);
    });
});


    var $user_id = "0";
    var auth_enable = false;

    // ----------------------------------------
    // 関数郡
    // ----------------------------------------
    // パスワード認証
    function auth() {
        var pw = "kiki";
        $.ajax({
            type: "POST",
            url:  "/nicovideo/auth",
            data: {
                'uid': $user_id,
                'pw': pw
            },
            success: function(res){
                if ( res == 1 ) {
                    console.log( "Auth Sccess");
                    auth_enable = 1;
                    // すべてのフォームを解除
                    $(".row_edit").each(function(){
                       $(this).find("select").removeAttr("disabled");
                       $(this).find("input").removeAttr("disabled");
                    });
                } else {
                    console.log( "Auth Failed");
                }
            }
        });
    }

});
