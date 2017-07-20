<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link type="text/css" rel="stylesheet" href="../addons/ewei_shopping/images/style.css?<?php echo TIMESTAMP;?>">
<div class="head">
	<a href="javascript:history.back();" class="bn pull-left"><i class="fa fa-angle-left"></i></a>
	<span class="title">订单详情</span>
	<a href="<?php  echo $this->createMobileUrl('mycart')?>" class="bn pull-right"><i class="fa fa-shopping-cart"></i></a>
</div>

<div class="myoder img-rounded">
	<div class="myoder-hd">
		<span class="pull-left">订单编号：<?php  echo $item['ordersn'];?></span>
		<span class="pull-right"><?php  echo date('Y-m-d H:i', $item['createtime'])?></span>
	</div>
	<?php  if(is_array($goods)) { foreach($goods as $g) { ?>
	<div class="myoder-detail">
		<a href="<?php  echo $this->createMobileUrl('detail', array('id' => $g['id']))?>">
			<img src="<?php  echo tomedia($g['thumb']);?>" width="160" />
		</a>
		<div class="pull-left">
			<div class="name"><a href="<?php  echo $this->createMobileUrl('detail', array('id' => $g['id']))?>"><?php  echo $g['title'];?></a></div>
			<div class="price">
				<span><?php  echo $g['marketprice'];?> 元<?php  if($g['unit']) { ?> / <?php  echo $g['unit'];?><?php  } ?></span>
				<span class="num"><?php  echo $g['total'];?>  <?php  if($g['unit']) { ?> <?php  echo $g['unit'];?><?php  } ?></span>
			</div>
		</div>
	</div>
	<?php  } } ?>
	<div class="myoder-express">
		<span class="express-company">状态</span>
		<span class="express-num">
		<?php  if($item['paytype'] == 3) { ?>
			<?php  if($item['status'] == -1) { ?>
			<span class="text-muted">订单取消</span>
			<?php  } else if($item['status'] < 3) { ?>
			<span class="text-danger">货到付款 / 未付款</span>
			<?php  } else { ?>
			<span class="text-success">已完成</span>
			<?php  } ?>
		<?php  } else { ?>
			<?php  if($item['status'] == -1) { ?>
			<span class="text-muted">订单取消</span>
			<?php  } else if($item['status'] == 0) { ?>
			<span class="text-danger">未付款</span>
			<?php  } else if($item['status'] == 1) { ?>
			<span class="text-warning">已付款</span>
			<?php  } else if($item['status'] == 2) { ?>
			<span class="text-warning">已发货</span>
			<?php  } else { ?>
			<span class="text-success">已完成</span>
			<?php  } ?>
		<?php  } ?>
		</span>
	</div>

	<div class="myoder-express">
		<span class="express-company">金额</span>
		<span class="express-num">
			<span class="false">
			<?php  if($item['dispatchprice']<=0) { ?>
				<?php  echo $item['price'];?> 元
			<?php  } else { ?>
				<?php  echo $item['price'];?> 元 (含运费 <?php  echo $item['dispatchprice'];?> 元)
			<?php  } ?>
			</span>
		</span>
	</div>
    <?php  if(($dispatch['enabled']==1)) { ?>
	<div class="myoder-express">
		<span class="express-company">配送方式</span>
		<span class="express-num"><?php  echo $dispatch['dispatchname'];?></span>
	</div>
	<?php  } ?>
	<?php  if(($item['status'] == '2' || $item['status']==3) && !empty($item['expresssn'])) { ?>
	<div class="myoder-express">
		<span class="express-company">快递: <?php  echo $item['expresscom'];?></span>
		<span class="express-num">
			单号: <?php  echo $item['expresssn'];?>
		</span>
	</div>
	<?php  } ?>
	<?php  if(!empty($item['remark'])) { ?>
	<div class="myoder-express" style='margin-top:10px;'>
		<span class="express-company">订单备注&nbsp;&nbsp;:&nbsp;&nbsp;<?php  echo $item['remark'];?></span>
	</div>
	<?php  } ?>
	<div class="myoder-total">
		<?php  if(!empty($item['paydetail'])) { ?>
		<span>
			<span class="false"><strong>支付详情：</strong></span>
			<?php  echo $item['paydetail'];?>
		</span>
		<?php  } ?>
		<div class="form-group">
		<?php  if($item['status'] == '2' && !empty($item['expresssn'])) { ?>
			<a href="http://m.kuaidi100.com/index_all.html?type=<?php  echo $item['express'];?>&postid=<?php  echo $item['expresssn'];?>#input" class="btn btn-success pull-right btn-sm" >查看快递</a>
		<?php  } ?>
		<?php  if($item['paytype'] != 3 && $item['status'] == 0) { ?>
			<a href="<?php  echo $this->createMobileUrl('pay', array('orderid' => $item['id']))?>" class="btn btn-danger pull-right btn-sm">立即支付</a>
		<?php  } else { ?>
			<?php  if($item['status'] == 3) { ?>
			<button class="btn btn-success pull-right btn-sm">已完成</button>
			<?php  } else if($item['status'] == 2) { ?>
			<a href="<?php  echo $this->createMobileUrl('myorder', array('orderid' => $item['id'], 'op' => 'confirm'))?>" class="btn btn-warning pull-right btn-sm" style="margin-right: 10px;" onclick="return confirm('点击确认收货前，请确认您的商品已经收到。确定收货吗？'); ">确认收货</a>
			<?php  } else { ?>
			<button class="btn btn-danger pull-right btn-sm">等待发货</button>
			<?php  } ?>
		<?php  } ?>
		</div>
	</div>
</div>

<script>
	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
		WeixinJSBridge.call('hideOptionMenu');
	});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footerbar', TEMPLATE_INCLUDEPATH)) : (include template('footerbar', TEMPLATE_INCLUDEPATH));?>