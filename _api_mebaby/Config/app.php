<?php
/**
 * 请在下面放置任何您需要的应用配置
 */

return array(

    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
        'signature' => array('name' => 'signature', 'require' => true),
        'timestamp' => array('name' => 'timestamp', 'require' => true)
    ),

);
