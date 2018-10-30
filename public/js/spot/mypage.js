$(function(){
// -- START

var url = location.href;
var urlparam = url.split("/");
var user_id = 1;
var popup_top = 0;
var content_height = $("#content").height();
var post_base = '';
var path = location.pathname.split('/');
if(path[1] == 'dev_nicomato'){
	post_base = '/'+path[1];
}

/*
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
*/

$(window).scroll(function () {
	var y = $(window).scrollTop();
	console.log("top:"+y);
	$('#sidebar').css('margin-top', y+'px');
	//$('#sidebar_menu').css('margin-top', y+'px');
});

$('#category_submit').click(function(){
	var user_id     = $(this).parent().find('input[name=user_id]').val();
	var category_id = $(this).parent().find('select').val();
	$(location).attr("href", post_base+"/spot/mypage/"+user_id+'/'+category_id);
});

$('.play').click(function(){
	var id  = $(this).attr('movie_id');
	var sec = $(this).attr('sec');
	window.open(post_base+"/spot/play/"+id+"/800/450/"+sec, 'player');
	$('#sidebar').animate({right:"0px"}, 500);
});

$('#sidebar_menu').click(function(){
	$('#sidebar').animate({right:"-800px"}, 500);
});

// -- END.
});
