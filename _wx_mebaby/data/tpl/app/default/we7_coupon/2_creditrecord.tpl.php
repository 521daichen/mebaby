<?php defined('IN_IA') or exit('Access Denied');?><?php  define('MUI', true);?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<?php  if($_GPC['type'] == 'record') { ?>
	<header class="mui-bar mui-bar-nav">
		<?php  if($_W['container'] !== 'wechat') { ?>
		<div class="mui-row fixed-bar">
			<div class="mui-col-xs-4">
				<button class="mui-btn mui-btn-link mui-btn-nav mui-pull-left mui-action-back">
					<span class="mui-icon mui-icon-left-nav"></span>
					返回
				</button>
			</div>
			<div class="mui-col-xs-4 mui-text-center"><?php  if(!empty($title)) { ?><?php  echo $title;?><?php  } else if(!empty($_W['page']['title'])) { ?><?php  echo $_W['page']['title'];?><?php  } ?></div>
			<div class="mui-col-xs-4 mui-text-right">
				<a href="#consume-date">
					<span><?php  if($_GPC['period'] <= 0) { ?><?php  echo date('Y.m', strtotime($_GPC['period'] . 'month'))?><?php  } else { ?>查看全部<?php  } ?></span>
					<span class="fa fa-angle-down mui-text-muted"></span>
				</a>
			</div>
		</div>
		<?php  } else { ?>
		<div class="mui-row fixed-bar">
			<div class="mui-col-xs-6"></div>
			<div class="mui-col-xs-6 mui-text-right">
				<a href="#consume-date">
					<span><?php  if($_GPC['period'] <= 0) { ?><?php  echo date('Y.m', strtotime($_GPC['period'] . 'month'))?><?php  } else { ?>查看全部<?php  } ?></span>
					<span class="fa fa-angle-down mui-text-muted"></span>
				</a>
			</div>
		</div>
		<?php  } ?>
	</header>
	<div id="consume-date" class="mui-popover mui-popover-top">
		<ul class="mui-table-view">
			<li class="mui-table-view-cell">
				<a href="<?php  echo $this->createMobileurl('creditrecord', array('credittype' => $_GPC['credittype'], 'type' => 'record', 'period' => '1'))?>">查看全部</a>
			</li>
			<li class="mui-table-view-cell">
				<a href="<?php  echo $this->createMobileurl('creditrecord', array('credittype' => $_GPC['credittype'], 'type' => 'record', 'period' => '0'))?>"><?php  echo date('Y.m', strtotime('today'))?></a>
			</li>
			<li class="mui-table-view-cell">
				<a href="<?php  echo $this->createMobileurl('creditrecord', array('credittype' => $_GPC['credittype'], 'type' => 'record', 'period' => '-1'))?>"><?php  echo date('Y.m', strtotime('-1month'))?></a>
			</li>
			<li class="mui-table-view-cell">
				<a href="<?php  echo $this->createMobileurl('creditrecord', array('credittype' => $_GPC['credittype'], 'type' => 'record', 'period' => '-2'))?>"><?php  echo date('Y.m', strtotime('-2month'))?></a>
			</li>
		</ul>
	</div>
	<div class="mui-content">
		<div class="mui-table mui-table-inline mui-pa10">
			<div class="mui-table-cell">
				<a href="<?php  echo $this->createMobileurl('creditrecord', array('credittype' => 'credit2', 'type' => 'record', 'period' => '1'))?>" class="mui-active">余额记录</a>
				<!-- <div class="mui-text-muted ">充值</div><?php  echo $income;?><?php  if($_GPC['credittype'] == 'credit2') { ?>元<?php  } else { ?>积分<?php  } ?> -->
			</div>
			<div class="mui-table-cell">
				<a href="<?php  echo $this->createMobileurl('creditrecord', array('credittype' => 'cash', 'type' => 'record', 'period' => '1'))?>">现金记录</a>
				<!-- <div class="mui-text-muted">消费</div><?php  echo $pay;?><?php  if($_GPC['credittype'] == 'credit2') { ?>元<?php  } else { ?>积分<?php  } ?> -->
			</div>
		</div>
		<div class="credits-display">
		<ul class="mui-table-view mui-credits">
			<?php  if(is_array($data)) { foreach($data as $row) { ?>
			<li class="mui-table-view-cell">
				<a href="<?php  echo $this->createMobileurl('creditrecord', array('credittype' => $_GPC['credittype'], 'type' => 'recorddetail', 'id' => $row['id']))?>">
					<div class="mui-row">
						<div class="mui-col-xs-6 mui-ellipsis-2">
							<?php  echo $row['remark'];?>
						</div>
						<div class="mui-col-xs-6 mui-text-right">
							<span class="mui-big <?php  if($_GPC['credittype'] != 'credit1') { ?>mui-rmb<?php  } ?>" style="color:<?php  echo $row['color']?>">
								<span class="money" style="color:<?php  echo $row['color']?>"><?php  echo $row['num'];?></span>
							</span>
							<span class="mui-block mui-text-muted mui-small"><?php  echo $row['createtime'];?></span>
						</div>
					</div>
				</a>
			</li>
			<?php  } } ?>
		</ul>
		</div>
	</div>
	<?php  } ?>
	<?php  if($_GPC['type'] == 'recorddetail') { ?>
	<div class="mui-bg-white mc-record-detail">
		<div class="mui-bb1 mui-row sum">
			<div class="mui-col-xs-6 mui-text-muted">
				付款金额
			</div>
			<div class="mui-col-xs-6 mui-text-right">
				<span class="mui-big <?php  if($_GPC['credittype'] != 'credit1') { ?>mui-rmb<?php  } ?>" style="color:<?php  echo $row['color']?>">
					<span class="money" style="color:<?php  echo $row['color']?>"><?php  echo $data['num'];?></span>
				</span>
			</div>
		</div>
		<div class="detail-info">
			<div class="mui-row">
				<div class="mui-col-xs-6 mui-text-muted">
					操作人
				</div>
				<div class="mui-col-xs-6 mui-text-right mui-ellipsis">
					<?php  if($data['username']) { ?><?php  echo $data['username'];?><?php  } else { ?>本人<?php  } ?>
				</div>
			</div>
			<div class="mui-row">
				<div class="mui-col-xs-6 mui-text-muted">
					数量
				</div>
				<div class="mui-col-xs-6 mui-text-right mui-ellipsis">
					<?php  echo $data['num'];?>
				</div>
			</div>
			<div class="mui-row">
				<div class="mui-col-xs-6 mui-text-muted">
					当前状态
				</div>
				<div class="mui-col-xs-6 mui-text-right mui-ellipsis">
					交易成功
				</div>
			</div>
			<div class="mui-row">
				<div class="mui-col-xs-6 mui-text-muted">
					时间
				</div>
				<div class="mui-col-xs-6 mui-text-right mui-ellipsis">
					<?php  echo date('Y-m-d H:i:s', $data['createtime'])?>
				</div>
			</div>
			<div class="mui-row">
				<div class="mui-col-xs-6 mui-text-muted">
					备注
				</div>
				<div class="mui-col-xs-6 mui-text-right">
					<?php  echo $data['remark'];?>
				</div>
			</div>
		</div>
	</div>
	<?php  } ?>
<script>
require(['mui.pullrefresh'], function(mui) {
	mui.init();
	mui.ready(function() {
		var page = 2;
		var pagetotal = <?php  echo $pagenums;?> + 1;
		if (page < pagetotal) {
			//循环初始化所有下拉刷新，上拉加载。
			mui.each(document.querySelectorAll('.credits-display'), function(index, pullRefreshEl) {
				mui(pullRefreshEl).pullToRefresh({
					up: {
						callback: function() {
							var self = this;
							setTimeout(function() {
								$('.mui-pull-bottom-tips').hide();
								var ul = self.element.querySelector('.mui-credits');
								ul.appendChild(createFragment(ul, index, 5));
								if (pagetotal <= page) {
									$('.mui-pull-bottom-tips').hide();
									self.endPullUpToRefresh(true);
								} else {
									self.endPullUpToRefresh(false);
								}
							}, 1000);
						}
					}
				});
			});

			var createFragment = function(ul, index, count, reverse) {
				var length = ul.querySelectorAll('li').length;
				var fragment = document.createDocumentFragment();
				var li;
				var url = "<?php  echo $this->createMobileurl('creditrecord', array('credittype' => $_GPC['credittype'], 'type' => $_GPC['type'], 'period' => $_GPC['period']))?>";
				mui.post(url, {'page' : page}, function(data){
					data = $.parseJSON(data);
					if (data.state == 'error') {
						return false;
					}
					for (var i in data) {
						var href = "<?php  echo $this->createMobileurl('creditrecord', array('credittype' => $_GPC['credittype'], 'type' => 'recorddetail'))?>";
						li = document.createElement('li');
						li.className = 'mui-table-view-cell';
						li.innerHTML = '<a href="' + href + '&id=' + data[i].id + '" ><div class="mui-row"><div class="mui-col-xs-6 mui-ellipsis-2">' + data[i].remark + '</div><div class="mui-col-xs-6 mui-text-right"><span class="mui-big mui-rmb" style="color:' + data[i].color + '"><span class="money" style="color:' + data[i].color + '">' + data[i].num + '</span></span><span class="mui-block mui-text-muted mui-small">' + data[i].createtime + '</span></div></div></a>';
						ul.appendChild(li, ul.firstChild);
					}
					$('.mui-pull-bottom-tips').show();
				});
				page++;
				return fragment;
			};
		}
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>