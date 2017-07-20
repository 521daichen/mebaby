<?php
defined('IN_IA') or exit('Access Denied');

class xc_panelModule extends WeModule {

	public function fieldsFormDisplay($rid = 0) {

	}

	public function fieldsFormValidate($rid = 0) {
		return '';
	}

	public function fieldsFormSubmit($rid) {
	}

	public function ruleDeleted($rid) {
	}

  public function settingsDisplay($settings)
  {
    global $_GPC, $_W;
    if (checksubmit()) {
      $cfg = array(
        'apptoken' => trim($_GPC['apptoken'])
      );
      if ($this->saveSettings($cfg)) {
        message('保存成功', $this->createWebUrl('Upgrade'), 'success');
      }
    }
    include $this->template('setting');
  }

}
