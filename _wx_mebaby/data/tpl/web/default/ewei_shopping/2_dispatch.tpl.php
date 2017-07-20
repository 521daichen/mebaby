<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common', TEMPLATE_INCLUDEPATH)) : (include template('common', TEMPLATE_INCLUDEPATH));?>

<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('dispatch',array('op' =>'display'))?>">配送方式</a></li>
	<li<?php  if(empty($dispatch['id']) && $operation == 'post') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('dispatch',array('op' =>'post'))?>">添加配送方式</a></li>
	<?php  if(!empty($dispatch['id']) && $operation== 'post') { ?> <li class="active"><a href="<?php  echo $this->createWebUrl('dispatch',array('op' =>'post','id'=>$dispatch['id']))?>">编辑配送方式</a></li> <?php  } ?>
</ul>

<?php  if($operation == 'display') { ?>
<div class="main panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:50px;">ID</th>
					<th style="width:100px;">显示顺序</th>
					<th style="width:150px;">配送方式</th>
					<th style="width:150px;">配送类型</th>
					<th style="width:120px;">首重价格</th>
					<th style="width:120px;">续重价格</th>
					<th style="width:100px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  echo $item['displayorder'];?></td>
					<td><?php  echo $item['dispatchname'];?></td>
					<td><?php  if($item['dispatchtype']==0) { ?>
					先付款后发货
					<?php  } else if($item['dispatchtype']==1) { ?> 货到付款
					<?php  } else { ?>
					自提
					<?php  } ?></td>
					<td><?php  echo $item['firstprice'];?></td>
					<td><?php  echo $item['secondprice'];?></td>
					<td style="text-align:left;">
						<a href="<?php  echo $this->createWebUrl('dispatch', array('op' => 'post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="修改"><i class="fa fa-pencil"></i></a>
						<a href="<?php  echo $this->createWebUrl('dispatch', array('op' => 'delete', 'id' => $item['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>

<script>
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});
</script>

<?php  } else if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
		<input type="hidden" name="id" value="<?php  echo $dispatch['id'];?>" />
		<div class="panel panel-default">
			<div class="panel-heading">
				配送方式设置
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="displayorder" class="form-control" value="<?php  echo $dispatch['displayorder'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>配送名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id='dispatchname' name="dispatchname" class="form-control" value="<?php  echo $dispatch['dispatchname'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">配送类型</label>
					<div class="col-sm-9 col-xs-12">
							<label class='radio-inline'>
							<input type='radio' name='dispatchtype' value='0' <?php  if($dispatch['dispatchtype']==0) { ?>checked<?php  } ?> /> 先付款后发货
						</label>
						<label class='radio-inline'>
							<input type='radio' name='dispatchtype' value='1' <?php  if($dispatch['dispatchtype']==1) { ?>checked<?php  } ?> /> 货到付款
						</label>
						<label class='radio-inline'>
							<input type='radio' name='dispatchtype' value='2' <?php  if($dispatch['dispatchtype']==2) { ?>checked<?php  } ?> /> 自提
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">重量设置</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group input-medium">
							<span class="input-group-addon">首重重量</span>
							<select name="firstweight" id="firstweight" class='form-control input-medium'>
								<option value="500" <?php  if($dispatch['firstweight']==500) { ?>selected<?php  } ?>>0.5</option>
								<option value="1000" <?php  if($dispatch['firstweight']==1000 || empty($dispatch['firstweight'])) { ?>selected<?php  } ?>>1</option>
								<option value="1200" <?php  if($dispatch['firstweight']==1200) { ?>selected<?php  } ?>>1.2</option>
								<option value="2000" <?php  if($dispatch['firstweight']==2000) { ?>selected<?php  } ?>>2</option>
								<option value="5000" <?php  if($dispatch['firstweight']==5000) { ?>selected<?php  } ?>>5</option>
								<option value="10000" <?php  if($dispatch['firstweight']==10000) { ?>selected<?php  } ?>>10</option>
								<option value="20000" <?php  if($dispatch['firstweight']==20000) { ?>selected<?php  } ?>>20</option>
								<option value="50000" <?php  if($dispatch['firstweight']==50000) { ?>selected<?php  } ?>>50</option>
							</select>
							<span class="input-group-addon">KG</span>
						</div>
						<br>
						<div class="input-group  input-medium">
							<span class="input-group-addon">续重重量</span>
							<select name="secondweight" id="secondweight" class='form-control input-medium'>
								<option value="500" <?php  if($dispatch['secondweight']==500) { ?>selected<?php  } ?>>0.5</option>
								<option value="1000" <?php  if($dispatch['secondweight']==1000 || empty($dispatch['secondweight'])) { ?>selected<?php  } ?>>1</option>
								<option value="1200" <?php  if($dispatch['secondweight']==1200) { ?>selected<?php  } ?>>1.2</option>
								<option value="2000" <?php  if($dispatch['secondweight']==2000) { ?>selected<?php  } ?>>2</option>
								<option value="5000" <?php  if($dispatch['secondweight']==5000) { ?>selected<?php  } ?>>5</option>
								<option value="10000" <?php  if($dispatch['secondweight']==10000) { ?>selected<?php  } ?>>10</option>
								<option value="20000" <?php  if($dispatch['secondweight']==20000) { ?>selected<?php  } ?>>20</option>
								<option value="50000" <?php  if($dispatch['secondweight']==50000) { ?>selected<?php  } ?>>50</option>
							</select> <span class="input-group-addon">KG</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">价格设置</label>
					<div class="col-sm-9 col-xs-12">
						<div class="input-group  input-medium">
							<span class="input-group-addon">首重价格</span>
							<input type="text" name="firstprice" id='firstprice' class="form-control input-medium" value="<?php  echo $dispatch['firstprice'];?>" />
							<span class="input-group-addon">元</span>
						</div>
						<br>
						<div class="input-group  input-medium">
							<span class="input-group-addon">续重价格</span>
							<input type="text" name="secondprice" id='secondprice' class="form-control input-medium" value="<?php  echo $dispatch['secondprice'];?>" />
							<span class="input-group-addon">元</span>
						</div>
						<span class='help-block'>根据重量来计算运费，当物品不足《首重重量》时，按照《首重费用》计算，超过部分按照《续重重量》和《续重费用》乘积来计算</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
					<div class="col-sm-9 col-xs-12">
						<label class='radio-inline'>
						 	<input type='radio' name='enabled' value=1 <?php  if($dispatch['enabled']==1) { ?>checked<?php  } ?> /> 是
						</label>
						<label class='radio-inline'>
							<input type='radio' name='enabled' value=0  <?php  if($dispatch['enabled']==0) { ?>checked<?php  } ?> /> 否
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">物流公司</label>
					<div class="col-sm-9 col-xs-12">
						<select name='express' class='form-control'>
							<option value="" <?php  if(empty($dispatch['express'])) { ?>selected<?php  } ?>><?php  echo $express['express_name'];?></option>
							<?php  if(is_array($express)) { foreach($express as $ex) { ?>
							<option value="<?php  echo $ex['id'];?>" <?php  if($dispatch['express']==$ex['id']) { ?>selected<?php  } ?>><?php  echo $ex['express_name'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">介绍</label>
					<div class="col-sm-9 col-xs-12">
						<textarea name="description" class="form-control" cols="70"><?php  echo $dispatch['description'];?></textarea>
					</div>
				</div>
		</div>
	</div>
	<div class="form-group col-sm-12">
		<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick="return formcheck()" />
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	</div>
	</form>
</div>

<script language='javascript'>
	function formcheck() {
		if ($("#dispatchname").isEmpty()) {
			Tip.focus("dispatchname", "请填写配送方式名称!", "top");
			return false;
		}
		if($(':radio[name=dispatchtype]:checked').val()!='2'){
				if (!$("#firstprice").isNumber()) {
					Tip.select("firstprice", "请填写数字首重价格!", "top");
					return false;
				}
				if (!$("#secondprice").isNumber()) {
					Tip.select("secondprice", "请填写数字续重价格!", "top");
					return false;
				}
		}
		return true;
	}
	$(function() {
		$("#common_corp").change(function() {
			var obj = $(this);
			var sel = obj.find("option:selected");
			$("#dispatch_name").val(sel.attr("data-name"));
			$("#dispatch_url").val(sel.attr("data-url"));
		});
	})
</script>

<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>