<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ($tpltitle); ?>优惠券发放</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='__PUBLIC__/Admin/css/admin_style.css' />
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/formValidator.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		

	});
</script>
</head>
<body>
		<?php if(($info["id"]) > "0"): ?><form action="<?php echo U('/Admin/Card/edit/');?>" method="post" name="form" id="myform">
			<input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
		<?php else: ?>
			<form action="<?php echo U('/Admin/Card/insert/');?>" method="post" name="form" id="myform"><?php endif; ?>
			<table width="98%" border="0" cellpadding="4" cellspacing="1" class="table">

				<tr class="table_title">
					<td colspan="4"><?php echo ($tpltitle); ?>优惠券发放</td>
				</tr>

				<tr class="tr rt">
					<td width="100">会员电话：</td>
					<td colspan="3" class="lt">
						<input type="text" name="customerTel" id="customerTel" style="width:200px" value="<?php echo ($info["customerTel"]); ?>" onblur="javascript:getUserInfo();">
					</td>
				</tr>
				<tr class="tr rt">
					<td width="100">销售水单：</td>
					<td colspan="3" class="lt">
						<input type="ordersn" name="ordersn" id="ordersn" style="width:200px" value="<?php echo ($info["ordersn"]); ?>">
					</td>
				</tr>
	<tr class="tr lt">
		<td colspan="4">
			<?php if(($info["id"]) > "0"): ?><input class="bginput" type="submit" name="dosubmit" value="修 改" >
				<?php else: ?>
				<input class="bginput" type="submit" name="dosubmit" value="发 券"><?php endif; ?>
			<input type="hidden" name="openid" id="openid" value="" />
			<input class="bginput" type="button" onclick="javascript:history.back(-1);" value="返 回" >
		</td>
	</tr>
</table>
</form>
﻿<style>
#footer, #footer a:link, #footer a:visited {
	clear:both;
	color:#0072e3;
	font:12px/1.5 Arial;
	margin-top:10px;
	text-align:center;
	white-space:nowrap;
}
</style>
<div id="footer"></div>
</body>
</html>