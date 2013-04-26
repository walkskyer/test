var jingDong = (function() {
	var that = siteParent();
	that.config = {
		siteName: '京东',
		siteUrl: 'http://www.jd.com',
		//链接配置
		url: 'http://search.jd.com/Search',
		searchField: 'keyword',
		siteChar: 'GB2312',
		OtherFieldAndValue: '',
	}
	var loadPriceNum; //标志完成图片转换个数



	/**
	 * 代理处理完请求后的回调
	 */
	that.loadCallback = function(res) {
		var resDom = $(res);
		if (!that.isPageInit) {
			pageInit(resDom);
		}
		var productListDom = $(resDom).find('.psearch li');
		if (!productListDom || productListDom.length == 0) {
			globalTool.oneDone([]);
			return;
		}

		for (var i = 0; i < productListDom.length; i++) {
			//log(productListDom[i]);
			var name = $(productListDom[i]).find('.p-name a').text();
			var url = $(productListDom[i]).find('.p-name a').attr("href");
			var img = $(productListDom[i]).find('.p-img img').attr("data-lazyload");
			var price = $(productListDom[i]).find('.p-price img').attr("data-lazyload");
			that.productList[that.productList.length] = {
				name: name,
				img: img,
				price: price,
				url: url,
				siteUrl: that.config.siteUrl,
				from: that.config.siteName
			}
		}
		loadPriceNum = 0;
		imgToNum();
	}



	/**
	 * 并发转换图片
	 */
	function imgToNum() {
		for (var i = 0; i < that.productList.length; i++) {
			agentTool.getNum(that.productList[i].price, i, imgToNumCallback , imgToNumErrorCallback);
			that.productList[i].price = 0;
		}
	}

	/**
	 * 一张图片处理完后的回调事件
	 */
	function imgToNumCallback(res) {
		loadPriceNum++
		if(res){
			that.productList[res.pos].price = parseFloat(res.num);
		}
		
		//价格加载完毕
		if (loadPriceNum == that.productList.length) {
			
			globalTool.oneDone(that.productList);
		}
	}
	
	function imgToNumErrorCallback(){
		imgToNumCallback();
	}
	
	
	
	function pageInit(resDom) {
		var allPage = $(resDom).find(".page-skip em").html().replace(/[^\d]/g, "");
		console.log(allPage);

		allPage = parseInt(allPage);

		for (i = 0; i < allPage; i++) {
			that.pageList[ that.pageList.length] =
							that.config.url
							+ '?'
							+ that.config.searchField
							+ '='
							+ globalTool.searchName
							+ '&page='
							+ i;
		}
		that.isPageInit = true;
		console.log(that.pageList);
	}
	

	//返回的可调用变量
	return that;
})();