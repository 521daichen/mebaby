<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($_W['isfounder']) { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form">
      <div class="panel panel-default"><div class="panel-heading">同步授权</div><div class="panel-body">

      <div class="form-group">
        <span class='col-xs-12 col-sm-3 col-md-2 col-lg-2  control-label'>认证秘钥</span>
				<div class='col-xs-12 col-sm-9 col-md-10 col-lg-10'>
            <input class="form-control" type="text" id="apptoken" name="apptoken" value="<?php  echo $settings['apptoken'];?>">
            <span class="help-block"><b>开源版</b>认证秘钥<a target="_blank" href="http://open.xiaoheqingting.com/token">点击这里申请</a>，<b>商业版</b>认证秘钥请向软件服务商索取，您必须填写认证秘钥后方可进行模块下载和更新。</span>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-3 col-md-offset-2 col-lg-offset-2 col-xs-12 col-sm-10 col-md-10 col-lg-10">
          <input class="btn btn-primary " type="submit" id="submit" name="submit" value="保存">
          <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
      </div>
    </form>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
