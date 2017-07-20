<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
  .menu-item-icon {
    font-size:1.4em;
    padding:14px;
  }
  .menu-item {
    min-width:120px;
  }
</style>

<?php  $installed = false; ?>
<?php  if(is_array($entries)) { foreach($entries as $m=>$entry) { ?>

<?php  if(empty($entry)) { ?>
  <?php  continue; ?>
<?php  } ?>

<?php  $installed = true; ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <?php  echo $titles[$m];?>
		<?php  if($installedmodulelist[$m]['settings']) { ?>
    <a title="<?php  echo $titles[$m];?> 参数设置" style="float:right" href="<?php  echo url('profile/module/setting', array('m' => $m));?>"><i class="fa fa-cog"></i></a>
    <?php  } ?>
  </div>
  <div class="panel-body">
    <?php  if(is_array($entry['menu'])) { foreach($entry['menu'] as $menu) { ?>
    <a class="menu-item btn btn-default" href="<?php  echo $menu['url'];?>">
      <i class="menu-item-icon <?php  echo $this->famap($menu['title'])?>"></i>
      <br/><?php  echo $menu['title'];?>
    </a>
    <?php  } } ?>
  </div>
</div>
<?php  } } ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <?php  echo $sys_entry['title'];?>
  </div>
  <div class="panel-body">
    <?php  if(is_array($sys_entry['menu'])) { foreach($sys_entry['menu'] as $menu) { ?>
    <a class="menu-item btn btn-default" href="<?php  echo $menu['url'];?>">
      <i class="menu-item-icon <?php  echo $this->famap($menu['title'])?>"></i>
      <br/><?php  echo $menu['title'];?>
    </a>
    <?php  } } ?>
  </div>
</div>

<?php  if($installed == false ) { ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <?php  echo $default_entry['title'];?>
  </div>
  <div class="panel-body">
    <?php  if(is_array($default_entry['menu'])) { foreach($default_entry['menu'] as $menu) { ?>
    <a class="menu-item btn btn-default" href="<?php  echo $menu['url'];?>">
      <i class="menu-item-icon <?php  echo $this->famap($menu['title'])?>"></i>
      <br/><?php  echo $menu['title'];?>
    </a>
    <?php  } } ?>
  </div>
</div>
<?php  } ?>


<div class="panel panel-default">
  <div class="panel-body">
    <a style="margin-right:20px; float:right" class="btn btn-default" id="bookmarkme" href="#" rel="sidebar" title="加入到收藏夹, 后继操作更便捷">
      加入到收藏夹
    </a>
  </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#bookmarkme').click(function() {
            if (window.sidebar && window.sidebar.addPanel) { // Mozilla Firefox Bookmark
                window.sidebar.addPanel(document.title,window.location.href,'');
            } else if(window.external && ('AddFavorite' in window.external)) { // IE Favorite
                window.external.AddFavorite(location.href,document.title); 
            } else if(window.opera && window.print) { // Opera Hotlist
                this.title=document.title;
                return true;
            } else if (navigator.userAgent.toLowerCase().indexOf('mac') != - 1) { // webkit - chrome
                alert('高大上的Mac系统，请按' + (navigator.userAgent.toLowerCase().indexOf('mac') != - 1 ? 'Command' : 'CTRL') + ' + D添加本页面到收藏夹');
            } else { // webkit - safari
                alert('请按' + (navigator.userAgent.toLowerCase().indexOf('mac') != - 1 ? 'Command' : 'CTRL') + ' + D添加本页面到收藏夹');
            }
            return false;
        });
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
