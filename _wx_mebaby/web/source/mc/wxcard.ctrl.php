<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under]  the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('display', 'manage', 'delete','paygift','QR','delgc','update','wxupdate','current','delcur');
$do = in_array($do, $dos) ? $do : 'display';
load()->func('tpl');
load()->model('mc');

load()->func('communication');

$setting = pdo_fetch("SELECT * FROM ".tablename('mc_create_cards')." WHERE uniacid = '{$_W['uniacid']}'");
if ($do == 'display') {

    if (checksubmit('submit')) {
		if (empty($_GPC['title'])) {
			message('请填写会员卡名称');
		}
		if (empty($_GPC['create_method'])) {
			message('请选择激活方式');
		}

        $auto_activate=($_GPC['create_method']=='1')?'true':'false';
		$wx_activate=(($_GPC['create_method']=='3')||($_GPC['create_method']=='2'))?'true':'false';
		$wx_activate_url = $_GPC['wx_activate_after_submit_url'];
        $wx_activate_after_submit=($_GPC['create_method']=='3')?'true':'false';
        $title=$_GPC['title'];
        $service_phone = $_GPC['service_phone'];
        $description = $_GPC['description'];
        $quantity=$_GPC['quantity'];
        $get_limit=$_GPC['get_limit'];
        $brand_name=$_GPC['brand_name'];
        $background_pic_url=$_GPC['background_pic_url'];
        $logo_url=$_GPC['logo_url'];
        $prerogative = $_GPC['prerogative'];
        $custom_field1_url=$_GPC['custom_field1_url'];
        $custom_field2_url=$_GPC['custom_field2_url'];
        $custom_url_name=$_GPC['custom_url_name'];
        $custom_url=$_GPC['custom_url'];
        $custom_cell1_name=$_GPC['custom_cell1_name'];
        $custom_cell1_url=$_GPC['custom_cell1_url'];
        $promotion_url_name=$_GPC['promotion_url_name'];
        $promotion_url=$_GPC['promotion_url'];

        $post = '{
                  "card": {
                        "card_type": "MEMBER_CARD",
                        "member_card": {
                             "auto_activate":'.$auto_activate.',
                             "wx_activate":'.$wx_activate.',
                             "wx_activate_after_submit":'.$wx_activate_after_submit.',
                             "wx_activate_after_submit_url":"'.$wx_activate_url.'",
                             "background_pic_url":"'.$background_pic_url.'",
                             "supply_bonus":true,
                             "supply_balance":false,
                             "prerogative":"'.$prerogative.'",  
                             "base_info": {
                              	"pay_info": 
                 				{
                         			"swipe_card":
                         			{
                            			"is_swipe_card":true
                         			}
                        		},
                                "logo_url":"'.$logo_url.'",
                                "brand_name":"'.$brand_name.'", 
                                "code_type":"CODE_TYPE_QRCODE",
                                "title":"'.$title.'",
                                "color":"Color040",
                                "notice":"使用时向服务员出示此券",
                                "service_phone":"'.$service_phone.'",
                                "description":"'.$description.'",
                                "date_info":{
                                    "type":"DATE_TYPE_PERMANENT"
                                },
                                "sku":{
                                    "quantity":"'.$quantity.'"
                                },                                
                                "get_limit":"'.$get_limit.'",
                                
                                "use_custom_code":false,
                                "can_give_friend":false,
                                "location_id_list":[
                                    477402424
                                ],
                                "custom_url_name":"'.$custom_url_name.'",
                                "custom_url":"'.$custom_url.'",
                             
                                "need_push_on_view":false
                             }
                        } 
                  }
        }';
		$weiObj = WeAccount::create($_W['uniacid']);
        $token = $weiObj->fetch_token();
	
        $url = "https://api.weixin.qq.com/card/create?access_token=".$token;

        $rest = http_attach_post($url, $post);
        $errcode=json_decode($rest)->errcode;
        $errmsg=json_decode($rest)->errmsg;
        if($errcode==0){
            $card_id=json_decode($rest)->card_id;
            if($wx_activate&&$card_id){
                $listcr = '{
                              "card_id":"'.$card_id.'",
                              "required_form":{
                                      "common_field_id_list": [
                                               "USER_FORM_INFO_FLAG_MOBILE",
                                               "USER_FORM_INFO_FLAG_NAME"
                                      ]
                              }
                }';
                $urlcr = "https://api.weixin.qq.com/card/membercard/activateuserform/set?access_token=".$token;
                $restcr= http_attach_post($urlcr, $listcr);
                $actErrCode=json_decode($rest)->errcode;
                $actErrMsg=json_decode($rest)->errmsg;
                if($actErrCode != 0){
                    message("$actErrMsg", url('mc/wxcard/display'), 'error');
                }
                //var_dump($restcr);
            }
            $data = array(
                'cardname' => $_GPC['title'],
                'create_method' => $_GPC['create_method'],
                'uniacid'=>$_GPC['__uniacid'],
                'card_id'=>$card_id,
                'create_time'=>time()
            );

            $data['cid'] = $_W['cid'];
            pdo_insert('mc_create_cards', $data);
            message('创建成功', url('mc/wxcard/manage'), 'success');
        }else{
            message("$errmsg", url('mc/wxcard/display'), 'error');
        }
    }
}


if ($do == 'manage') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $sql = 'SELECT * FROM ' . tablename('mc_create_cards');
    $list = pdo_fetchall($sql);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_create_cards'));
    $pager = pagination($total, $pindex, $psize);
}

if ($do == 'delete') {
    $weiObj = WeAccount::create($_W['uniacid']);
    $token = $weiObj->fetch_token();
    $urlde = "https://api.weixin.qq.com/card/delete?access_token=".$token;
    $card_id = $_GPC['card_id'];
    $postde='{
                "card_id": "'.$card_id.'"
    }';
    $rest = http_attach_post($urlde, $postde);
    $errcode=json_decode($rest)->errcode;
    if($errcode==0){
        if (pdo_delete('mc_create_cards',array('card_id' =>$card_id))) {
            message('删除会员卡成功',url('mc/wxcard/manage'),'success');
        } else {
            message('删除会员卡失败',url('mc/wxcard/manage'),'error');
        }
    }else{
        message('接口出错！',url('mc/wxcard/manage'),'error');
    }
}
if ($do == 'QR') {
    $weiObj = WeAccount::create($_W['uniacid']);
    $token = $weiObj->fetch_token();
    $urlqr = "https://api.weixin.qq.com/card/qrcode/create?access_token=".$token;
    $card_id = $_GPC['card_id'];
    $postqr='{
        "action_name": "QR_CARD", 
        "action_info": {
            "card": {
                "card_id":  "'.$card_id.'",
                "outer_id":"2"
            }
        }
    }';
    $rest = http_attach_post($urlqr, $postqr);
    $restinfo=json_decode($rest,true);
    echo "<pre>";
    $ticket=$restinfo['ticket'];
    $show_qrcode_url=$restinfo['show_qrcode_url'];
  //var_dump($restinfo);
   //echo $ticket."<br/>";
  // echo $show_qrcode_url;
    echo "<script>location.href='$show_qrcode_url'</script>";
}
if ($do == 'paygift') {
    $weiObj = WeAccount::create($_W['uniacid']);
    $token = $weiObj->fetch_token();
    $urlgc="https://api.weixin.qq.com/card/paygiftcard/add?access_token=".$token;
    $card_id = $_GPC['card_id'];
    //var_dump($card_id);
    $listgc='{
                 "rule_info": {
                                   "type": "RULE_TYPE_PAY_MEMBER_CARD",
                                   "base_info": {
                                         "mchid_list": [
                                                   "1294322901"
                                         ],
                                         "begin_time": 1480317217,
                                         "end_time": 1680317217
                                   },
                                   "member_rule": {
                                         "card_id": "'.$card_id.'",
                                         "least_cost": 1,
                                         "max_cost": 200000000
                                   }
                 }
             }';
    $restgc= http_attach_post($urlgc, $listgc);
    $restinfo=json_decode($restgc,true);
    $occupy_rule_id=$restinfo['fail_mchid_list'][0]['occupy_rule_id'];
    if(!$occupy_rule_id) {
        $rule_id=$restinfo['rule_id'];
    }else {
        $urldegc = "https://api.weixin.qq.com/card/paygiftcard/delete?access_token=" . $token;
        $postdegc = '{
               "rule_id":  "' . $occupy_rule_id . '"
        }';
        $restdegc = http_attach_post($urldegc, $postdegc);
        $degcerrcode = json_decode($restdegc)->errcode;
        if ($degcerrcode==0) {
            $restgc = http_attach_post($urlgc, $listgc);
            $errcode = json_decode($restgc)->errcode;
            if($errcode==0) {
                $rule_id=json_decode($restgc)->rule_id;
            }
        }else{
            message('设置支付即会员失败', url('mc/wxcard/manage'), 'error');
        }
    }
    $card_data=array(
        'rule_id'=>$rule_id,
        'gc_status'=>1
        );
    $gcresult=pdo_update('mc_create_cards',$card_data,array('card_id' =>$card_id));
    pdo_query(" update ims_mc_create_cards set gc_status='0' where card_id != '".$card_id."' ");

    if(!empty($gcresult)){
        message('设置支付即会员成功',url('mc/wxcard/manage'),'success');
    }else {
        message("设置支付即会员失败",url('mc/wxcard/manage'),'error');
    }
}

if ($do == 'delgc') {
    $weiObj = WeAccount::create($_W['uniacid']);
    $token = $weiObj->fetch_token();
    $urlde =  "https://api.weixin.qq.com/card/paygiftcard/delete?access_token=" . $token;
    $rule_id = $_GPC['rule_id'];
    $postde='{
                "rule_id": "'.$rule_id.'"
    }';
    $rest = http_attach_post($urlde, $postde);
    $errcode=json_decode($rest)->errcode;
    $card_data=array('gc_status'=>0);
    if($errcode==0){
        if (pdo_update('mc_create_cards',$card_data,array('rule_id' =>$rule_id))) {
            message('取消支付即会员成功',url('mc/wxcard/manage'),'success');
        } else {
            message('取消支付即会员失败',url('mc/wxcard/manage'),'error');
        }
    }else{
        message('接口出错！',url('mc/wxcard/manage'),'error');
    }
}

if ($do == 'update') {
    $card_id = $_GPC['card_id'];
}
if ($do == 'wxupdate') {
    $weiObj = WeAccount::create($_W['uniacid']);
    $token = $weiObj->fetch_token();
    $urlup = "https://api.weixin.qq.com/card/update?access_token=".$token;
    $card_id = $_GPC['card_id'];
     $background_pic_url=$_GPC['background_pic_url'];
     $logo_url=$_GPC['logo_url'];
     $custom_field1_url=$_GPC['custom_field1_url'];
     $custom_field2_url=$_GPC['custom_field2_url'];
     $custom_url_name=$_GPC['custom_url_name'];
     //$custom_url_sub_title=$_GPC['custom_url_sub_title'];
     $custom_url=$_GPC['custom_url'];
     $custom_cell1_name=$_GPC['custom_cell1_name'];
     //$custom_cell1_tips=$_GPC['custom_cell1_tips'];
     $custom_cell1_url=$_GPC['custom_cell1_url'];
     $promotion_url_name=$_GPC['promotion_url_name'];
     //$promotion_url_sub_title=$_GPC['promotion_url_sub_title'];g
     $promotion_url=$_GPC['promotion_url'];
     //var_dump($card_id);
     //echo "<br/>";
     $postup='{
                 "card_id": "'.$card_id.'",
                  "member_card": {
                        "background_pic_url": "'.$background_pic_url.'",
                        "base_info": {
                                 "logo_url":  "'.$logo_url.'",
                                 "custom_url_name":"'.$custom_url_name.'",
                                 "custom_url": "'.$custom_url.'",
                                 "promotion_url_name":"'.$promotion_url_name.'",
                                 "promotion_url":"'.$promotion_url.'"
                        },
                       
                        "custom_field1": {
                                 "url": "'.$custom_field1_url.'"
                        },
                        "custom_field2": {
                                 "url":"'.$custom_field2_url.'"
                        },
                        "custom_cell1": {
                                 "name":"'.$custom_cell1_name.'",
                                 "url": "'.$custom_cell1_url.'"
                        }
 
                  }
     }';
    // echo "<pre>";
   //  var_dump($postup);

    $rest = http_attach_post($urlup, $postup);
    // var_dump($rest);
    // exit;
     $errcode=json_decode($rest)->errcode;
     if($errcode==0){
         message('更新会员卡成功',url('mc/wxcard/manage'),'success');

     }else{
         message('接口出错！',url('mc/wxcard/manage'),'error');
     }
}
if ($do == 'current') {
    $card_id = $_GPC['card_id'];
    $card_data=array('cur_card_id'=>1);
    pdo_query(" update ims_mc_create_cards set cur_card_id='0' where card_id != '".$card_id."' ");
    if(pdo_update('mc_create_cards',$card_data,array('card_id' =>$card_id))){
        message('设置当前状态成功',url('mc/wxcard/manage'),'success');
    }else {
        message("设置当前状态失败",url('mc/wxcard/manage'),'error');
    }
}
if ($do == 'delcur') {
    $card_id = $_GPC['card_id'];

    $card_data=array('cur_card_id'=>0);
    if (pdo_update('mc_create_cards',$card_data,array('card_id' =>$card_id))) {
            message('取消当前卡状态成功',url('mc/wxcard/manage'),'success');
    } else {
            message('取消当前卡状态失败',url('mc/wxcard/manage'),'error');
    }
}

function http_attach_post($url, $param)
{
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
    }
    if (is_string($param)) {
        $strPOST = preg_replace('/\s/', '', $param);
    } else {
        return false;
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST,true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        return false;
    }
}

template('mc/wxcard');