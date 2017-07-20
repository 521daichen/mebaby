$(document).ready(function(){
    $("#loadinfo").click(function(e){
        //点击时加载停车缴费信息的条款项
        var radboxDiv = $(".radbox");
        // 计算需要请求的起始页数
        var pageStart = (radboxDiv.length / 10) + 1; 

        console.log(pageStart);

        $.ajax({
            type: "GET",
            contentType: "text/html; charset=utf-8",
            dataType: "html",
            url: "http://wx.cnsaga.com/app/index.php?i=4&c=entry&do=Async&m=member&page="+pageStart,
            //data: "data",
            success: function (response) {
                 // 添加div节点 , 信息文字节点至div节点
                $("section").append(response);
            }
        });
    })
})