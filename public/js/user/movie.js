$(function(){
// -- START

var url = location.href;
var urlparam = url.split("/");
var user_id = urlparam[5];
var session_id = "";

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
          if (data.success == true) {
            // セッションＩＤをセット
            session_id = data.session_id;
            // すべてのフォームを解除
            $(".row_edit").each(function(){
               $(this).find("select").removeAttr("disabled");
               $(this).find("input").removeAttr("disabled");
            });
            $("#auth").attr("disabled","disabled");
            $("#auth_result").css("color","green").html("OK");
          } else {
            $("#auth_result").css("color","red").html("NG");
          }
      },
    });
  }
};
// 取得
var Search = {
  get : function(){
    $.ajax({
      type: "POST",
      url: "http://api.search.nicovideo.jp/api/snapshot/",
      datatype: 'json',
      data: {
        'query': 'MMD',
        'service': ["video"],
        'search': ["title", "description", "tags"],
        'join': ["cmsid", "title", "view_counter"],
        /*
        "filters": [
          {
              "type": "range",
              "field": "view_counter",
              "to": 10000
          }
        ],
        */
        //"from": 0,
        //"size": 3,
        /*"sort_by": "view_counter",*/
        "issuer": "nicomato",
      },
      success: function(data) {
          console.log("KIM",data);
      },
    });
  },

  /*
  set : function(user_ranking_id,category_id,mask){
    $.ajax({
      type: "GET",
      url: "/user/apiSetUserRanking/"+session_id+"/"+user_id+"/"+user_ranking_id+"/"+category_id+"/"+mask,
      datatype: "json",
      success: function(data) {
      },
    });
  },
  */
};

// ----------------------------------------
// イベント動作系
// ----------------------------------------
// ページロード時
$(document).ready(function(){
  Search.get();
});
// 認証
$("#auth").change(function(){
  var password = $(this).val();
  Auth.check(password);
});



// -- END.
});
