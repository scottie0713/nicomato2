$(function(){
// -- START

var url = location.href;
var urlparam = url.split("/");


// ----------------------------------------
// イベント
// ----------------------------------------
// 新規登録
$("#regist_submit").click(function(){
	var title = $("#title").val();
	var textarea = $("#url").val();
	console.log(textarea);
	var password = $("#password").val();
	$.ajax({
		type: "POST",
		url: "/top/regist",
		datatype: "json",
		data: {
			"title": title,
			"url": textarea,
			"password": password,
		},
		success: function(data) {
			if (data.success == true) {
				alert("登録に成功しました。ページにジャンプします。");
				$(location).attr("href", "/user/mypage/"+data.user_id);
			} else {
				alert(data.msg);
			}
		},
	});
});

// -- END.
});
