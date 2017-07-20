<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
.card{position:relative; width:400px; max-height:218px; overflow:hidden;}
.cardsn{position:absolute; color:#666; right:20px; bottom:10px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5); font-size:16px;}
.cardtitle{position:absolute; right:20px; top:10px; color:#ffffff; font-size:16px; text-shadow:0 -1px 0 rgba(255, 255, 255, 0.5);}
.cardlogo{position:absolute; top:10px; left:20px;}
</style>
<ul class="nav nav-tabs">
	<li <?php  if($do == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/wxcard/display')?>">会员卡设置</a></li>
	<li <?php  if($do == 'manage') { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/wxcard/manage')?>">会员卡管理</a></li>
	<li <?php  if($do == 'update') { ?>class="active"<?php  } ?>><a href="<?php  echo url('mc/wxcard/update')?>">更新会员信息</a></li>
</ul>

<!-- 会员卡设置-->
<?php  if($do == 'display') { ?>
<div class="clearfix">
<form action="" class="form-horizontal form" method="post" enctype="multipart/form-data" id="form1">
		
		<div class="panel panel-default" id="cardmain">
			<div class="panel-heading">
				会员卡创建
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">商户名称<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="brand_name" value="西安贝米商贸" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡券名称<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="cardname" value="" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">激活方式<span style="color:red">*</span></label>
					<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
						<select name="create_method" class="form-control">
							<option value="1" name="create_method" >自动激活</option>
							<option value="2" name="create_method" >一键激活</option>
							<option value="3" name="create_method" selected="selected">跳转型一键激活</option>
							<option value="4" name="create_method" >接口激活</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">背景图片url<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="background_pic_url" value="" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">logo图片url<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="logo_url" value="" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">等级介绍链接url<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="custom_field1_url" value="" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠券查看链接url<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="custom_field2_url" value="" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义入口<span style="color:red">*</span></label>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义跳转入口名称<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="custom_url_name" value="会员中心" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义入口地址链接<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="custom_url" value="" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义2<span style="color:red">*</span></label>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义2名称<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="custom_cell1_name" value="热门活动" class="form-control">
				    </div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义2入口地址链接<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="custom_cell1_url" value="" class="form-control">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">营销场景<span style="color:red">*</span></label>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">营销场景自定义名称<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="promotion_url_name" value="会员权益" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">营销场景地址链接<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="promotion_url" value="" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员卡详情<span style="color:red">*</span></label>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员卡数量<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="quantity" value="1000" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">每人限领<span style="color:red">*</span></label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="get_limit" value="15" class="form-control">
					</div>
				</div>
		
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<!--<?php  echo tpl_form_field_image('bgpic', $bgpic);?><br/>-->
						<button type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交">提交</button>
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>
				</div>
			</div>
		</div>
</form>
<?php  } ?>		
		
<!-- 会员卡列表 -->
<?php  if(($do == 'manage')) { ?>
<div class="panel panel-default">
<div class="panel-body table-responsive">
	<table class="table table-hover">
		<thead class="navbar-inner">
			<tr>
				<th>会员卡名称</th>
				<th>激活方式</th>
				<th>会员卡ID</th>
				<th>创建时间</th>
				<th>启用状态</th>
				<th>设置启用</th>
				<th>支付即会员状态</th>
				<th>设置支付即会员</th>
				<th>二维码</th>
				<th>操作</th>
			</tr>
		</thead>
		<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr>
				<td><?php  echo $row['cardname'];?></td>
				<td><?php  if($row['create_method'] == 1) { ?>
					<span>自动激活</span>
					<?php  } else if($row['create_method'] == 2) { ?>
					<span>一键激活</span>
					<?php  } else if($row['create_method'] == 3) { ?>
					<span>跳转型一键激活</span>
					<?php  } else if($row['create_method'] == 4) { ?>
					<span>接口激活</span>
					<?php  } ?>
				</td>
				<td><?php  echo $row['card_id'];?></td>
				<td><?php  echo date('Y-m-d H:i:s', $row['create_time']);?></td>
				<td>
					<?php  if($row['cur_card_id'] == 1) { ?>
					<span class="label label-success">启用</span>
					<?php  } else { ?>
					<span class="label label-warning">未启用</span>
					<?php  } ?>
				</td>
				<td>
					<?php  if($row['cur_card_id'] == 0) { ?>
					<a href="<?php  echo url('mc/wxcard/current', array('card_id' => $row['card_id']))?>"><span>[设置]</span> </a>
					<?php  } else { ?>
					<a href="<?php  echo url('mc/wxcard/delcur', array('card_id' => $row['card_id']))?>"><span>[取消]</span> </a>
					<?php  } ?>
				</td>
				<td>
					<?php  if($row['gc_status'] == 1) { ?>
					<span class="label label-success">启用</span>
					<?php  } else { ?>
					<span class="label label-warning">未启用</span>
					<?php  } ?>
				</td>
				<td>
					<?php  if($row['gc_status'] == 0) { ?>
					<a href="<?php  echo url('mc/wxcard/paygift', array('card_id' => $row['card_id']))?>"><span>[设置]</span> </a>
					<?php  } else { ?>
					<a href="<?php  echo url('mc/wxcard/delgc', array('rule_id' => $row['rule_id']))?>"><span>[取消]</span> </a>
					<?php  } ?>
				</td>
				<td>
					<a href="<?php  echo url('mc/wxcard/QR', array('card_id' => $row['card_id']))?>"><span>[点击查看]</span> </a>
				</td>
				<td>
					<a href="<?php  echo url('mc/wxcard/delete', array('card_id' => $row['card_id']))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" data-toggle="tooltip" data-placement="top" title="" class="btn btn-default btn-sm" data-original-title="删除"><i class="fa fa-times"></i></a>
					<a href="<?php  echo url('mc/wxcard/update', array('card_id' => $row['card_id']))?>"  class="btn btn-default btn-sm" data-original-title="更新会员卡信息"><i class="fa fa-eye"></i></a>
				</td>
			</tr>
		<?php  } } ?>
	</table>
</div>
</div>
<?php  echo $pager;?>
<?php  } ?>

	<!-- 更新会员卡信息-->
	<?php  if($do == 'update') { ?>
	<div class="clearfix">
		<form action="<?php  echo url('mc/wxcard/wxupdate')?>" class="form-horizontal form" method="post" enctype="multipart/form-data" >

			<div class="panel panel-default">
				<div class="panel-heading">
					更新会员卡信息
				</div>

				<div class="panel-body">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">card_id:<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12"><?php  echo $card_id;?></div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">背景图片url<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="background_pic_url" value="" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">logo图片url<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="logo_url" value="" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">等级介绍链接url<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="custom_field1_url" value="" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠券查看链接url<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="custom_field2_url" value="" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义入口<span style="color:red">*</span></label>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义跳转入口名称<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="custom_url_name" value="会员中心" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义入口地址链接<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="custom_url" value="" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义2<span style="color:red">*</span></label>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义2名称<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="custom_cell1_name" value="热门活动" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义2入口地址链接<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="custom_cell1_url" value="" class="form-control">
						</div>
					</div>
					<!--<div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义2右侧提示语<span style="color:red">*</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="custom_cell1_tips" value="积分抵停车费" class="form-control">
                        </div>
                        <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义入口右侧提示语<span style="color:red">*</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="custom_url_sub_title" value="点击进入" class="form-control">
                        </div>
                    </div>
                    </div>-->

					<!--<div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义3<span style="color:red">*</span></label>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义3名称<span style="color:red">*</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="custom_cell2_name" value="会员服务" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义3右侧提示语<span style="color:red">*</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="custom_cell2_tips" value="SAGA" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义3地址链接<span style="color:red">*</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="custom_cell2_url" value="http://wx.cnsaga.com/app/index.php?i=4&c=entry&do=MemberCenter&m=member" class="form-control">
                        </div>
                        <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">营销场景右侧提示语<span style="color:red">*</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="promotion_url_sub_title" value="SAGA233" class="form-control">
                        </div>
                    </div>
                    </div>-->
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">营销场景<span style="color:red">*</span></label>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">营销场景自定义名称<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="promotion_url_name" value="会员权益" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">营销场景地址链接<span style="color:red">*</span></label>
						<div class="col-sm-9 col-xs-12">
							<input type="text" name="promotion_url" value="http://wx.cnsaga.com/app/index.php?i=4&c=entry&do=Rights&m=member&card_id=pUdGzjv3474pKPwtGBfqaqtXHhJ8&encrypt_code=U2yxfZQuY24IfuwvFJXMl3PlLMPSOmo8FvK7pq2OC5E%3D&openid=oUdGzjvnUQc2oUXxsYOfE5eV7ij8" class="form-control">
						</div>
					</div>


					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
						<div class="col-sm-9 col-xs-12">
							<!--<?php  echo tpl_form_field_image('bgpic', $bgpic);?><br/>-->
							<button type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交">提交</button>
							<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
							<input type="hidden" name="card_id" value="<?php  echo $card_id;?>" />
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php  } ?>
		<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>