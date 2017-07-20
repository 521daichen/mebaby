	var desl = new Object();
	desl.category = '';
	desl.id;
	desl.option   = {
				    'category': [
				  				//女性：年龄
				                ['比我大的成熟大叔','同我差不多大的进取青年','比我小的多汁小鲜肉','年龄无所谓'],
				                //女性：类似
				 	            ['沉稳上进','智慧傲人','浪漫柔情','注重情义','多金潜力股','幽默段子手','居家暖男','霸道总裁','完美主义者','颜控大长腿','善良执著','阳光大男孩'],
				 	            //男性：年龄
				                ['比我大的风韵熟女','同我差不多大的独立御姐','比我小的清新萝莉','年龄无所谓'],
				                //男性：类型 
				                ['内敛矜持','善解人意','活力四射','理财小能手','聪明独立','贤妻良母','恬静细腻','慷慨霸气','天然无公害','气质迷人','乐天可爱'],       
				                //共用：职业
					            ['朝九晚五铁饭碗','有暑假的教师一族','苦逼IT加班狗','钞票不是自己的银行人','小资白领OL','全是男性的建筑man','靠创意吃饭的广告人','救死扶伤行医者','踏遍山水的导游','孤单寂寞属创业','我是厨子你有福','漂移不是事的老司机','需被善待的服务业'], 
					            //共用：爱好
					            ['看电影','跳舞','看书','火锅','逛街','撸串','唱歌','游泳','周杰伦','韩剧','茶艺','陈冠希','德云社','旅行','摄影','美剧','健身','咖啡','酒吧','球类运动','LOL','户外','英语','宅','养宠物','cosplay','淘宝','曲艺','绘画','钓鱼','做直播','烹饪','飙车','设计','集邮','炒股','理财'],
					            //公用：标签  
					            ['文艺青年','rocker','小清新','酸奶控','码农','球迷','外貌协会','人格分裂','技术宅','伪二次元','小鲜肉','老腊肉','大胸姐','经济适用','乐天派','收藏爱好者','不羁爱自由'],
					            //性别
					            ['男','女']
					            ]
					};
	//主方法getlist(对象ID,是否复选,是否输入,接收方元素ID,用于分隔的元素)
	desl.getlist = function(a,b,c,d,e){
		//document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
		if(desl.id !== a){
			desl.category = "";
		}
		//字符串结尾加顿号
		if(desl.category.charAt(desl.category.length - 1)!==e && $(d).val() !== "" && desl.category !== ""){
			desl.category = desl.category+e;
		}
		
		var li = new Array();
		for(var i=0;i<this.option.category[a].length;i++){
			li[i] = this.option.category[a][i];
		}
			$(".desl_title").remove();
			$(".desl_box").remove();
	    	$(".desl_mask").remove();
			$("body").append(desl.Template(li,b));
			$(".desl_box").removeClass("bounceInRight animated");
			$(".desl_box").addClass("bounceInRight animated");
			$(".desl_title").removeClass("bounceInRight animated");
			$(".desl_title").addClass("bounceInRight animated");
			$(".desl_mask").css("display","block");
			//为选项绑定点击事件
			for(var i=0;i<this.option.category[a].length;i++){
				$(".desl_box ul li").eq(i).on("click",function(){
					if(b == 0){
						desl.category = $(this).html(); //单选
						$(".desl_box ul li:not(.desl_title)").removeClass();
						$(this).addClass("Selected");
					}else{ //复选
						var text = $(this).html();
						
						if(desl.category.indexOf(text) !== -1){
							desl.category = desl.category.replace(text+e, "");
							$(this).removeClass();
						}else{
							desl.category = $(this).html() + e + desl.category; 
							$(this).addClass("Selected");
						}
					}
				});
			}
		
		//是否可自定义
		if (c == 1) { 
				$(".desl_box ul").prepend("<li><img src='../../addons/member/template/mobile/static/chasing/images/add.png' class='desl_add' />自定义选项</li>");
				$(".desl_box ul li").eq(0).on("click",function(){
					
				    var value = prompt('输入自定义选项：', '');
				    if(value !== null && value !=="" ){  
				    	//$(".desl_box ul").prepend("<li>"+value+"</li>");
				    	desl.option.category[a].unshift(value);
						desl.getlist(a,b,c,d,e);
				    }
				    
				});
			};
		setTimeout(function(){
		$(".submit,.desl_mask").on("click",function(){
			//document.addEventListener('touchmove', function (e) { e.preventDefault(); }, true);
			if(desl.category.charAt(desl.category.length - 1)==e){
				desl.category = desl.category.substring(0,desl.category.length-1);
				}
				$(d).val(desl.category);
				$(".desl_title").removeClass("bounceInRight animated");
				$(".desl_title").addClass("bounceOutRight animated");
				$(".desl_box").removeClass("bounceInRight animated");
				$(".desl_box").addClass("bounceOutRight animated");
				$(".desl_mask").css("display","none");
		 
				desl.id = a;
			
		})
		},500)
		
	}
	//Template(传入的选项数组组成模板)
	desl.Template = function(a,b){
		temp = "<div class=\"desl_mask\"></div>";
		temp = temp+"<div class=\"desl_box\">";
		temp = temp+"<ul>";
		for(var i=0;i<a.length;i++){
			temp = temp+"<li>"+a[i]+"</li>";
		}
		temp = temp+"</ul></div>";
		if(b==0){
			temp = temp+"<div class=\"desl_title\">以上为单选<span class=\"submit\">确定</span></div>";
		}else{
			temp = temp+"<div class=\"desl_title\">以上为多选<span class=\"submit\">确定</span></div>";
		}
		return temp;
	}

 