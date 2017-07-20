<?php defined('IN_IA') or exit('Access Denied');?><div class="list-item img-rounded">
	<div>
		<a href="<?php  echo $this->createMobileUrl('detail', array('id' => $item['id']))?>">
			<img src="<?php  echo tomedia($item['thumb']);?>">
		</a>
		<span class="title">
			<a href="<?php  echo $this->createMobileUrl('detail', array('id' => $item['id']))?>">
				<?php  echo $item['title'];?>
			</a>
			<?php  if($item['type'] == '2') { ?>(虚拟)<?php  } ?>
		</span>
	</div>
	<div class="sold">
		<span  class="price">
			<span>￥<?php  echo $item['marketprice'];?></span> &nbsp;
			<?php  if($item['originalprice'] != '0.00') { ?><del>￥<?php  echo $item['originalprice'];?></del><?php  } ?>
		</span>
		<span class="soldnum text-right">已售<?php  echo $item['sales'];?>件</span>
	</div>
</div>