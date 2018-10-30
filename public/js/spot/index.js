$(function(){
// -- START

var url = location.href;
var urlparam = url.split("/");
var post_base = '';
var path = location.pathname.split('/');
if(path[1] == 'dev_nicomato'){
	post_base = '/'+path[1];
}

// ----------------------------------------
// イベント
// ----------------------------------------
// 新規登録
$("#regist_submit").click(function(){
	var title = $("#title").val();
	var password = $("#password").val();
	$.ajax({
		type: "POST",
		url: post_base+"/spot/regist",
		datatype: "json",
		data: {
			"title": title,
			"password": password,
		},
		success: function(data) {
			if (data.success == true) {
				alert("登録に成功しました。ページにジャンプします。");
				$(location).attr("href", post_base+"/spot/mypage/"+data.user_id);
			} else {
				alert(data.msg);
			}
		},
	});
});

// -- END.
});
