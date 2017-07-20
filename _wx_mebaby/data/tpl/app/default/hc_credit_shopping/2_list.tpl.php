<?php defined('IN_IA') or exit('Access Denied');?><html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title><?php  echo $setting['title'];?></title>
    <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width" name="viewport">
		<script src="../addons/hc_credit_shopping/style/js/jquery-1.11.1.min.js"></script>

<script type='text/javascript' src='../addons/hc_credit_shopping/images/touchslider.min.js'></script>
<script language='javascript' src='../addons/hc_credit_shopping/images/photoswipe/simple-inheritance.min.js'></script>
<script language='javascript' src='../addons/hc_credit_shopping/images/photoswipe/photoswipe-1.0.11.min.js'></script>
<link href="../addons/hc_credit_shopping/images/photoswipe/photoswipe.css" rel="stylesheet"/>
<script language="javascript" src="../addons/hc_credit_shopping/images/touchslider.min.js"></script>
<script language="javascript" src="../addons/hc_credit_shopping/images/swipe.js"></script>
<link type="text/css" rel="stylesheet" href="../addons/hc_credit_shopping/images/style.css?1445397915">



        <link rel="stylesheet" href="../addons/hc_credit_shopping/style/img/p/yymobile/1509301730/css/common.css">
        <link rel="stylesheet" href="../addons/hc_credit_shopping/style/img/p/yymobile/1509301730/css/index.css">

</head>
<body>
<div class="g-header">

    <!-- 导航栏 -->
    <div class="m-nav">
        <div class="g-wrap">
            <ul class="m-nav-list">
                    <li class="selected"><a href="<?php  echo $this->createMobileUrl('list')?>"><span>首页<span></span></span></a></li>
                    <li><a href="<?php  echo $this->createMobileUrl('list2')?>"><span>全部商品<span></span></span></a></li>

<!--                     <li><a href="<?php  echo $this->createMobileUrl('shai_view')?>"><span>晒单<span></span></span></a></li>
 -->
                    <li><a href="<?php  echo $this->createMobileUrl('home')?>"><span>个人中心<span></span></span></a></li>
                            </ul>
        </div>
    </div>
</div>

<div class="g-body">

    <div class="m-index">
	
        <div id="banner_box" class="box_swipe">
            <ul style="background:#FFF;">
                <?php  if(is_array($piclist)) { foreach($piclist as $row) { ?>
                <li style="text-align:center;list-style: none;">
                    <a  onclick="javascript:location.href='<?php  echo $row['link'];?>'">
                        <img src="<?php  echo $_W['attachurl'];?><?php  echo $row['thumb'];?>" height="200px" style="text-align: -webkit-center;display: -webkit-inline-box;"/>
                    </a>
                </li>
                <?php  } } ?>
            </ul>
            <ol>
                <?php  if(is_array($piclist)) { foreach($piclist as $row) { ?>
                <li class="on"></li>
                <?php  } } ?>
            </ol>
        </div>

        <script>
            var proimg_count = <?php  echo count($piclist)?>;
            $(function () {
                new Swipe($('#banner_box')[0], {
                    speed: 500,
                    auto: 3000,
                    callback: function () {
                        var lis = $(this.element).next("ol").children();
                        lis.removeClass("on").eq(this.index).addClass("on");
                    }
                });
                if (proimg_count > 0) {
                    (function (window, $, PhotoSwipe) {
                        $('#banner_box ul li a[rel]').photoSwipe({});
                    }(window, window.jQuery, window.Code.PhotoSwipe));
                }
            });
        </script>

		
        <div class="g-wrap g-body-bd">

		 <div class="m-index-mod m-index-reveal">
 
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
            <div class="m-index-mod m-index-newArrivals">
                <div class="m-index-mod-hd">
                    <h3>上架新品</h3>
                    <a href="<?php  echo $this->createMobileUrl('list2',array('isnew'=>1))?>" class="m-index-mod-more">更多</a>
                </div>
                <div class="m-index-mod-bd">
                    <ul class="w-goodsList w-goodsList-brief m-index-newArrivals-list">
                    <?php  if(is_array($rhot)) { foreach($rhot as $hot) { ?>
							<li class="w-goodsList-item">
    <div class="w-goods w-goods-brief">
        <div class="w-goods-pic">
            <a title="<?php  echo $hot['title'];?>" href="<?php  echo $this->createMobileUrl('detail', array('id' => $hot['id']))?>">
                <img onerror="this.srcthis.src../addons/hc_credit_shopping/style/img/m.png'" src="<?php  echo $_W['attachurl'];?><?php  echo $hot['thumb'];?>" alt="<?php  echo $hot['title'];?>" class="">
            </a>
        </div>
        <p class="w-goods-title f-txtabb"><a href="<?php  echo $this->createMobileUrl('detail', array('id' => $list['id']))?>" title="<?php  echo $hot['title'];?>"><?php  echo $hot['title'];?> &nbsp&nbsp <?php  echo intval($hot['marketprice'])?>积分</a></p>
    </div>
                    <?php  } } ?>       
							</li>
                           
                    </ul>
                </div>
            </div>
            <div class="m-index-mod m-index-popular">
                <div class="m-index-mod-hd">
                    <h3>今日热门商品</h3>
                    <a href="<?php  echo $this->createMobileUrl('list2',array('ishot'=>1))?>" class="m-index-mod-more">更多</a>
                </div>
                <div class="m-index-mod-bd">
	    <ul class="w-goodsList w-goodsList-s m-index-popular-list">

	<?php  $n=2?>
	<?php  if(is_array($rlist)) { foreach($rlist as $list) { ?>
	<?php  if($n%2 == 0) { ?>
	<li class="w-goodsList-item">
            <div data-buyunit="1" data-price="6088" data-period="16418" data-gid="148" class="w-goods w-goods-ing">
			<div class="w-goods-pic">
				<a href="<?php  echo $this->createMobileUrl('detail', array('id' => $list['id']))?>">
					<img onerror="this.src../addons/hc_credit_shopping/style/img/m.png'" src="	<?php  echo $_W['attachurl'];?><?php  echo $list['thumb'];?>" alt="<?php  echo $list['title'];?>" class="">
				</a>
			</div>
				<div class="w-goods-info">
					<p class="w-goods-title f-txtabb"><a href="<?php  echo $this->createMobileUrl('detail', array('id' => $list['id']))?>"><?php  echo $list['title'];?> &nbsp&nbsp <?php  echo intval($list['marketprice'])?>积分</a></p>
					<!--<p class="w-goods-price">库存：<?php  echo $list['total'];?> </p> -->
					<div class="w-progressBar">
						<p class="wrap">
							<span style="width:<?php  echo round($list['sales']*100/($list['total']+$list['sales']),2) ?>%;" class="bar"><i class="color"></i></span>
						</p>
						<ul class="txt">
							<li class="txt-l"><p><b><?php  echo $list['sales'];?></b>已购买</p></li>
							<li class="txt-r"><p>剩余<b class="txt-blue"><?php  echo $list['total'];?></b></p></li>
						</ul>
					</div>
				</div>
			</div>
    </li>
	<?php  } else { ?>
		<li class="w-goodsList-item">
         
            <i class="ico ico-label ico-label-ten"></i>
            <div data-buyunit="10" data-price="11880" data-period="2769" data-gid="349" class="w-goods w-goods-ing">
        <div class="w-goods-pic">
            <a href="<?php  echo $this->createMobileUrl('detail', array('id' => $list['id']))?>">
              <img onerror="this.srcthis.src../addons/hc_credit_shopping/style/img/m.png'" src="	<?php  echo $_W['attachurl'];?><?php  echo $list['thumb'];?>" alt="<?php  echo $list['title'];?>" class="">
            </a>
        </div>
        <div class="w-goods-info">
            <p class="w-goods-title f-txtabb"><a href="<?php  echo $this->createMobileUrl('detail', array('id' => $list['id']))?>"><?php  echo $list['title'];?> &nbsp&nbsp <?php  echo intval($list['marketprice'])?>积分</a></p>
            <p class="w-goods-price">库存:$list['total']</p>
            <div class="w-progressBar">
                <p class="wrap">
                    <span style="width:<?php  echo round($list['sales']*100/($list['total']+$list['sales']),2) ?>%;" class="bar"><i class="color"></i></span>
                </p>
                <ul class="txt">
                    <li class="txt-l"><p><b><?php  echo $list['sales'];?></b>已购买</p></li>
                    <li class="txt-r"><p>剩余<b class="txt-blue"><?php  echo $list['total']?></b></p></li>
                </ul>
            </div>
        </div>
    </div>
    </li>	
		
		
	<?php  $n = $n+1?>
	<?php  } ?>
	<?php  } } ?>
		</ul>

                    <div class="w-more">
                        <a href="<?php  echo $this->createMobileUrl('list')?>" style="height:5%">点击查看更多商品</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<button style="display: none;" class="w-button w-button-round w-button-backToTop" id="pro-view-0">返回顶部</button>
<a onclick="header()" class="w-miniCart" id="pro-view-1"><span class="w-miniCart-text">清单</span><i class="ico ico-miniCart"></i><b style="display:none" data-pro="count" class="w-miniCart-count">0</b></a>

<script>
function header(){
	var url = "<?php  echo $this->createMobileUrl('check_order')?>";
	location.href = url;
}
</script>

<!--转发js-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php  $signPackage=$_W['account']['jssdkconfig'];?>	           
<?php  $setting=$this->module['config'];?>	           
<script type="text/javascript">
  wx.config({
    debug: false,
    appId: '<?php  echo $signPackage["appId"];?>',
    timestamp: '<?php  echo $signPackage["timestamp"];?>',
    nonceStr: '<?php  echo $signPackage["nonceStr"];?>',
    signature: '<?php  echo $signPackage["signature"];?>',
    jsApiList: [
      'onMenuShareAppMessage',
	  'onMenuShareTimeline',
	  'onMenuShareQQ',	  
    ]
  });
  wx.ready(function () {
    wx.onMenuShareAppMessage({
      title: "<?php  echo $setting['zhuanfa_title'];?>",
      desc: "<?php  echo $setting['zhuanfa_content'];?>",
      link: "<?php  echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)?>",
      imgUrl: "<?php  echo $_W['attachurl'].$setting['zhuanfa_img']?>",
      trigger: function (res) {
        //alert('用户点击发送给朋友');
      },
      success: function (res) {
        //window.location.href =adurl;//分享成功回调
      },
      cancel: function (res) {
       //window.location.href =adurl;//取消回调
      },
      fail: function (res) {
        alert(JSON.stringify(res));//失败回调
      }
    });
	wx.onMenuShareTimeline({
      title: "<?php  echo $setting['zhuanfa_title'];?>",
      desc: "<?php  echo $setting['zhuanfa_content'];?>",
      link: "<?php  echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)?>",
      imgUrl: "<?php  echo $_W['attachurl'].$setting['zhuanfa_img']?>",
      trigger: function (res) {
        //alert('用户点击发送给朋友');
      },
      success: function (res) {
        //window.location.href =adurl;//分享成功回调
      },
      cancel: function (res) {
       //window.location.href =adurl;//取消回调
      },
      fail: function (res) {
        alert(JSON.stringify(res));//失败回调
      }
    });
	wx.onMenuShareQQ({
      title: "<?php  echo $setting['zhuanfa_title'];?>",
      desc: "<?php  echo $setting['zhuanfa_content'];?>",
      link: "<?php  echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)?>",
      imgUrl: "<?php  echo $_W['attachurl'].$setting['zhuanfa_img']?>",
      trigger: function (res) {
        //alert('用户点击发送给朋友');
      },
      success: function (res) {
        //window.location.href =adurl;//分享成功回调
      },
      cancel: function (res) {
       //window.location.href =adurl;//取消回调
      },
      fail: function (res) {
        alert(JSON.stringify(res));//失败回调
      }
    });
	
	
	
	
  });
  

  
  
  
  
</script>









</body></html>