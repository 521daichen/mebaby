<?php
/**
 * @author 晓楚
 * @url http://open.xiaoheqingting.com
 */
defined('IN_IA') or exit('Access Denied');

define('XC_LOCAL_MODULE_ROOT',        IA_ROOT . '/addons/');
define('XC_REMOTE_MODULE_LIST_URL',   'http://gateway.v1.xiaoheqingting.com/file/list');
define('XC_REMOTE_MODULE_FILE_URL',   'http://gateway.v1.xiaoheqingting.com/file/get');

class xc_panelModuleSite extends WeModuleSite {
  private function famap($key) {
    $fa = array(
      '商品管理'=>'fa fa-gift',
      '商品分类'=>'fa fa-cubes',
      '订单管理'=>'fa fa-cc-visa',
      '物流模板'=>'fa fa-truck',
      '业绩报表'=>'fa fa-file-text',
      '幻灯片管理'=>'fa fa-picture-o',

      '传单管理'=>'fa fa-qrcode',
      '黑名单'=>'fa fa-lock',
      '排行榜'=>'fa fa-trophy',

      '分销管理' => 'fa fa-joomla',

      '订单管理'=>'fa fa-shopping-cart',
      '返利记录'=>'fa fa-calculator',
      '消息通知'=>'fa fa-volume-up',
      '用户中心'=>'fa fa-user',
      '取现请求管理'=>'fa fa-pencil-square-o',
      '取现模板管理'=>'fa fa-file-text',
      '兑换请求管理'=>'fa fa-pencil-square-o',
      '兑换模板管理'=>'fa fa-file-text',
      '文章管理'=>'fa fa-pencil',
      '文章分类'=>'fa fa-list',
      '分享点击记录'=>'fa fa-weixin',
      '帮助'=>'fa fa-question',
      '会员积分管理'=>'fa fa-users',
      '粉丝管理'=>'fa fa-user-plus',
      '消息群发'=>'fa fa-paper-plane',
      '粉丝自动同步'=>'fa fa-jsfiddle',
    );
    if (isset($fa[$key])) {
      return $fa[$key];
    }
    return 'fa fa-puzzle-piece';
  }

  public function doWebPanel() {
    global $_W;
    $modules = array('quickshop', 'quicklink', 'quickdist', 'quickmoney', 'quickcredit', 'quickfans', 'xc_article');
    $u_modules = unserialize($this->module['config']['modules']);
    if (is_array($u_modules)) {
      $modules = array_unique(array_merge($modules, $u_modules));
    }

    load()->model('module');
	  $installedmodulelist = uni_modules(false);
    foreach ($modules as $m) {
		  $entries[$m] = module_entries($m, array('menu')); //, 'home', 'profile', 'shortcut', 'cover'));
    }
    foreach ($modules as $m) {
      $titles[$m] = $installedmodulelist[$m]['title'];
    }
    // sys entry
    $sys_entry['title'] = '常用工具';
    $sys_entry['menu'] = array(
      array('title'=>'会员积分管理', 'url'=>wurl('mc/creditmanage', array('type'=>3))),
      array('title'=>'粉丝管理', 'url'=>wurl('mc/fans' , array('acid'=>$_W['acid'], 'nickname'=>''))),
      array('title'=>'消息群发', 'url'=>wurl('material/mass')),
      array('title'=>'粉丝自动同步', 'url'=>wurl('mc/passport/sync')),
      array('title'=>'系统更新', 'url'=>wurl('site/entry/upgrade', array('m'=>'xc_panel'))),
    );
    //default entry when renrenzhuan not installed
    $default_entry['title'] = '获取帮助';
    $default_entry['menu'] = array(
      array('title'=>'帮助文档', 'url'=>'https://xiaohe.kf5.com/hc/'),
      array('title'=>'提交工单', 'url'=>'https://xiaohe.kf5.com/hc/request/new/'),
      array('title'=>'讨论社区', 'url'=>'https://xiaohe.kf5.com/hc/community/topic/'),
      array('title'=>'QQ 交流群', 'url'=>'https://xiaohe.kf5.com/hc/community/question/306671/'),
    );
    include $this->template('panel');
  }

	public function doWebUpgrade() {
		global $_W, $_GPC;
    $data = $this->getUpdatedFileList();
    $version = $data['version'];
    $news = $data['news'];
    $files = $data['files'];
    $error = $data['error'];
    $message = $data['message'];
    $isLatestVersion = (count($files) <= 0);

    include $this->template('upgrade');
	}

	public function doWebDoUpgrade() {
		global $_W, $_GPC;
    $data = $this->getUpdatedFileList(true);
    $files = $data['files'];

    if (empty($files)) {
		  load()->func('cache');
      cache_delete('xcmodule:upgrade');
      message('恭喜！你的系统已经是最新版本', $this->createWebUrl('Upgrade'), 'success');
    }
    include $this->template('do_upgrade');
	}

	public function doWebRefreshUpgrade() {
		  load()->func('cache');
      cache_delete('xcmodule:upgrade');
      header('Location:' . $this->createWebUrl('Upgrade'));
  }

	public function doWebFetchFile() {
		global $_W, $_GPC;
    $file = $_GPC['file'];
    list($error, $message) = $this->getFileAndSave($file);
    echo json_encode(array('error'=>$error, 'message'=>$message, 'file'=>$file));
	}

  //
  /// files utility
  //
  private function file_write($filename, $data) {
    global $_W;
    load()->func('file');
    @mkdirs(dirname($filename));
    @file_put_contents($filename, $data);
    @chmod($filename, $_W['config']['setting']['filemode']);
    return is_file($filename);
  }

  private function getFullFileList() {
		load()->func('communication');
    $token = $this->module['config']['apptoken'];
    $url = XC_REMOTE_MODULE_LIST_URL . '?token=' . $token;
    //die($url);
    $data = ihttp_get($url);
    return json_decode($data['content'], true);
  }

  private function getUpdatedFileList($forceUpdate = false) {
    global $_W;
		load()->func('file');
		load()->func('cache');
    cache_load('xcmodule:upgrade');

    if (!$forceUpdate && !empty($_W['cache']['xcmodule:upgrade'])) {
      //return $_W['cache']['xcmodule:upgrade'];
    }

    $data = $this->getFullFileList();
    $files = $data['files'];
    // Check for md5
    $updatedFiles = array();
    foreach ($files as $j) {
      $fullPath = XC_LOCAL_MODULE_ROOT . '/' . $j['file'];
      if (!file_exists($fullPath)) {
          $j['status'] = 'A';
          $updatedFiles[] = $j;
      } else {
        $md5 = md5_file($fullPath);
        if (false === $md5 || $md5 != $j['md5']) {
          $j['status'] = 'M';
          $updatedFiles[] = $j;
        }
      }
    }
    $data['files'] = $updatedFiles;
    cache_write('xcmodule:upgrade', $data);
    return $data;
  }


  private function getFileAndSave($file) {
      load()->func('communication');
      $token = $this->module['config']['apptoken'];
      $data = ihttp_get(XC_REMOTE_MODULE_FILE_URL . '?file=' . $file . '&token=' . $token);
      $error   = $data['code'];
      $message = $data['status'];
      if ($data['code'] == '200') {
        $fileContent = $data['content'];
        $localFilePath = XC_LOCAL_MODULE_ROOT . '/' . $file;
        $wRet = $this->file_write($localFilePath, $fileContent);
        if (!$wRet) {
          $error   = '420';
          $message = '写入失败';
        }
      }
      return array($error, $message);
  }


}
