(function ($) {
    $.fn.rssReader = function (j) {
        
		/*Exemple = {
			targeturl: 'demo/ext/rssreader/rss.php',
			max: 10,
			init : avant,
			succes : affiche
		}*/

        
        if (!j) return false;
        if (!j.targeturl) return false;
        //var ie = ($.browser.msie);
        var div = this[0];
		
		$.ajax({
			type: "get",
			url: j.targeturl,
			dataType: "xml",
			processData: false,
			beforeSend: j.init,
			success: function ( reponse ) {
				var i = 0;
				var max = j.max;
				
				$( reponse ).find('rss').each( function () {
					$(this).find('item').each( function (i) {
						if (i > max - 1) return;
						var item = $(this);
						$(j.succes(
							item.find('title').text(),
							item.find('pubDate').text(),
							item.find('link').text(),
							item.find('description').text()
						)).appendTo(div);
					});
				});
				$( reponse ).find('feed').each( function () {
					$(this).find('entry').each( function (i) {
						if (i > max - 1) return;
						var item = $(this);
						$(j.succes(
							item.find('title').text(),
							item.find('updated').text(),
							item.find('link')[0].getAttribute("href"),
							item.find('content').text()
						)).appendTo(div);
					});
				});
			}
		});
	};
})(jQuery);
