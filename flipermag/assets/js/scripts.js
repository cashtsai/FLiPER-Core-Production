jQuery(document).ready(function($) {
	"use strict";

	// 時間顯示控制
	$('time.timeago').timeago();

	// 桌機版全站搜尋 icon
	$('#desktop-user-menu .search-icon').click(function(event){
		event.preventDefault();
		if ( $('#desktop-user-menu .search-form-input').is(":focus") ) {
			$('#desktop-user-menu .search-form-input').blur();
		} else {
			$('#desktop-user-menu .search-form-input').focus();
		}
	});

	// 手機版全站搜尋 icon
	$('#mobile-user-menu .search-icon').click(function(event){
		event.preventDefault();
		if ( $('#mobile-user-menu .search-form-input').hasClass('active') ) {
			$('#mobile-user-menu .search-form-input').removeClass('active');
		} else {
			$('#mobile-user-menu .search-form-input').addClass('active');
		}
	});
	$('body').on('touchstart', function(event){
		if ( ! $(event.target).is($('#mobile-user-menu .search-icon') ) && 
			 ! $(event.target).is($('#mobile-user-menu .search-form-input') ) ) {
			$('#mobile-user-menu .search-form-input').removeClass('active');
		}
	});

	// 手機版 user menu
	$('#mobile-user-menu .profile-icon.logged').click(function(event){
		event.preventDefault();
		if ( $(this).hasClass('active') ) {
			$('#mobile-user-menu .user-menu-wrap').css('margin-left', '0px');
			$('#mobile-menu-overlay').remove();
			$(this).removeClass('active');
			$('body').css('overflow','auto');
		} else {
			$(this).addClass('active');
			var top = ( 60 + $('#main-menu').position().top ) - jQuery(window).scrollTop();
			$('#mobile-user-menu .user-menu-wrap').css('margin-left', '-280px');
			$('#mobile-user-menu .user-menu-wrap').css('top', top );
			$('#main-container').append('<div id="mobile-menu-overlay" style="top:0px;left:0px;position: absolute;width: 100%;height: 100%;background: rgba(0,0,0,0.5);"></div>');
			$('body').css('overflow','hidden');
		}
	});
	// 手機版 nav menu
	$('#mobile-user-menu .nav-icon').click(function(event){
		event.preventDefault();
		if ( $(this).hasClass('active') ) {
			$('#mobile-user-menu .mobile-main-menu-inner').css('margin-left', '0px');
			$(this).removeClass('active');
			$('#mobile-menu-overlay').remove();
			$('body').css('overflow','auto');
		} else {
			$(this).addClass('active');
			var top = ( 60 + $('#main-menu').position().top ) - jQuery(window).scrollTop();
			$('#mobile-user-menu .mobile-main-menu-inner').css('top', top );
			$('#mobile-user-menu .mobile-main-menu-inner').css('margin-left', '-280px');
			$('#main-container').append('<div id="mobile-menu-overlay" style="top:0px;left:0px;position: absolute;width: 100%;height: 100%;background: rgba(0,0,0,0.5);"></div>');
			$('body').css('overflow','hidden');
		}
	});
	// 手機版解除顯示 user menu, nav menu
	$('body').on('touchstart', function(event){
		var user_menu_icon = '#mobile-user-menu .profile-icon.logged';
		var user_menu_icon_img = '#mobile-user-menu .profile-icon.logged img';
		var user_menu = '#mobile-user-menu .user-menu-wrap';
		var user_menu_item = '#mobile-user-menu .user-menu-wrap a';
		if ( ! $(event.target).is(user_menu_icon_img) && ! $(event.target).is(user_menu) && $(user_menu).find(event.target).length == 0 ) {
			$(user_menu).css('margin-left', '0px');
			$(user_menu_icon).removeClass('active');	
		}	
		var nav_menu_icon = '#mobile-user-menu .nav-icon';
		var nav_menu = '#mobile-user-menu .mobile-main-menu-inner';
		var nav_menu_item = '#mobile-user-menu .mobile-main-menu-inner a';
		if ( ! $(event.target).is(nav_menu_icon) && ! $(event.target).is(nav_menu) && $(nav_menu).find(event.target).length == 0 ) {
			$(nav_menu).css('margin-left', '0px');
			$(nav_menu_icon).removeClass('active');	
		}	
		if ( ! $(event.target).is(user_menu_icon) && 
			 ! $(event.target).is(user_menu) &&
			 $(user_menu).find(event.target).length == 0 &&
			 ! $(event.target).is(nav_menu_icon) && 
			 ! $(event.target).is(nav_menu) &&
			 $(nav_menu).find(event.target).length == 0 ) {
			$('#main-container').css('margin-left', '0px');
		}
		$('#mobile-menu-overlay').remove();
		$('body').css('overflow','auto');
	});
	
	$('.single .share.iconset').click(function(event){
		event.preventDefault();
		var url = $(this).data('url');
		var scroll = $(window).scrollTop();
		FB.ui({
  			method: 'share',
  			href:url
		}, function(response){
			$(window).scrollTop(scroll);
		});
	});

	// 追蹤按鈕
	$('.author .follow.iconset').click(function(event){
		event.preventDefault();
	});

	// 收藏按鈕
	$('.full-article .bookmark.iconset.logged').each(function(){
		$(this).click(function(event){
			event.preventDefault();
			if( $(this).hasClass('bookmarked') ) {
				$.ajax({
	        		type: 'POST',
	        		url: site_url + '/wp-json/api/v2/users/unfavorite/article',
	        		data: { id: $(this).data('id') },
	        		dataType: 'json',
					success: function(response){}
	    		});
	    		$('.full-article .bookmark.iconset.logged').removeClass('bookmarked');
			} else {
				$.ajax({
		    		type: 'POST',
	    			url: site_url + '/wp-json/api/v2/users/favorite/article',
		    		data: { id: $(this).data('id') },
	    			dataType: 'json',
		    		success: function(response){} 
	    		});
	    		$('.full-article .bookmark.iconset.logged').addClass('bookmarked');
	    	}
		});
	});
	
	// 無限閱讀
	if ( $('#infinite-readmore-icon').length ) {
		$(window).scroll(get_more_articles);
		var type = $('#infinite-readmore-icon').data('type');
		var url = location.protocol + '//' + location.host + '/wp-json/api/v2/articles';
		if ( 'author' == type ) {
			url = location.protocol + '//' + location.host + '/wp-json/api/v2/users/' + $('#infinite-readmore-icon').data('author-id');
		} else if ( 'favorite' == type ) {
			url = location.protocol + '//' + location.host + '/wp-json/api/v2/users/' + $('#infinite-readmore-icon').data('user-id');
		} 
		function get_more_articles() {
			var trigger_point = parseInt( $('#infinite-readmore-icon').offset().top ) - $(window).height();
			if ( $(document).scrollTop() > trigger_point ) {
				$(window).off('scroll', get_more_articles);
				var page = parseInt( $('#infinite-readmore-icon').data('page') );
				var article_offset = ( page - 1 ) * 15;
				var legacyApiToken = window.FLIPER_THEME_CONFIG && window.FLIPER_THEME_CONFIG.legacyApiToken ? window.FLIPER_THEME_CONFIG.legacyApiToken : '';
				var data = {};
				if ( 'category' == type ) {
					data = {'access_token':legacyApiToken, 'count':'15','category':$('#infinite-readmore-icon').data('cat-id'),'offset':article_offset};
				} else if ( 'tag' == type ) {
					data = {'access_token':legacyApiToken, 'count':'15','tag':$('#infinite-readmore-icon').data('tag-id'),'offset':article_offset};
				} else if ( 'search' == type ) {
					data = {'access_token':legacyApiToken, 'count':'15','search':$('#infinite-readmore-icon').data('keyword'),'offset':article_offset};
				} else if ( 'author' == type ) {
					data = {'access_token':legacyApiToken, 'count':'15','extra':'articles','offset':article_offset};
				} else if ( 'favorite' == type ) {
					data = {'count':'15','extra':'favorites','offset':article_offset};
				} else {
					data = {'access_token':legacyApiToken, 'count':'15','offset':article_offset};
				}
				$.ajax({
	  				dataType: 'json',
		  			url: url,
	  				data: data,
	  				success: function(response) {
	  					var content = '';
	  					var each_ele = response.list
	  					if ( 'author' == type) {
	  						each_ele = response.articles.list;
	  					} else if ( 'favorite' == type ) {
	  						each_ele = response.favorites.list;
	  					}
	  					$.each( each_ele, function( i, el ) {
	  						if ( 0 === i % 3 ) {
	  							content += '<ul class="list-articles-wrap row">';
	  						}
	  						content += '<li class="article">';
	  						if ( el.cover.list_articles_thumb_2x ) {
	  							content += '<div class="feature-image"><a class="block" href="' + el.url + '"><img src="' + el.cover.list_articles_thumb_2x.source + '" /></a></div>';	
	  						} else {
	  							content += '<div class="feature-image"><a class="block" href="' + el.url + '"><img src="' + el.cover.o.source + '" /></a></div>';
	  						}
							content += '<h2 class="title"><a href="' + el.url + '">' + el.title + '</a></h2>';
							content += '<div class="article-info blue">' + el._date + ' | ' + el.main_category.name + '</div>';
							content += '<div class="excerpt"><p>' + el.excerpt + '</p></div>';
	  						content += '</li>';
	  						if ( 2 === i % 3) {
	  							content += '</ul>';
	  						}
	  					});
	  					var total_count = response.count;
	  					if ( 'author' == type) {
	  						total_count = response.articles.count;
	  					} else if ( 'favorite' == type ) {
	  						total_count = response.favorites.count;
	  					}
	  					if ( 0 != total_count % 3 ) {
	  						content += '</ul>';
	  					}
	  					$(content).insertBefore($('#infinite-readmore-icon').parent());
	  					_jf.flush();
		 				$('#infinite-readmore-icon').data('page', page + 1);

		 				// Send ga traking
						if (typeof gtag === 'function') {
							let value = type;
							if ( 'category' == type ) {
								value += '-' + $('#infinite-readmore-icon').data('cat-id')
							} else if ( 'tag' == type ) {
								value += '-' + $('#infinite-readmore-icon').data('tag-id')
							} else if ( 'search' == type ) {
								value += '-' + $('#infinite-readmore-icon').data('keyword')
							} else if ( 'author' == type ) {
								value += '-' + $('#infinite-readmore-icon').data('author-id')
							} else if ( 'favorite' == type ) {
								value += '-' + $('#infinite-readmore-icon').data('user-id')
							}
							gtag('event', 'read_more', {
    							'event_category': '瀏覽文章',
    							'event_label': '讀取更多文章（無限閱讀）',
    							'value': value
  							});
						}
						if ( total_count == 15 ) {
							$(window).scroll(get_more_articles);	
						} else {
							$('#infinite-readmore-icon').parent().remove();
						}
	  				}
				});
			}
		}
	}

	// 修復文章頁面圖片太小，導致沒有置中問題
	// TODO：改成使用 css 解決
	if ( $('body').width() >= 1100 ) {
		$('.full-article .content p img').each(function(){
			if ( $(this).width() < 750 ) {
				var offset = ( 624 - $(this).width() ) / 2;
				$(this).css('margin-left', offset + 'px');
			}
		});
		$('.full-article .content figure').each(function(){
			if ( $(this).width() < 750 ) {
				var offset = ( 624 - $(this).width() ) / 2;
				$(this).css('margin-left', offset + 'px');
			}
		});	
	}

	// 取得單篇文章的 FB share count
	// TODO: 待 app 改為不顯示 share count 後移除此函式
	if ( $('#facebook-share-count').length ) {
		var url = $('#facebook-share-count').data('url');
		var total = $('#facebook-share-count').data('count');
		$.getJSON( 'https://graph.facebook.com/?id=' + url, {}, function(response){
			if(response.hasOwnProperty('share')) {
				if ( response.share.share_count > total ) {
					total = response.share.share_count;
					$.getJSON( site_url + '/wp-json/api/v2/update-social-share-count?url=' + url, {}, function(response){} );
				}
			}
		});	
	}
	
	// 將正在閱讀的文章 id 存入 cookie
	// 若不是正在閱讀單篇文章，則不執行
	if ( typeof(article_id) == 'string') {
		var current_date = new Date();
		var week_date = current_date.getDay();
		var cname = 'rp' + week_date;
		var ps = get_cookie(cname);
		if ( '' != ps ) {
			ps = ps.split(',');
		} else {
			ps = [];
		}
		if ( -1 === $.inArray(article_id, ps)) {
			ps.push(article_id);
		}
		ps = ps.join();
		set_cookie(cname, ps, 6);
	}

});


function escape_html( unsafe ) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function nl2br(str, is_xhtml) {   
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function set_cookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function get_cookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
