var paiPai = (function() {

	var that = siteParent();
	that.config = {
		siteName: '拍拍',
		siteUrl: 'http://te.paipai.com',
		siteChar: 'GB2312',
		//链接配置
		url: 'http://search1.paipai.com/cgi-bin/comm_search1',
		searchField: 'KeyWord',
		OtherFieldAndValue: '&l_tg=2&PTAG=20058.18.5',
		pageCount : 48
	}

	/**
	 * 代理处理完请求后的回调
	 */
	that.loadCallback = function(res) {
		var resDom = $(res);
		if (!that.isPageInit) {
			pageInit(resDom);
		}
		var productListDom = $(resDom).find('#itemList li');
		if (!productListDom || productListDom.length == 0) {
			globalTool.oneDone([]);
			return;
		}

		for (var i = 0; i < productListDom.length; i++) {

			var name = $(productListDom[i]).find('.photo').next().find('a:eq(2)').text();
			var url = $(productListDom[i]).find('.photo a').attr("href");
			var img = $(productListDom[i]).find('.photo img').attr("init_src");
			var price = $(productListDom[i]).find('.pp_price').html();
			if (price) {
				price = price.substr(1);
			}
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
		var allPage = $(resDom).find(".go-page em").html().replace(/[^\d]/g, "");
		console.log(allPage);
		
		allPage = parseInt(allPage);
		var urlDemoDom = $(resDom).find("#pageBar a:eq(1)")
		var urlDemo = urlDemoDom && $(urlDemoDom).attr("href")
		var pageNum = 0;
		for (i = 0; i < allPage; i++) {
			pageNum =  1 + i * that.config.pageCount;
			that.pageList[ that.pageList.length] = urlDemo.replace(/--\d+-/ , '--' + pageNum + '-');
							
		}
		that.isPageInit = true;
		console.log(that.pageList);
	}


	//返回的可调用变量
	return that;
})();