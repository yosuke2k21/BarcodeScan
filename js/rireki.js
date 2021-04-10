
(function($) {
	$.fn.tile = function(columns) {
		var tiles, max, c, h, last = this.length - 1, s;
		if(!columns){
		 columns = this.length;
		}
		this.each(function() { //heightを取得
			s = this.style;
			if(s.removeProperty){
			 s.removeProperty("height");
		}
			if(s.removeAttribute){ 
				s.removeAttribute("height");
			}
		});
		return this.each(function(i) { //高さ調整
			c = i % columns;
			if(c == 0){ 
				tiles = [];
			}
			tiles[c] = $(this);
			h = tiles[c].height();
			if(c == 0 || h > max){ 
				max = h;
			}

			if(i == last || c == columns - 1){// 履歴の高さを調整
				$.each(tiles, function() { this.height(max); });
			}
		});
	};
})
(jQuery);
$(function(){
	$('.Layout').on('mouseenter', '.btn-action', function(event){
		event.preventDefault();
		$(this).find('img').addClass('animate');
		$(this).find('img').animate({'opacity':0.6},300);
		
	})
	$('.Layout').on('mouseleave', '.btn-action', function(event){
		event.preventDefault();
		$(this).find('img').removeClass('animate');
		$(this).find('img').animate({'opacity':1.0},300);

	});
	
});