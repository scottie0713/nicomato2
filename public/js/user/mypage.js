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

$('.mylist_box_more').click(function(){
	var position = $(this).parent().position();
	var box = $(this).parent();
	popup_top = parseInt(position.top);
	var data_type  = $(this).attr('type');
	var mylist_str = $(this).attr('str');
	//console.log(data_type);
	//console.log(mylist_str);

	if($(this).hasClass('bottom_open')){
        $.ajax({
          type: "GET",
          url: "/user/detail/"+data_type+"/"+mylist_str,
          datatype: "json",
          success: function(data) {
            if (data.success == true) {
                var loop_cnt = 0;
		        box.find('.init_title').hide();
 	   		    $.each(data.result, function(i, v){
 	   			var dt = v.published.substr(2,2)+'/'+v.published.substr(5,2)+'/'+v.published.substr(8,2)+'&nbsp;';
				if(data_type == 5){
 	   			  box.find(".mylist_box_bottom").find('.detail_title').append('<div class="title">'+dt+'<a href="https://www.youtube.com/watch?v='+v.movie_str+'" target="_blank">'+v.title+'</a></div>');
				}else{
 	   			  box.find(".mylist_box_bottom").find('.detail_title').append('<div class="title">'+dt+'<a href="http://www.nicovideo.jp/watch/'+v.movie_str+'" target="_blank">'+v.title+'</a></div>');
				}
 	   			loop_cnt++;
 	   		});
 	   		//var t = popup_top;
 	   		//if ((content_height - 600) < popup_top) {
 	   		//	t = content_height - 750;
 	   		//}
 	   		//console.log(box.html());
 	   		box.animate({"height": (18*loop_cnt+152)+'px'}, "fast");
 	   		box.find(".mylist_box_bottom").animate({"height": (18*loop_cnt)+'px'}, "fast");
 	   		box.find(".mylist_box_more").animate({"top": (18*loop_cnt+127)+'px'}, "fast");
 	   		box.find(".mylist_box_more").html('close');
 	        box.find(".mylist_box_more").removeClass('bottom_open');
 	        box.find(".mylist_box_more").addClass('bottom_close');
 	   		//$("#mypage_popup").css('top', t+'px');
 	   		//$("#popup_content").html(html);
 	   		//$("#mypage_popup").show();
              } else {
              }
          },
        });
	}else if($(this).hasClass('bottom_close')){
		box.find('.detail_title').html("");
		box.find('.init_title').show();
		box.animate({"height": '194px'}, "fast");
		box.find(".mylist_box_bottom").animate({"height": '42px'}, "fast");
		box.find(".mylist_box_more").animate({"top": '169px'}, "fast");
		box.find(".mylist_box_more").html('more');
		box.find(".mylist_box_more").removeClass('bottom_close');
		box.find(".mylist_box_more").addClass('bottom_open');
	}

});


// -- END.
});
