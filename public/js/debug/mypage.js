$(function(){
// -- START

var url = location.href;
var urlparam = url.split("/");
var user_id = 1;
var popup_top = 0;
var content_height = $("#content").height();

$('#popup_content').slimScroll({
	railVisible: true,
	railColor: '#f00',
	position: 'left',
	distance: '0px',
	height: '590px'
});

$('#popup_top > input').click(function(){
	$("#mypage_popup").hide();
});

$('.mylist_box_bottom').click(function(){
	var position = $(this).parent().position();
	popup_top = parseInt(position.top);
	var data_type  = 2;
	var mylist_str = '7398167';
    $.ajax({
      type: "GET",
      url: "/debug/detail/"+data_type+"/"+mylist_str,
      datatype: "json",
      success: function(data) {
          if (data.success == true) {
			console.log(data.result);
			var html = '<ul>';
			$.each(data.result, function(i, v){
				var dt = '['+v.published.substr(2,2)+'/'+v.published.substr(5,2)+'/'+v.published.substr(8,2)+']&nbsp;';
				html += '<li><img width="32" src="'+v.image+'" style="vertical-align:middle"/>'+dt+'<a href="http://www.nicovideo.jp/watch/'+v.movie_str+'" target="_blank">'+v.title+'</a></li>';
			});
			html += '</ul>';
			var t = popup_top;
			if ((content_height - 600) < popup_top) {
				t = content_height - 750;
			}
			$("#mypage_popup").css('top', t+'px');
			$("#popup_content").html(html);
			$("#mypage_popup").show();
          } else {
          }
      },
    });

});

// -- END.
});
