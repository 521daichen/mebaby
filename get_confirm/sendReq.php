<?php
$appid = "wx6387588001660423";
$scene = "1";
$template_id = "LGk2W4ErfdQw572_ji-oScrRIA0fwxQosJPZb29tQXo";
$redirect_url = urlencode("http://gc.mebaby.cn");
$reserved = md5("pangziwang");

$http = "https://mp.weixin.qq.com/mp/subscribemsg?action=get_confirm&appid=".$appid."&scene=".$scene."&template_id=".$template_id."&redirect_url=".$redirect_url."&reserved=".$reserved;

echo "<img src='http://qr.topscan.com/api.php?text=".$http."' width=500 />";



