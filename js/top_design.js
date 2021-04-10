$(function () {
    var   bgscx1 = 0;var   bgscy1 = 0; //画像の座標　
    var   bgscx2 = 0;var   bgscy2 = 0;
    var   bgscx3 = 0;var   bgscy3 = 0;
setInterval(function(){
    bgscx1 += 0.15;bgscy1 += 0;//画像の座標のアニメーション
    bgscx2 += 0.25;bgscy2 += 0;
    bgscx3 += 0.75;bgscy3 += 0;
    $(".skinBody1").css("background-position", bgscx1 + "px " + bgscy1 + "px");//画像を背景として扱う
    $(".skinBody2").css("background-position", bgscx2 + "px " + bgscy2 + "px");
    $(".skinBody3").css("background-position", bgscx3 + "px " + bgscy3 + "px");
    
});
});