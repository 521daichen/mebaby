<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
	<div class="clearfix">
		<iframe id="iframe" name="iframe" src="" style="margin-bottom: 0px;" marginheight="0" marginwidth="0" frameborder="0" scrolling="auto" width="100%" height="100%" allowTransparency="true" >
		</iframe>
	</div>
</div>
<script>
function autoHeightIFrameNavigate(iframeId,url) {
	var iframe = $('#'+iframeId);
	iframe.attr('_name_',iframe.attr('name'));
	iframe.attr('src',url);
	iframe.one('load',function(){
		this.contentWindow.location = "about:blank"; 
		$(this).one('load',function(){
			var msg = this.contentWindow.name;
			this.contentWindow.name = $(this).attr('_name_');
			this.contentWindow.location = url;
			try{
				var height = eval(msg);
				iframe.css('height',height + 'px');
			}catch(e){
				iframe.css('height', '1000px');
			}
		});
	});
}
$(function(){
	$('#iframe').css('min-height', $(window).height()-140);
	autoHeightIFrameNavigate('iframe','<?php  echo $iframe;?>');
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>