/**
 * agentTool 
 * 代理的工具类
 */
var agentTool =(function( ){
	var _agentUrl = './agent/agent.php';//代理服务器
	var that = {};
	/**
	 * 向代理发送请求，无处理
	 * @param params 搜索的参数
	 * @param productName 搜索什么
	 * @param callback 成功之后的回调函数
	 */
	that.getFromUrl = function( fullUrl, params ,callback ){
		
		$.ajax({
			type: "POST",
			url: _agentUrl,
			data : {
				action:'fetch',
				url:fullUrl,
				siteName:params.siteName,
				charSet:params.siteChar,
				returnChar:getReturnChar()
			} ,
			dataType: 'text',
			success: callback,
			error:function(){
				console.log("error:" + fullUrl);
			}
		});	
	}
	
	
	/**
	 * 京东的价格为图片
	 * 通过agent图片转成数字
	 */
	that.getNum = function( imgUrl , pos,callback , errorCallback){
		$.ajax({
			type: "GET",
			url: _agentUrl,
			data : {
				action:"imgToNum",
				url:imgUrl,
				pos:pos
			} ,
			dataType: 'json',
			success: callback,
			error:errorCallback
		});	
	}
	
	
	/**
	 * 检测浏览器类型
	 * 返回服务器需要转回的字符编码
	 */
	function getReturnChar()  
	{  
		if(navigator.userAgent.indexOf("MSIE")>0) {  
			return "UTF-8";  
		}  
		if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){
			return "UTF-8";  
		}  
		//未调试
		if(isSafari=navigator.userAgent.indexOf("Safari")>0) {  
			return "GBK";  
		}   
		if(isCamino=navigator.userAgent.indexOf("Camino")>0){  
			return "GBK";  
		}  
		if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){  
			return "UTF-8";  
		}  
		
		return "UTF-8";
	}  
	
	
	//返回可调用函数
	return that;
})();

