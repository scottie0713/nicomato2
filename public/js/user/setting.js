$(function(){
// -- START

var user_id = $("input[name=user_id]").val();
var session = "";
//var post_base = "/nicomato"; /* 開発用 */
var post_base = ""; /* 本番用 */

// ----------------------------------------
// APIアクセス系
// ----------------------------------------
var Api = {
  // 認証
  check : function(password){
    $.ajax({
      type: "GET",
      url: post_base+"/user/auth/"+user_id+"/"+password,
      datatype: "json",
      success: function(data) {
          if (data.success == true) {
            // セッションＩＤをセット
            session = data.session;
            $("#auth").attr("disabled","disabled");
            $("#auth_result").css("color","green").html("OK");
			$(".session").val(session);
			$(".button_submit").show();
			$(".td_switch").show();
            $("#add_mylist").removeAttr("disabled");
            $("#new_title").removeAttr("disabled");
            $("#new_password").removeAttr("disabled");
          } else {
            $("#auth_result").css("color","red").html("NG");
          }
      },
    });
  }
};


// ページロード時
$(document).ready(function(){
	$(".button_submit").hide();
	$(".td_switch").hide();
	$("#add_mylist").attr("disabled","disabled");
	$("#new_title").attr("disabled","disabled");
	$("#new_password").attr("disabled","disabled");
    Api.check($("#auth").val());
});



// ----------------------------------------
// イベント
// ----------------------------------------
$("#auth").change(function(){
  var password = $(this).val();
  Api.check(password);
});

// 削除フラグ/更新チェックフラグ変更
$('.setting_btn').click(function(){
	var div = $(this);
	var mode = '';
	if ($(this).hasClass('delete_on')) {
		mode = 'delete_off';
	} else if($(this).hasClass('delete_off')) {
		mode = 'delete_on';
	} else if($(this).hasClass('check_on')) {
		mode = 'check_off';
	} else if($(this).hasClass('check_off')) {
		mode = 'check_on';
	}
	var data_type = $(this).attr("data_type");
	var mylist_str= $(this).attr("mylist_str");
	$.ajax({
		type: "POST",
		url: post_base+"/user/changeMylistFlag/"+user_id,
		datatype: "json",
		data: {
			"data_type": data_type,
			"mylist_str": mylist_str,
			"mode": mode,
			"session": session,
		},
		success: function(data) {
			if (data.success == true) {
				if (mode == 'delete_off') {
					div.removeClass('delete_on');
					div.addClass('delete_off');
					div.html('表示');
				} else if(mode == 'delete_on') {
					div.removeClass('delete_off');
					div.addClass('delete_on');
					div.html('削除');
				} else if(mode == 'check_off') {
					div.removeClass('check_on');
					div.addClass('check_off');
					div.html('非更新');
				} else if(mode == 'check_on') {
					div.removeClass('check_off');
					div.addClass('check_on');
					div.html('更新');
				}
			} else {
				user_alert(data.msg);
			}
		},
	});
});

// マイリスト追加
$("#add_mylist_submit").click(function(){
	var textarea = $("#add_mylist").val();
	$.ajax({
		type: "POST",
		url: post_base+"/user/addMylist/"+user_id,
		datatype: "json",
		data: {
			"text": textarea,
			"session": session,
		},
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
				$(location).attr("href", "/user/setting/"+user_id);
			} else {
				user_alert(data.msg);
			}
		},
	});
});


// ページタイトル変更
$("#new_title_submit").click(function(){
	var new_title = $("#new_title").val();
	$.ajax({
		type: "POST",
		url: post_base+"/user/changePageTitle/"+user_id,
		datatype: "json",
		data: ({
			"title": new_title,
			"session": session,
		}),
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
			} else {
				user_alert(data.msg);
			}
		},
	});
});

// パスワード変更
$("#new_password_submit").click(function(){
	var new_password = $("#new_password").val();
	$.ajax({
		type: "POST",
		url: post_base+"/user/changePassword/"+user_id,
		datatype: "json",
		data: ({
			"password": new_password,
			"session": session,
		}),
		success: function(data) {
			if (data.success == true) {
				$("#auth").val(new_password);
				user_alert(data.msg);
			} else {
				user_alert(data.msg);
			}
		},
	});
});

// alert
// 文字列があるときのみ表示
function user_alert(msg) {
	if (msg != undefined){
		if (msg != ''){
			alert(msg);
		}
	}
}

// -- END.
});
