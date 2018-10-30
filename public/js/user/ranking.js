$(function(){
// -- START

var url = location.href;
var urlparam = url.split("/");
var user_id = urlparam[5];
var session_id = "";

// ----------------------------------------
// API�A�N�Z�X�n
// ----------------------------------------
// �F��
var Auth = {
  check : function(password){
    $.ajax({
      type: "GET",
      url: "/api/auth/"+user_id+"/"+password,
      datatype: "json",
      success: function(data) {
          if (data.success == true) {
            // �Z�b�V�����h�c���Z�b�g
            session_id = data.session_id;
            // ���ׂẴt�H�[��������
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
// �擾
var Ranking = {
  get : function(user_ranking_id,category_id,mask){
    $.ajax({
      type: "GET",
      url: "/user/apiGetRanking/"+category_id+"/"+mask,
      datatype: "json",
      success: function(data) {
        var target = $("div[user_ranking_id="+user_ranking_id+"]").parent().find("div.ranking_list");
        target.empty();
        data.forEach(function(elem) {
          var movie_id = elem.RankingNicovideo.movie_id;
          var image_url= 'http://tn-skr3.smilevideo.jp/smile?i='+movie_id.substr(2);
          var title    = elem.RankingNicovideo.title;
          target.append('<div class="ranking_content"><a href="http://www.nicovideo.jp/watch/'+movie_id+'" target="blank"><img src="'+image_url+'"><span>'+title+'</span></a></div>');
        });
      },
    });
  },
  set : function(user_ranking_id,category_id,mask){
    $.ajax({
      type: "GET",
      url: "/user/apiSetUserRanking/"+session_id+"/"+user_id+"/"+user_ranking_id+"/"+category_id+"/"+mask,
      datatype: "json",
      success: function(data) {
      },
    });
  },

};

// ----------------------------------------
// �C�x���g����n
// ----------------------------------------
// �y�[�W���[�h��
$(document).ready(function(){
  // �e�J�e�S������
  $(".row_edit").each(function(){
    // �t�H�[�������b�N(�F�ؑO)
    $(this).find("select").attr("disabled","disabled");
    $(this).find("input").attr("disabled","disabled");
    var user_ranking_id = $(this).attr('user_ranking_id');
    var category_id = $(this).find("option:selected").val();
    var mask = $(this).find("input").val();
    // �����L���O�f�[�^�擾
    Ranking.get(user_ranking_id, category_id, mask);
  });
});
// �F��
$("#auth").change(function(){
  var password = $(this).val();
  Auth.check(password);
});
// �v���_�E���ύX
$("select").change(function(){
  var user_ranking_id = $(this).parent().attr('user_ranking_id');
  var category_id = $(this).find("option:selected").val();
  var mask = $(this).parent().find("input").val();
  Ranking.set(user_ranking_id, category_id, mask);
  Ranking.get(user_ranking_id, category_id, mask);
});
// �t�H�[���ύX
$(".row_edit > input").change(function(){
  var user_ranking_id = $(this).parent().attr('user_ranking_id');
  var category_id = $(this).parent().find("option:selected").val();
  var mask = $(this).val();
  Ranking.set(user_ranking_id, category_id, mask);
  Ranking.get(user_ranking_id, category_id, mask);
});



// -- END.
});
