<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>优惠券发放记录</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel='stylesheet' type='text/css' href='__PUBLIC__/Admin/css/admin_style.css' />
	<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/Admin/js/function.js"></script>
	<style>td{ height:22px; line-height:22px}</style>
</head>
<body>
	<table width="98%" border="0" cellpadding="9" cellspacing="1" class="table">
		<tr>
			<td colspan="9" class="table_title">
				<span class="fl">优惠券发放记录</span>
				<span class="fr">
					<a href="<?php echo U('/Admin/Card/add');?>">发放</a>
				</span>
			</td>
			<tr class="list_head ct">
				<td width="70">ID</td>
				<td width="150">会员电话</td>
				<td >水单号</td>
				<td width="100">实付金额</td>
				<td width="150">发放时间</td>
			</tr>
	    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class='<?php if(($mod) == "1"): ?>tr<?php else: ?>ji<?php endif; ?>'>
				<td align='center'><?php echo ($vo["id"]); ?></td>
				<td ><?php echo ($vo["customerTel"]); ?></td>
				<td ><?php echo ($vo["ordersn"]); ?></td>
				<td align='center'><?php echo ($vo["orderTotal"]); ?></td>
				<td align='center'><?php echo ($vo["create_time"]); ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr class="tr">
          <td colspan="9" class="pages">
            <?php echo ($page); ?>
          </td>
        </tr>
		</table>
		<script>var version='<?php echo (C("cms_var")); ?>';</script>
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