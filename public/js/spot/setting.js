$(function(){
// -- START

var user_id = $("input[name=user_id]").val();
var session = "";
var post_base = '';
var path = location.pathname.split('/');
if(path[1] == 'dev_nicomato'){
	post_base = '/'+path[1];
}


// ----------------------------------------
// APIアクセス系
// ----------------------------------------
var Api = {
  // 認証
  check : function(password){
    $.ajax({
      type: "GET",
      url: post_base+"/spot/auth/"+user_id+"/"+password,
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

// カテゴリ追加
$("#add_category_submit").click(function(){
	var name = $("#add_category_name").val();
	$.ajax({
		type: "POST",
		url: post_base+"/spot/addCategory/"+user_id,
		datatype: "json",
		data: {
			"name": name,
			"session": session,
		},
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
				$(location).attr("href", post_base+"/spot/setting/"+user_id);
			} else {
				user_alert(data.msg);
			}
		},
	});
});

// カテゴリ変更
$(".change_category_submit").click(function(){
	var name = $(this).parent().find("input[name=category_name]").val();
	var id = $(this).attr("category_id");
	$.ajax({
		type: "POST",
		url: post_base+"/spot/changeCategory/"+user_id,
		datatype: "json",
		data: {
			"id": id,
			"name": name,
			"session": session,
		},
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
				$(location).attr("href", post_base+"/spot/setting/"+user_id);
			} else {
				user_alert(data.msg);
			}
		},
	});
});

// 動画追加
$("#add_movie_submit").click(function(){
	var url = $(this).parent().parent().find("input[name=movie_url]").val();
	var min = $(this).parent().parent().find("input[name=min]").val();
	var sec = $(this).parent().parent().find("input[name=sec]").val();
	var comment = $(this).parent().parent().find("input[name=comment]").val();
	var category_id = $(this).parent().parent().find("select option:selected").val();
	$.ajax({
		type: "POST",
		url: post_base+"/spot/addMovie/"+user_id,
		datatype: "json",
		data: {
			"movie_url": url,
			"min": min,
			"sec": sec,
			"comment": comment,
			"category_id": category_id,
			"session": session,
		},
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
				$(location).attr("href", post_base+"/spot/setting/"+user_id);
			} else {
				user_alert(data.msg);
			}
		},
	});
});

// 動画変更
$(".change_movie_submit").click(function(){
	var id = $(this).attr("spot_movie_id");
	var url = $(this).parent().parent().find("input[name=movie_url]").val();
	var min = $(this).parent().parent().find("input[name=min]").val();
	var sec = $(this).parent().parent().find("input[name=sec]").val();
	var comment = $(this).parent().parent().find("input[name=comment]").val();
	var category_id = $(this).parent().parent().find("select option:selected").val();
	$.ajax({
		type: "POST",
		url: post_base+"/spot/changeMovie/"+user_id,
		datatype: "json",
		data: {
			"id": id,
			"movie_url": url,
			"min": min,
			"sec": sec,
			"comment": comment,
			"category_id": category_id,
			"session": session,
		},
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
				$(location).attr("href", post_base+"/spot/setting/"+user_id);
			} else {
				user_alert(data.msg);
			}
		},
	});
});

// カテゴリ一括変更
$("#select_category").click(function(){
	var movie_list = $("#movie_list").find(".sl:checked").map(function(){
		return $(this).val();
	}).get();
	var category_id = $(this).parent().parent().find("select option:selected").val();

	$.ajax({
		type: "POST",
		url: post_base+"/spot/changeSelectCategory/"+user_id,
		datatype: "json",
		data: {
			"session": session,
			"category_id": category_id,
			"list": movie_list,
		},
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
				$(location).attr("href", post_base+"/spot/setting/"+user_id);
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
		url: post_base+"/spot/changePageTitle/"+user_id,
		datatype: "json",
		data: ({
			"title": new_title,
			"session": session,
		}),
		success: function(data) {
			if (data.success == true) {
				user_alert(data.msg);
				$(location).attr("href", post_base+"/spot/setting/"+user_id);
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
		url: post_base+"/spot/changePassword/"+user_id,
		datatype: "json",
		data: ({
			"password": new_password,
			"session": session,
		}),
		success: function(data) {
			if (data.success == true) {
				$("#auth").val(new_password);
				user_alert(data.msg);
				$(location).attr("href", post_base+"/spot/setting/"+user_id);
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
