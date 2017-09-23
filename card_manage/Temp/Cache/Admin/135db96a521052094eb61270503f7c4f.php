<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理登录-<?php echo (C("cms_name")); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='__PUBLIC__/Admin/css/admin_login.css'>
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
<script>
function loginok(form){
  if (form.login_name.value==""){
    alert("用户名不能为空！");
    form.login_name.focus();
    return (false);
  }
  if (form.login_pwd.value==""){
    alert("密码不能为空！");
    form.login_pwd.focus();
    return (false);
  }
  if (form.verify.value==""){
    alert("验证码不能为空！");
    form.verify.focus();
    return (false);
  }
  return (true);
}

if(self!=top){
  top.location=self.location;
}
</script>
</head>
<body>
<div class="main">
  <div class="title" style="height: 400px;"></div>
  <div class="login">
    <form action="<?php echo U('Admin/Login/checkLogin');?>" method="post" name="cms" onSubmit="return loginok(this)">
      <div class="inputbox">
        <dl>
          <dd><?php echo (L("lan_username")); ?>：</dd>
          <dd>
            <input type="text" name="username" id="login_name" size="15" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" />
          </dd>
          <dd><?php echo (L("lan_password")); ?>：</dd>
          <dd>
            <input type="password" name="password" id="login_pwd" size="15" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" />
          </dd>
          <dd><?php echo (L("lan_verify")); ?>：</dd>
          <dd>
            <input type="text" name="verify" id="verify" size="4" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" />
            <img id="verifyImg" SRC="<?php echo U('Admin/Public/verify');?>" onclick='this.src=this.src+"&"+Math.random()' BORDER="0" ALT="点击刷新验证码" style="cursor:pointer" align="absmiddle">
          </dd>
          <dd>
            <input name="submit" type="submit" value="" class="input" />
          </dd>
        </dl>
      </div>
      <div class="butbox">
        <dl>
          <dd></dd>
        </dl>
      </div>
      <div style="clear:both"></div>
    </form>
  </div>
</div>
<div class="copyright"> 
  Powered by <a href="<?php echo (C("cms_url")); ?>" target="_blank"><?php echo (C("web_name")); ?>&nbsp;<?php echo (C("cms_var")); ?></a>&nbsp;Copyright&nbsp;&copy;2011-2017 
</div>
</body>
</html>