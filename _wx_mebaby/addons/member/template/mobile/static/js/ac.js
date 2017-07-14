function qrcode(){
    document.getElementById("qrcode").className="prompt";
}
function QRCODEdisplay(){
	var qrcode_box = document.getElementById("qrcode_box");
	if(qrcode_box.style.display=="none"){
		qrcode_box.style.display="block";
	}else{
		qrcode_box.style.display="none";
	}
}
function d_n(x){
    document.getElementById(x).className="d_n";
    $(".press_list").css("display","");
}
 function toupper(){
		var num=document.getElementById('num').value;
		document.getElementById('num').value=num.toUpperCase();
	        
        }

function clickof(variable,x){
    var obj = document.getElementById(variable);
    var state = obj.style.display;
    if(state=='block'){
    obj.style.display="none";
    document.getElementById(x).className="rotate";
    }else{
    obj.style.display="block";
    document.getElementById(x).className="rotates";
    }
 //alert(this.className);
	
} 

function pro(){
document.getElementById("bg").className="prompt";
$(".press_list").css("display","none");
}

function pro_n(){
	$("#bg").addClass("opxs");
	$(".proys").addClass("onexit");
	setTimeout(function(){
		document.getElementById("bg").className="d_n";
		$(".proys").removeClass("onexit");
	},350); 
	
    $(".press_list").css("display","");
}

function proadd(x){
	document.getElementById("pro").value=x;
	pro_n();
}

function hobby(){
document.getElementById("ah").className="prompt";
if(document.getElementById("hobby").value==""){
	
}else{
document.getElementById("ahvalue").value=document.getElementById("hobby").value+"、";
}
document.getElementById("hobby").value="";
$(".press_list").css("display","none");
}
function hobby_n(x){
 s=document.getElementById("ahvalue").value;
 s=s.substring(0,s.length-1);
 document.getElementById("hobby").value=s;
 $(".press_list").css("display","");
 document.getElementById("ahvalue").value="";
 $("#ah").addClass("opxs");
 $(".proys").addClass("onexit");
	setTimeout(function(){
		 document.getElementById("ah").className="d_n";
		$(".proys").removeClass("onexit");
	},350); 
	
    $(".press_list").css("display","");
}
function ahadd(x){
	Cts = document.getElementById("ahvalue").value;
	if(Cts.indexOf(x) > 0 )
	{
		
	}else{
	if(Cts.length<14){
		document.getElementById("ahvalue").value = document.getElementById("ahvalue").value + x;
	}else{
	if(Cts.indexOf("...") < 0 ){
		s=document.getElementById("ahvalue").value;
		s=s.substring(0,s.length-1);
		s=s+"....";
		document.getElementById("ahvalue").value=s;
		}
	}
	}
	
}

$(".gender span").on('click',function(){
      $(".gender span").removeClass();
      $(this).addClass("pitch");
     if($(this).text()=="男"){
     $("#gender").val(1);
     }else{
     $("#gender").val(2);
     }
      
   // alert($("#gender").val());
})

$(".valued span").on('click',function(){
     $(".valued span").removeClass();
     $(this).addClass("pitch");
     if($(this).text()=="否"){
     $("#valued").val(0);
     }else{
     $("#valued").val(1);
     }
   // alert($("#valued").val());
})

$("#zjlx").on('click',function(){
	$("#sf").removeClass();
	$("#sf").addClass("sf");	
})
//$("#sf").live('click',function(){
//	$("#sf").removeClass();	
//	$("#sf").addClass("d_n");
//})
function addzj(x,idType){
	$("#credentials").val(x);
    $('input[name="idType"]').val(idType);
	$("#sf").removeClass();	
	$("#sf").addClass("d_n");
	$("#zjma").css("display","block");
}


//车牌输入部分
function cpselect(x){
document.getElementById("cp").className="prompt";
$(".press_list").css("display","none");
document.getElementById("inputnum").value='';
document.getElementById("inputnum").value=x;
}

function isChn(str){
      var reg = /^[\u4e00-\u9fa5]+$/;
      if(!reg.test(str)){
       return true;
      }
      return false;
}

function loading(){
    layer.open({
        type: 2,
        content: '加载中...',
        shadeClose:false
    });
}


function alert(msg){
    layer.open({
        content: msg,
        style: 'background-color:#09C1FF; color:#fff; border:none;text-align:center',
        time: 2
    });
}

function tips(msg){
    layer.open({
        content: msg,
        btn: ['OK']
    });
}
function cp_noreg(){
 $("#cp").addClass("opxs");
 $(".proys").addClass("onexit");
setTimeout(function(){
		document.getElementById("cp").className="d_n";
		$(".proys").removeClass("onexit");
	},350); 
	
    $(".press_list").css("display","");
    $('#cpvalue').val('');
	$('#num').val('');
	$('#sheng').css('display','block');
	$('#zimu').css('display','none');
	$('#num').css('display','none')
}

function cpadd(x){
	Cts = document.getElementById("cpvalue").value;
	if(Cts.indexOf(x) > 0 )
	{
	}else{
		 
		if(Cts.length > 0){
			$("#cpvalue").val(Cts + x);
			$("#zimu").css("display","none");
			$("#num").css("display","block");
			//$("#num").focus();
			}else{
            $("#cpvalue").val(x);
            $("#sheng").css("display","none");
			$("#zimu").css("display","block");
		} 
		
	}
	
}


function dzselect(){
document.getElementById("dz").className="prompt";
$(".press_list").css("display","none");
}
function dz_n(){
 $("#dz").addClass("opxs");
 $(".proys").addClass("onexit");
setTimeout(function(){
		document.getElementById("dz").className="d_n";
		$(".proys").removeClass("onexit");
	},350); 
	
    $(".press_list").css("display","");
}
function dz_add(){
 $("#dzselect").val($(".prov").val()+"/"+$(".city").val()+"/"+$(".dist").val());
 $("#dz").addClass("opxs");
 $(".proys").addClass("onexit");
setTimeout(function(){
		document.getElementById("dz").className="d_n";
		$(".proys").removeClass("onexit");
	},350); 
	
    $(".press_list").css("display","");
	 
	
}

$(function(){
    var disval = $("#offon").val();
    if(disval==0){
        $("#offon").val(0);
        $(".useon").addClass("useoff");
        $(".useon").removeClass("useon");
        $(".text2").html("不使用积分抵停车费");
    }else{
        $("#offon").val(1);
        $(".useoff").addClass("useon");
        $(".useoff").removeClass("useoff");
        $(".text2").html("使用积分抵停车费");
    }

})
