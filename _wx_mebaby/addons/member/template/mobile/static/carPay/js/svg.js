var viewdefault ={
    map     : document.querySelector("#map"),
    main    : document.querySelector("#main"),
    cWidth  : document.documentElement.clientWidth,
    cHeight : document.documentElement.clientHeight,
    mWidth  : 1080,
    mHeight : 1900,
    setview : function(){
        map.setAttribute("width",this.cWidth+"px");
        map.setAttribute("height",(this.cWidth/this.mWidth)*this.mHeight+"px");
        main.style.width=this.cWidth+"px";
        main.style.height=this.cHeight+"px";
    }
	//orientationChange:function(){
 //   	switch(window.orientation) {
 //   　　 case 0: 
 //          //console.log("肖像模式 0,screen-width: " + screen.width + "; screen-height:" + screen.height);
 //   　　 case -90: 
 //          //console.log("左旋 -90,screen-width: " + screen.width + "; screen-height:" + screen.height);
 //   　　 case 90:   
 //          //console.log("右旋 90,screen-width: " + screen.width + "; screen-height:" + screen.height);
 //     		//main.css("-webkit-transform","rotate(270deg)");
	//	    //setview();
	//		break;
 //   　　 case 180:   
 //       　　//console.log("风景模式 180,screen-width: " + screen.width + "; screen-height:" + screen.height);
 //       　　 break;
 //   	}
	//}
}

window.onload=function(){
	//屏幕旋转
	viewdefault.orientationChange;
    window.onorientationchange = viewdefault.orientationChange;
	//初始化地图尺寸
    viewdefault.setview(); 
    //获取车位信息
	var license = "#"+$("#License").val();
	if(license == "#"){
		$("#qi").css("display","none");	
	}
	var x = parseFloat($(license).attr("x"));
	var y = parseFloat($(license).attr("y"));
	var w = parseFloat($(license).attr("width"));
	var h = parseFloat($(license).attr("height"));
	x = x+(w/2);
	y = y+(h/2);
	//定位
	
	$("#qi").attr("transform","translate("+x+","+y+") scale(2)");
    //触摸事件开始
    $('#map').each(function () {
       dd = new RTP.PinchZoom($(this),{});
    });
	//坐标缩放
	$("#qi").attr("transform","translate("+x+","+y+") scale(2)");
	$("#map").on("touchmove",function (){
		var zoomv = 3; //定义最大放大级别
		zoomv = zoomv - $("#zoomvalue").val();
		if(zoomv>0.4){
			$("#qi").attr("transform","translate("+x+","+y+") scale("+zoomv+")");
		}
	})
} //onloadEnd