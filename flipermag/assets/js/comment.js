jQuery(document).ready(function($) {
	"use strict";
	
	// 控制留言輸入區塊
	$('.article-comment-wrapper .comment-input.logined').click(function(event){
		event.preventDefault();
		$(this).find('.input').focus();
	});
	$('.article-comment-wrapper .comment-input .input').on('input', function(){
		if ( $(this).text() != '' ) {
			$(this).parent().addClass('expand');
		} else {
			$(this).parent().removeClass('expand');
		}
	});

	// 將複製貼上的內容改為純文字
	$('.article-comment-wrapper .comment-input .input').on('paste', function(event) {
		event.stopPropagation();
		event.preventDefault();
    	// get text representation of clipboard
    	var text = event.originalEvent.clipboardData.getData("text/plain");
    	// insert text manually
    	$('.comment-input-wrapper .input').append(text);
    	if ( $(this).text() != '' ) {
			$(this).parent().addClass('expand');
		} else {
			$(this).parent().removeClass('expand');
		}
	});

	// 回覆留言按鈕
	$('.article-comment-wrapper .comment-wrapper .reply-wrapper .reply').click(function(event){
		var e = $(event.target).parent().parent().nextAll('.comment-input-wrapper.replied')[0];
		$(e).css('display','block');
		if ( $(e).offset().top > $(window).scrollTop() + $(window).height() ) {
    		$([document.documentElement, document.body]).animate({
        		scrollTop: $(e).offset().top -100
    		}, 600);
		}
	});

	// 留言功能
	$('.article-comment-wrapper .comment-input .submit').click(function(event){
		event.preventDefault();

		// 抓取使用者輸入的留言資訊
		var content = '';
		var html_content = $(event.target).siblings('.input').html();
		$(event.target).siblings('.input').contents().each(function(){
			content += $(this).text();
			content += "\n";
		});

		// 若沒有輸入留言，則不處理
		if ( '' == content ) {
			return;
		}

		// 將留言區塊清空回初始狀態
		$(event.target).siblings('.input').html('');
		$(event.target).parent().removeClass('expand');

		var reply_comment_id = '0';
		var replied = '';
		if ( $(event.target).siblings('.reply-comment-id').length ) {
			reply_comment_id = $(event.target).siblings('.reply-comment-id').val();
			replied = 'replied';
		}
		
		// 將留言內容傳送到伺服器
		$.ajax({
            type: 'POST',
            url: site_url + '/wp-json/api/v2/comments',
            data: {post_id:$(event.target).data('id'), content: content, parent: reply_comment_id},
            dataType: 'json',
            success: function(response){
                if( response.hasOwnProperty('code') ) {
                	alert(response.message);
				} 
            },
            error: function(response) {
            	alert('發生錯誤，請稍候再試');
            	return;
            }
        });

		var current_time = new Date(); 
    	var current_time = current_time.getFullYear() + '/' + ('0' + (current_time.getMonth() + 1)).slice(-2) + '/' + ('0' + (current_time.getDate())).slice(-2) + ' ' + ('0' + (current_time.getHours())).slice(-2) + ':' + ('0' + (current_time.getMinutes())).slice(-2) + ':' + ('0' + (current_time.getSeconds())).slice(-2);
    	var user_name = $(event.target).siblings('.user-name').val();
    	var user_url = $(event.target).siblings('.user-url').val();
    	var user_avatar = $(event.target).siblings('.user-avatar').val();
		var ele = '<div class="comment-wrapper ' + replied + '" data-date="' + current_time + '">\
			<div class="comment-meta">\
			<div class="avatar" title="' + user_name + '"><a href="' + user_url + '"><img src="' + user_avatar + '" width="300" height="300" alt="supernovar" class="avatar avatar-300 wp-user-avatar wp-user-avatar-300 alignnone photo"></a></div>\
			<div class="comment-meta-inner">\
			<div class="user-name">\
			<a href="' + user_url + '">' + user_name + '</a>\
			</div>\
			<time class="time timeago" datetime="' + current_time + '" title="' + current_time + '">' + current_time + '</time>\
			</div>\
			</div>\
			<div class="comment-body">' + html_content + '</div>\
			<div class="reply-wrapper">\
			<button class="reply">回覆</button>\
			</div>\
			</div>';

		// 判斷是新增留言還是回覆留言，決定留言該放在哪裡
		if ( '' == replied ) {
			$(event.target).parent().parent().parent().find('.comment-card').prepend(ele);	
		} else {
			$(event.target).parent().parent().before(ele);
		}
        $('time.timeago').timeago();
        _jf.flush();
	});

});