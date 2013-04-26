//全局变量
var cuzn_z_index = 20;//弹出框的叠放顺序 

function start_blank(inObj){
	var obj = inObj;
	var targeId;
	var width;
	var height;
	var titleText;
	var blankDom;
	var shadowDom;
	var targetDom;
	var titleDom;
		
	var cuzn_blank = {
		"init": function (){
			targetId = obj.id;
			var cuzn_blank = this;
			targetDom = document.getElementById(targetId);
			//未获取
			if(!targetDom){
				return false;
			}
			if(!targetDom){
				return false;
			}
			//初始化blank
			var newBlank = document.createElement("div");
			newBlank.className = "pop_blank";
			newBlank.style.zIndex = ++cuzn_z_index;

			//初始化title
			titleDom =  	document.createElement("div");
			titleDom.className = "title";
				
			titleText = document.createElement("strong");
			titleText.appendChild(document.createTextNode(obj.title));
			titleDom.appendChild(titleText);
				
			//关闭窗口
			if(!obj.banClose){
				var cancel = document.createElement("a");
				cancel.className = "cancel";
				cancel.setAttribute("href","javascript:void(0)");
				cancel.appendChild(document.createTextNode('X'));
				
				titleDom.appendChild(cancel);
			}
			
				
			var content  = document.createElement("div");
			content.className = "content";
			content.appendChild(targetDom);
				
			newBlank.appendChild(titleDom);
			newBlank.appendChild(content);
				
			document.body.appendChild(newBlank);
			blankDom = newBlank;
				
			//设置宽度和高度
			width =parseInt( blankDom.style.width);
			height =parseInt( blankDom.style.height);
				
			//定义了宽度和高度的。
			if(obj.width){
				width = obj.width;
				blankDom.style.width = obj.width + 'px';
				blankDom.style.overflow = 'hidden';
			}
			if(obj.height){
				height = obj.height;
				blankDom.style.height = obj.height + 'px';
				blankDom.style.overflow = 'hidden';
			}
			
			blankDom.style.position = 'fixed';
				
				
			//初始化阴影
			if(!obj.noShadow){
				shadowDom  = document.createElement("div");
				shadowDom.className = "pop_blank_shadow";
				document.body.appendChild(shadowDom);
			}else{
				shdowDom = false;	
			}
				
				
			//初始化事件
			//cancle点击
			//关闭窗口
			if(!obj.banClose){
				cancel.onclick = function(event){
					cuzn_blank.hide();
				}
			}

			//失去焦点事件
			if(obj.isBlur && !obj.noShadow){
				shadowDom.onclick = function(){
					cuzn_blank.hide();
				}
			}
				
			//拖动事件
			if(obj.isDrag){
				titleDom.style.cursor = 'move';
				var move_obj = new cuzn_move(titleDom,blankDom);
			}
				
		},
		"onResize" :function(){
			size = cuzn_blank.getWindowSize();

			blankDom.style.left = (size.sL + size.sw/2 - width/2) +"px";
			blankDom.style.top =  300 + "px";
			
			if(shadowDom){
				shadowDom.style.width = Math.max(document.documentElement.scrollWidth, document.documentElement.clientWidth || document.body.clientWidth) + 'px';
				shadowDom.style.height = Math.max(document.documentElement.scrollHeight, document.documentElement.clientHeight || document.body.clientHeight) + 'px';
			}
		},
		"show":function (){
			this.onResize();
			if(shadowDom){
				shadowDom.style.width = Math.max(document.documentElement.scrollWidth, document.documentElement.clientWidth || document.body.clientWidth) + 'px';
				shadowDom.style.height = Math.max(document.documentElement.scrollHeight, document.documentElement.clientHeight || document.body.clientHeight) + 'px';
 
				$(shadowDom).fadeIn("slow");
			}
			$(blankDom).fadeIn("slow");
			
		},
		"hide":function (){
			$(blankDom).fadeOut("slow");
			if(shadowDom){
				$(shadowDom).fadeOut("slow");
			}	
			
		},
		"getWindowSize" : function(){
			var sw =  document.body.clientWidth
			var sh =  Math.max(document.documentElement.scrollHeight, document.documentElement.clientHeight || document.body.clientHeight);
			var sL = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
			var sT = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
			
			return {
				sw:sw,
				sh:sh,
				sL:sL,
				sT:sT
			};
			
			
		},
		"setTitle": function(titleT){
			titleText.innerHTML = titleT;
		},
		"setContent": function(contentHTML){
			targetDom.innerHTML = contentHTML;
		}
	}	
	return cuzn_blank
}


/**
 * 移动的类，已封装.
 */
var cuzn_move = function(titleDom ,blankDom){
	//成员变量
	var now_left;
	var now_top;
	var distance_x;
	var distance_y;
    
    
	function init(){
		public_function.move();
	}
    
	// 私有函数
	function pointerX(){   
		return event.pageX || (event.clientX +     (document.documentElement.scrollLeft || document.body.scrollLeft)); 
	}
    
	function pointerY(){   
		return event.pageY || (event.clientY + (document.documentElement.scrollTop || document.body.scrollTop)); 
	}
				
	//公共函数
	var public_function = {
		'move':function(){				
			titleDom.onmousedown =function(e){
				now_left = parseInt(blankDom.style.left);
				now_top = parseInt(blankDom.style.top);
				distance_x = pointerX() - now_left;
				distance_y = pointerY() - now_top;
				//支持多个窗口                
				document.onmousemove = function(e){		
					now_left =  pointerX() - distance_x;
					now_top  =  pointerY() - distance_y;
				
					blankDom.style.left = 	now_left + "px";
					blankDom.style.top = 	now_top + "px";	
					return false;
				};
                
				return false;
			}
            
			titleDom.onmouseup =function(){
				document.onmousemove = null;
			};
            
			if(blankDom != titleDom){
				blankDom.onmousedown = function(){
				
					blankDom.style.zIndex = ++cuzn_z_index; 
				}	
			}
           
		},
		'clear_move':function(){
			alert("未完成");	
		}
			
	}
    
	init();
	return public_function;
}
