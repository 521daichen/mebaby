<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript" src="../addons/ewei_shopping/images/jquery.gcjs.js"></script>
<link type="text/css" rel="stylesheet" href="../addons/ewei_shopping/images/style.css?<?php echo TIMESTAMP;?>">
<style>
	.shopcart-footer{margin-bottom:30px;}
</style>

<div class="head">
	<a href="javascript:history.back();" class="bn pull-left"><i class="fa fa-angle-left"></i></a>
	<span class="title">购物车</span>
	<a href="javascript:void(0)" onclick="clearCart()" class="bn pull-right" style="font-size:18px;"><i class="fa fa-trash"></i> 清空</a>
</div>

<div class="shopcart-main img-rounded">
	<div style='text-align:center;padding:50px 0 50px 0; <?php  if(count($list)>0) { ?>display:none<?php  } ?>' id='cartempty'>
		<img src='../addons/ewei_shopping/images/icon_cart_empty.png' /><br/><br/>
		<span style='color:#adadad'>您的购物车空空如也，赶紧去选购吧~~</span>
	</div>
	<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<?php  $price += $item['totalprice'];?>
	<?php  $goods = $item['goods']?>
	<span id="stock_<?php  echo $item['id'];?>" style='display:none'><?php  echo $goods['total'];?></span>
	<div class="shopcart-item clearfix" id='item_<?php  echo $item['id'];?>' style='height:<?php  if(!empty($goods['optionname'])) { ?>140px;<?php  } else { ?>120px<?php  } ?>'>
		<label class="pull-left"><input type="checkbox" name="goodsid" value="<?php  echo $item['id'];?>"></label>
		<img src="<?php  echo tomedia($goods['thumb']);?>">
		<div class="shopcart-item-detail">
			<div class="name"><?php  echo $goods['title'];?><?php  if($goods['unit']) { ?><?php  } ?></div>
			<?php  if(!empty($goods['optionname'])) { ?>
				<div class="price">规格：<span><?php  echo $goods['optionname'];?></span></div>
			<?php  } ?>
			<div class="price">单价：<span id="singleprice_<?php  echo $item['id'];?>"><?php  echo $goods['marketprice'];?></span> 元<?php  if(!empty($goods['unit'])) { ?> / <?php  echo $goods['unit'];?><?php  } ?></div>
			<div class="price">小计：<span class='singletotalprice' id="goodsprice_<?php  echo $item['id'];?>"><?php  echo $item['totalprice'];?></span> 元</div>
			<div class="clearfix">
				<div class="input-group pull-left">
					<span class="input-group-btn">
						<button class="btn btn-default btn-sm" type="button" onclick="reduceNum(<?php  echo $item['id'];?>)"><i class="fa fa-minus"></i></button>
					</span>
					<input type="tel" class="form-control input-sm pricetotal goodsnum" value="<?php  echo $item['total'];?>" price="<?php  echo $goods['marketprice'];?>" pricetotal="<?php  echo $item['totalprice'];?>" id="goodsnum_<?php  echo $item['id'];?>" cartid='<?php  echo $item['id'];?>' maxbuy="<?php  echo $goods['maxbuy'];?>" />
					<span class="input-group-btn">
						<button class="btn btn-default btn-sm" type="button" onclick="addNum(<?php  echo $item['id'];?>,<?php  if($goods['maxbuy'] == 0) { ?><?php  echo $goods['total'];?><?php  } else { ?><?php  echo min($goods['total'], $goods['maxbuy'])?><?php  } ?>)"><i class="fa fa-plus"></i></button>
					</span>
				</div>
				<div class="text-right pull-right" style="height:35px; line-height:50px;">
					<a href="javascript:;" onclick="removeCart(<?php  echo $item['id'];?>)" class="shopcart-item-remove"><i class="fa fa-remove"></i> 删除</a>
				</div>
			</div>
		</div>
	</div>
	<?php  $n++;?>
	<?php  } } ?>
</div>
<div style='height:80px;width:100%;'>&nbsp;</div>
<div id='cartfooter' class="shopcart-footer" <?php  if(count($list)<=0) { ?>style='display:none'<?php  } ?>' style="z-index:3;">
	<span class="pull-left">合计：<span id="pricetotal"><?php  echo $price;?></span> 元</span>
	<a href="javascript:" class="btn btn-success pull-right" id="confirm">立即结算</a>
</div>

<script type="text/javascript">
	$('#confirm').click(function() {
		var ids =  new Array();
		var i = 0;
		$('[name="goodsid"]:checked').each(function () {
			ids[i] = $(this).val();
			i++;
		});
		location.href = "<?php  echo murl('entry//confirm',array('m'=>'ewei_shopping'))?>&goodids="+ids;
	});
	$(function(){
		$(".goodsnum").blur(function(){
			var id = $(this).attr("cartid");
			if($(this).isInt()){
				var num = parseInt( $("#goodsnum_" + id).val() );
				var maxbuy = parseInt( $(this).attr("maxbuy") );
				var mb = maxbuy;
				var stock =$("#stock_" + id).html()==''?-1:parseInt($("#stock_" + id).html());
				if(mb>stock && stock!=-1){
					mb = stock;
				}
		
				if(num>mb && mb>0){
					tip("最多只能购买 " + mb + " 件!",true);
					$("#goodsnum_" + id).val(mb);
					return;
				}
				updateCart(id,num);
			}else{
				$(this).val("1");
				updateCart(id,1);
			}
		})
	})
	function clearCart(){
		if (confirm('确定要清空购物车吗？')) {
			tip("正在处理数据...");
			$.getJSON('<?php  echo $this->createMobileUrl('mycart',array('op'=>'clear'));?>', function(s){
				$(".shopcart-item").remove();
				$("#cartempty").show();
				$("#cartfooter").hide();
				tip_close();
			});
		}
	}
	function removeCart(id){
		if (confirm('您确定要删除此商品吗？')) {
			tip("正在处理数据...");
			var url = "<?php  echo murl('entry//mycart',array('m'=>'ewei_shopping','op'=>'remove'), true)?>"+ "&id=" + id;
			$.getJSON(url, function(s){
				$("#item_" + s.cartid).remove();
				if($(".shopcart-item").length<=0){
					$("#cartempty").show();
					$("#cartfooter").hide();
				}
				tip_close();
				canculate();
			});
		}
	}
	function updateCart(id,num){
		var url = "<?php  echo murl('entry//mycart',array('m'=>'ewei_shopping','op'=>'update'), true)?>"+ "&id=" + id+"&num=" + num;
		$.getJSON(url, function(s){

		});
	}
	function checkMaxBuy(id, maxbuy){

	}
	function addNum(id,maxbuy){
		var mb = maxbuy;
		 var stock =$("#stock_" + id).html()==''?-1:parseInt($("#stock_" + id).html());
				if(mb>stock && stock!=-1){
					mb = stock;
				}
		var num = parseInt( $("#goodsnum_" + id).val() ) + 1;
		if(num>mb && mb>0){
			tip("最多只能购买 " + mb + " 件!",true);
			return;
		}
		$("#goodsnum_" + id).val(num);
		var price = parseFloat( $("#singleprice_"+id).html() ) * num;
		$("#goodsprice_" + id).html(price);
		canculate();
		updateCart(id,num);
	}
	function reduceNum(id){
		var num = parseInt( $("#goodsnum_" + id).val() );
		if(num-1<=0){
			return;
		}
		num--;
		$("#goodsnum_" + id).val(num);
		var price = parseFloat( $("#singleprice_"+id).html() ) * num;
		$("#goodsprice_" + id).html(price);
		canculate();
		updateCart(id,num);
	}
	function canculate(){
		var total = 0;
		$(".singletotalprice").each(function(){
			total+=parseFloat( $(this).html() );
		});

		$("#pricetotal").html(total);
	}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footerbar', TEMPLATE_INCLUDEPATH)) : (include template('footerbar', TEMPLATE_INCLUDEPATH));?>