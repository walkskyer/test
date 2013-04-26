//存放用于各个js文件或函数间的数据交流
var globalTool = {
	siteTool: [jingDong, paiPai, taoBao],
	pageInit: false,
	productDone: 0, //用于记录完成数据初始化的网站个数
	productList: [], //未经处理的所有产品
	goodProductList: [], //价格合理的产品
	badProductList: [], //价格偏差过大的产品
	searchName: '', //价格偏差过大的产品
	productAllData: {
		avgGoodPrice: 0,
		avgPrice: 0
	},
	/**
	 *统计信息
	 */
	oneDone: function(productList) {
		//将产品添加到总产品中
		for (var i = 0; i < productList.length; i++) {
			this.productList[this.productList.length] = productList[i];
		}
		this.productDone++;

		if (this.productDone == this.siteTool.length) {
			searchDone();
		}
	},
	//翻页重置
	pageRest: function() {
		this.productDone = 0;
		this.productList = [];
		this.goodProductList = [];
		this.badProductList = [];
		productAllData = {
			avgGoodPrice: 0,
			avgPrice: 0
		};
		for (i = 0; i < this.siteTool.length; i++) {
			this.siteTool[i].pageReset();
		}
	},
	/**
	 * 重新搜索重置状态
	 */
	reset: function() {
		this.productDone = 0;
		this.productList = [];
		this.goodProductList = [];
		this.badProductList = [];
		this.pageInit = false;
		productAllData = {
			avgGoodPrice: 0,
			avgPrice: 0
		};
		for (i = 0; i < this.siteTool.length; i++) {
			this.siteTool[i].reset();
		}
	}

}

/**
 * 搜索事件
 */
function search() {
	globalTool.reset(); //重置信息
	searchStr = $("#proudctText").val();
	blank.show();
	globalTool.searchName = searchStr;

	for (i = 0; i < globalTool.siteTool.length; i++) {
		globalTool.siteTool[i].searchBegin(searchStr);
	}

}
/**
 * 搜索完成时执行操作
 */
function searchDone() {
	if (!globalTool.pageInit) {
		pageInit();
	}
	calculate();
	//排序
	globalTool.goodProductList.sort(function(a, b) {
		if (a.price === b.price) {
			return 0;
		} else {
			return   a.price > b.price ? 1 : -1;
		}
	});
	blank.hide();
	//样式转变
	$(".header").animate({
		margin: 0,
		padding: 0
	}, 300, 'swing', showProduct);


}

function goToPage(page) {
	$(".productList").html("");
	globalTool.pageRest();
	blank.show();
	for (i = 0; i < globalTool.siteTool.length; i++) {
		 globalTool.siteTool[i].goToPage(page);
	}
}


function pageInit() {
	var maxPage = 1;
	for (i = 0; i < globalTool.siteTool.length; i++) {
		if (globalTool.siteTool[i].pageList.length > maxPage) {
			maxPage = globalTool.siteTool[i].pageList.length;
		}
	}

	var pageDom = $(".page");
	$(pageDom).find('.pageInfo em').html(maxPage);

	var selectHtml = "";
	for (i = 0; i < maxPage; i++) {
		selectHtml += "<option>" + (i + 1) + "</option>";
	}

	$(pageDom).find('select').html(selectHtml);
	globalTool.pageInit = true;
}



/**
 * 计算各项数据和淘汰偏移数据
 */
function calculate() {
	var avgPrice = 0; //平均价格
	var allowShift = 0.7; //允许偏移价格比
	var allPrice = 0; //全部价格
	var avgGoodPrice = 0 //正常产品的平均价

	for (var i in globalTool.productList) {
		allPrice += globalTool.productList[i].price;
	}
	avgPrice = allPrice / globalTool.productList.length;

	for (var i in globalTool.productList) {
		if (Math.abs((globalTool.productList[i].price - avgPrice) / avgPrice) < allowShift) {
			globalTool.goodProductList[globalTool.goodProductList.length] = globalTool.productList[i];
		} else {
			globalTool.badProductList[globalTool.badProductList.length] = globalTool.productList[i];
			allPrice -= globalTool.productList[i].price;
		}
	}

	avgGoodPrice = allPrice / globalTool.goodProductList.length;

	//log(avgGoodPrice);
	globalTool.productAllData.avgGoodPrice = avgGoodPrice;
	globalTool.productAllData.avgPrice = avgPrice;
}

/**
 * searchDone后，加载商品到页面
 */
function showProduct() {
	var allCount = globalTool.goodProductList.length + globalTool.badProductList.length;
	var goodCount = globalTool.goodProductList.length;
	var badCount = globalTool.badProductList.length;
	var avgAllCount = '￥' + globalTool.productAllData.avgPrice.toFixed(2);

	$('.searchReslut .reslutAllCount').html(allCount)
	//$('.searchReslut .reslutGoodCount').html(goodCount)
	//$('.searchReslut .reslutBadCount').html(badCount)
	$('.searchReslut .reslutAvgAllCount').html(avgAllCount)

	$('.footer').show();
	$('.productContent').show();
	$('.searchReslut').show();

	var productDomList = '';
	for (var i in globalTool.goodProductList) {
		productDomList += productTemple(globalTool.goodProductList[i], 'goodProduct');
	}

	for (var i in globalTool.badProductList) {
		productDomList += productTemple(globalTool.badProductList[i], 'badProduct hide');
	}
	$('.productList').html(productDomList);
	filtProduct();
}



/**
 * 生成产品的样本
 * 用于生成产品dom
 */
function productTemple(product, productType) {
	var temple = $('#productTemple').html();
	var reslut = temple.replace('#name#', product.name)
					.replace(/#url#/g, product.url)
					.replace('#siteUrl#', product.siteUrl)
					.replace('#img#', product.img)
					.replace('#from#', product.from)
					.replace('#productType#', productType)
					.replace('#price#', product.price.toFixed(2));

	return reslut;
}


/**
 * 过滤搜索的结果
 */
function filtProduct() {
	var chooseSiteDom = null;
	var siteName = $(this).html();

	if (!siteName) {//不是鼠标点击事件
		chooseSiteDom = $('.reslutFilt:eq(0)')
		siteName = $(chooseSiteDom).html();
	} else {//鼠标点击事件
		chooseSiteDom = this;
	}


	if ($(chooseSiteDom).css('color') == 'black') {
		return;
	}

	$('.reslutFilt').css('color', '#0033cc');
	$(chooseSiteDom).css('color', 'black');

	$('.product').hide();

	switch (siteName) {
		case '全部':
			$('.product').show();
			break;
		case '过滤':
			$('.goodProduct').show();
			break;
		default:
			$('.product').each(function() {
				if ($(this).find('.productFrom a').html() == siteName) {
					$(this).show();
				}
			})
			break;
	}

}

/**
 * 初始化事件
 */
$(function() {
	$('#searchButton').click(search);
	blank.init();
	blank.setContent('<img src="./img/loading.gif" />');
	$('.reslutFilt').click(filtProduct);
	$('#proudctText').keydown(function(event) {
		if (event.keyCode == 13) {
			search();
		}

	});

	$(".page select").change(function() {
		goToPage(this.value);
	});

})

//弹出框
var blank = start_blank({
	id: "popBlank",
	title: "加载中...",
	width: 90,
	height: 90,
	//"isBlur: true,
	isDrag: true,
	noShadow: false,
	banClose: true
});

/**
 * 调试用
 */
function log(obj) {
	console.log(obj);
}