<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>赛格国际停车缴费/寻车功能上线</title>
<link rel="stylesheet" href="../addons/member/template/mobile/static/img/park/img/parallax.css">
<link rel="stylesheet" href="../addons/member/template/mobile/static/img/park/img/parallax-animation.css">
<link rel="stylesheet" href="../addons/member/template/mobile/static/img/park/img/style.css">
<meta name="viewport"  content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/> 
</head>
<body>
<div style="display:none">
	 <img src="../addons/member/template/mobile/static/img/park/img/park/img/tototo.jpg" />
</div>
<div class="wrapper">
    <div class="pages">
	     <!-- 第1屏 -->
        <section class="page1 page">
            <div class="text1" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/1-1.png" />
            </div>
        </section>

        <!-- 第2屏 -->
       <section class="page2 page">
        	 <div class="text3" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/3-1.png" />
            </div>
        </section>

        <!-- 第3屏 -->
 		<section class="page3 page">
            <div class="text2" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/2-1.gif" />
            </div>
        </section>

		
        <!-- 第4屏 -->
        <section class="page4 page">
             <div class="text5" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/5-1.png" />
            </div>
        </section>
        <!-- 第4屏 -->
        <section class="pagea1 page">
             <div class="text5" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/a1-1.png" />
            </div>
        </section>

        <!-- 第5屏 -->
        <section class="page5 page">
      	 <div class="text4" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/4-1.png" />
            </div>
        </section>
        
        <!-- 第6屏 -->
        <section class="page6 page"></section>
        <!-- 第7屏 -->
        <section class="page7 page">
            <div class="text6" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/7-1.png" />
            </div>
        </section>
        <!-- 第8屏 -->
        <section class="page8 page">
            <div class="text7" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/8-1.png" />
            </div>
        </section>
        <!-- 第9屏 -->
        <!--<section class="page9">
            <div class="text8" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/9-1.png" />
            </div>
        </section>-->
        <!-- 第10屏 -->
        <section class="page10 page">
            <div class="text9" data-animation="fadeInToTop" data-timing-function="ease-in">
	            <img src="../addons/member/template/mobile/static/img/park/img/qrcode.png" />
            </div>
        </section>
       
    </div>
</div>

<script src="../addons/member/template/mobile/static/img/park/js/zepto.min.js"></script>
<script src="../addons/member/template/mobile/static/img/park/js/parallax.js"></script>
<script>
$('.pages').parallax({
    direction: 'vertical',     // horizontal (水平翻页)
    swipeAnim: 'default',     // cover (切换效果)
    drag:      true,        // 是否允许拖拽 (若 false 则只有在 touchend 之后才会翻页)
    loading:   true,        // 有无加载页
    indicator: false,        // 有无指示点
    arrow:     true,        // 有无指示箭头
    /*
     * 翻页后立即执行
     * {int}         index: 第几页
     * {DOMElement} element: 当前页节点
     * {String}        directation: forward(前翻)、backward(后翻)、stay(保持原页)
     */
     
    onchange: function(index, element, direction) {
        // code here...
//       if(index==7){
//        location.href='job.html';
//       }
//       console.log(index);
    },
    /*
     * 横竖屏检测
     * {String}        orientation: landscape / protrait
     */
    orientationchange: function(orientation) {
        // code here...    
    }
    //hr@sagabuy.com
    


});
 
function playSetting(){
  var audio = document.getElementById('my');
  if(!audio.paused)  
	 {
	  $(".replay").removeClass('play');
	  $(".replay").addClass('stop');
	  audio.pause();// 这个就是暂停//audio.play();// 这个就是播放  
	 }else{
	   $(".replay").removeClass('stop');
	  $(".replay").addClass('play');
	  audio.play();
	 }
}
//横向滑动
</script>
<div style="display:none">
	<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1257422589'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D1257422589' type='text/javascript'%3E%3C/script%3E"));</script>
</div>
</body>
</html>
