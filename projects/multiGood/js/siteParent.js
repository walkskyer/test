var siteParent = function(){
	var that = {};
	that.productList = [];
	that.pageList = [];
	that.config = {};
	
	that.isPageInit = false;
	
	that.reset = function(){
		that.isPageInit = false;
		that.pageList = [];
		that.productList = [];
	}
	
	that.pageReset = function(){
		that.productList = [];
	}
	
	
	that.getConfig = function(){
		return that.config;
	}
	
	that.searchBegin = function(searchStr){
		var fullUrl = that.config.url + '?' 
		+ that.config.searchField
		+'='
		+searchStr 
		+that.config.OtherFieldAndValue;

		agentTool.getFromUrl(fullUrl , that.config , that.loadCallback);
	}
	
	that.goToPage = function(page){
		pos = page - 1;
		if(that.pageList.length >= page){
			agentTool.getFromUrl(that.pageList[pos] , that.config , that.loadCallback);
		}else{
			globalTool.oneDone([]);
		}
	}
	return that;
}


