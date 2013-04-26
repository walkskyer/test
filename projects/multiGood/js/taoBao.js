var taoBao = (function() {
	
	var that = siteParent();
	that.config =  {
		siteName: '淘宝',
		siteUrl: 'http://www.taobao.com',
		siteChar: 'UTF-8',
		//链接配置
		url: 'http://s.taobao.com/search',
		searchField: 'q',
		OtherFieldAndValue: '',
		pageCount : 40
	};
	
	
	/**
	 * 代理处理完请求后的回调1
	 * 淘宝返回有两种格式
	 */
	that.loadCallback = function(res) {
		res = res.replace('textarea', 'div');
		
		var resDom = $(res);
		if (!that.isPageInit) {
			pageInit(resDom);
		}
		
		var productListDom = $(resDom).find('.grid-view .item');
		
		if (!productListDom || productListDom.length == 0) {
			loadCallback2(res);
			return;
		}

		for (var i = 0; i < productListDom.length; i++) {
			//log(productListDom[i]);
			var name = $(productListDom[i]).find('.summary a').attr('title');
			var url = $(productListDom[i]).find('.pic-box a').attr("href")
			url = url.replace('http://ju.atpanel.com/?url=', '');
			var img = $(productListDom[i]).find('.pic-box img').attr("src");
			var price = $(productListDom[i]).find('.price').text().replace(/[^\d\.]/g, '');
			that.productList[that.productList.length] = {
				name: name,
				img: img,
				price: parseFloat(price),
				url: url,
				siteUrl: that.config.siteUrl,
				from: that.config.siteName
			}
		}
		//log(productList);
		globalTool.oneDone(that.productList);

	}

	/**
	 * 代理处理完请求后的回调2
	 * 淘宝返回有两种格式
	 */
	function loadCallback2(res) {
		var productListDom = $(res).find('.list-view .list-item');
		if (productListDom.length == 0) {
			globalTool.oneDone([]);
			return;
		}
		//log(productListDom.html());
		for (var i = 0; i < productListDom.length; i++) {
			//log($(productListDom[i]).html());
			var name = $(productListDom[i]).find('.summary a').attr('title');
			var url = $(productListDom[i]).find('.summary a').attr("href")
			var img = $(productListDom[i]).find('.photo img').attr("src");
			if (!img) {
				var img = $(productListDom[i]).find('img').attr("data-ks-lazyload");
			}
			img = img.replace('_sum.jpg', '');
			var price = $(productListDom[i]).find('.price em:eq(0)').text();


			that.productList[that.productList.length] = {
				name: name,
				img: img,
				price: parseFloat(price),
				url: url,
				siteUrl: that.config.siteUrl,
				from: that.config.siteName
			}
		}
		globalTool.oneDone(that.productList);
	}
	
	function pageInit(resDom) {
		var allPage = $(resDom).find(".pagination .page-info").html().split('/')[1];
		
		console.log(allPage);
		
		allPage = parseInt(allPage);
		
		for (i = 0; i < allPage; i++) {
			that.pageList[ that.pageList.length] =   
							that.config.url 
							+'?' 
							+ that.config.searchField
							+ '='
							+ globalTool.searchName
							+ '&s='
							+ i * 40;
		}
		
		that.isPageInit = true;
		console.log(that.pageList);
	}
	
	

	//返回的可调用变量
	return that;
})();