<?php defined('IN_IA') or exit('Access Denied');?><style>
body{padding-bottom:50px;}
</style>
<?php  $this->pay($params);?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footerbar', TEMPLATE_INCLUDEPATH)) : (include template('footerbar', TEMPLATE_INCLUDEPATH));?>