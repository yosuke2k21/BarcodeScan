
$(function(){
	$('.first').on('mouseenter', '.btn-action', function(event){//画像の上にマウスが載ったら
		event.preventDefault();
		$(this).find('img').addClass('animate');
		$(this).find('img').animate({'opacity':0.6},300);//透明度の変更
		
	})
	$('.first').on('mouseleave', '.btn-action', function(event){//マウスが離れたら
		event.preventDefault();
		$(this).find('img').removeClass('animate');
		$(this).find('img').animate({'opacity':1.0},300);// 透明度の変更

	});
	$('.second').on('mouseenter', '.btn-action', function(event){
		event.preventDefault();
		$(this).find('img').addClass('animate');
		$(this).find('img').animate({'opacity':0.6},300);
	})
	$('.second').on('mouseleave', '.btn-action', function(event){
		event.preventDefault();
		$(this).find('img').removeClass('animate');
		$(this).find('img').animate({'opacity':1.0},300);
	});
	

});