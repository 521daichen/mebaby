<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>

<script type='text/javascript' src='resource/js/lib/jquery-1.11.1.min.js'></script>
<link type="text/css" rel="stylesheet" href="../addons/ewei_shopping/images/style.css?<?php echo TIMESTAMP;?>">

<div class="head">
    <a href="javascript:history.back();" class="bn pull-left"><i class="fa fa-angle-left"></i></a>
    <span class="title">结算</span>
    <a href="<?php  echo $this->createMobileUrl('mycart')?>" class="bn pull-right"><i class="fa fa-shopping-cart"></i><span class="buy-num img-circle"> <?php  echo $carttotal;?> </span></a>
</div>

<form class="form-horizontal" method="post" role="form" onsubmit='return check()'>
    <input type="hidden" name="address" value="<?php  echo $row['id'];?>" />
    <div class="order-main">
        <div id="real">
            <h5>收货地址</h5>
            <div id="myaddress">
                <?php  if(!empty($row)) { ?>
                <div id='address_<?php  echo $row['id'];?>' class="shopcart-main img-rounded address_item" style='margin:0;padding:10px;margin-bottom:10px;cursor:pointer' onclick='changeAddress()'>
                <span><?php  echo $row['province'];?> <?php  echo $row['city'];?> <?php  echo $row['district'];?> <?php  echo $row['address'];?> <br/> <?php  echo $row['username'];?> <?php  echo $row['mobile'];?></span>
                    <span style='float:right'>&nbsp;&nbsp;
                        <a href="<?php  echo $this->createMobileUrl('address', array('from'=>'confirm','returnurl' => $returnUrl))?>">管理收货地址</a>
                    </span>
            </div>
            <?php  } else { ?>
            <div>
                <a href="<?php  echo $this->createMobileUrl('address',array('from'=>'confirm','returnurl'=> $returnUrl))?>" class="btn btn-danger"><i class="fa fa-plus"></i> 添加修改地址</a>
            </div>
            <?php  } ?>
        </div>
        <h5>配送方式</h5>
        <select id='dispatch' name="dispatch" class="form-control">
            <?php  if(is_array($dispatch)) { foreach($dispatch as $d) { ?>
            <option value="<?php  echo $d['id'];?>" price='<?php  echo $d['price'];?>'><?php  echo $d['dispatchname'];?> (<?php  echo $d['price'];?>元)</option>
            <?php  } } ?>
        </select>
    </div>
    <div style="margin-top: 10px;">
        <a href="javascript:" style="display: none" id="fictitious" onclick="return fictitious()" class="btn btn-info">虚拟物品无需配送</a>
    </div>
    <h5>订单详情</h5>
    <div class="order-detail">
        <table class="table">
            <thead>
            <tr>
                <th class="name">商品</th>
                <th class="num">数量</th>
                <th class="total">单价</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($allgoods)) { foreach($allgoods as $item) { ?>
            <input type="hidden" name="goodstype" value="<?php  echo $item['type'];?>" />
            <?php  if($item['type'] == '2') { ?>
            <script language="JavaScript">
                $('#fictitious').show();
            </script>
            <?php  } ?>
            <tr>
                <td class="name">
						<span  style="float:left;">
							<a href='<?php  echo $this->createMobileUrl('detail',array('id'=>$item['id']))?>'><?php  echo $item['title'];?></a>
                            <?php  if(!empty($item['optionname'])) { ?><br/>
							<span style='font-size:12px;color:#666'> <?php  echo $item['optionname'];?></span>
							<?php  } ?>
						</span>
                </td>
                <td class="num">
                    <?php  echo $item['total'];?><?php  if(!empty($item['unit'])) { ?><?php  echo $item['unit'];?><?php  } ?>
                </td>
                <td class="total">
                    <span style="display: none;"><?php  echo $item['total'];?></span>
                    <span class='goodsprice'><?php  echo $item['marketprice'];?> 元</span>
                    <span style="display: none;"><?php  echo $item['marketprice'];?></span>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <div class="order-detail-hd">
				<span class="pull-right" style="color:#E74C3C;">
					[合计：<span id='totalprice'><?php  echo $totalprice;?></span>]
				</span>
        </div>
        <div style="clear:both;"></div>
    </div>
    <h5>留言</h5>
    <div class="message-box">
        <textarea class="form-control" rows="3" name="remark" placeholder="亲，还用什么能帮助到您吗？就写到这里吧！"></textarea>
    </div>
    <button type="submit" name="submit" value="yes" class="btn btn-success order-submit btn-lg" style="margin-bottom:20px;">提交订单</button>
    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
    </div>
</form>

<script language='javascript'>
    function fictitious() {
        $('#real').hide();
    }
    function changeAddress(){
        location.href = '<?php  echo $this->createMobileUrl('address', array('from' => 'confirm','returnurl' => $returnUrl))?>'
    }
    function check(){
        if((".address_item").length<=0){
            alert("请添加收货地址!");
            return false;
        }
        return true;
    }

    $("#dispatch").change(canculate);

    function canculate(){
        var prices = 0;
        $(".goodsprice").each(function() {
            var total = $(this).prev().text();
            var price = $(this).next().text();
            round(prices += parseFloat(total * price),2);
        });
        var dispatchprice = parseFloat($("#dispatch").find("option:selected").attr("price"));
        if (dispatchprice > 0){
            $("#totalprice").html(prices + dispatchprice + " 元 (含运费"+dispatchprice + ")");
        } else {
            $("#totalprice").html(prices + " 元");
        }
    }
    $(function(){
        canculate();
    })
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footerbar', TEMPLATE_INCLUDEPATH)) : (include template('footerbar', TEMPLATE_INCLUDEPATH));?>