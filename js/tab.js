$(document).ready(function() {
	// 預設顯示第一個 Tab (level 1)
	var _showTab = 0;
	$('ul.tabs li').eq(_showTab).addClass('active');
	$('.tab_content').hide().eq(_showTab).show();

	// 當 li 頁籤被點擊時...
	// 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
	$('ul.tabs li').click(function() {
		// 找出 li 中的超連結 href(#id)
		var $this = $(this),
			_clickTab = $this.find('a').attr('href');
		// 把目前點擊到的 li 頁籤加上 .active
		// 並把兄弟元素中有 .active 的都移除 class
		$this.addClass('active').siblings('.active').removeClass('active');
		// 淡入相對應的內容並隱藏兄弟元素
		$(_clickTab).stop(false, true).fadeIn().siblings().hide();

		return false;
	}).find('a').focus(function(){
		this.blur();
	});

	// 預設顯示第一個 Tab (Level 2-1)
	var _showTab = 0;
	$('ul.tabs2 li').eq(_showTab).addClass('active');
	$('.tab_content2').hide().eq(_showTab).show();

	// 當 li 頁籤被點擊時...
	// 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
	$('ul.tabs2 li').click(function() {
		// 找出 li 中的超連結 href(#id)
		var $this = $(this),
			_clickTab = $this.find('a').attr('href');
		// 把目前點擊到的 li 頁籤加上 .active
		// 並把兄弟元素中有 .active 的都移除 class
		$this.addClass('active').siblings('.active').removeClass('active');
		// 淡入相對應的內容並隱藏兄弟元素
		$(_clickTab).stop(false, true).fadeIn().siblings().hide();

		return false;
	}).find('a').focus(function(){
		this.blur();
	});

	// 預設顯示第一個 Tab (Level 2-2)
	var _showTab = 0;
	$('ul.tabs3 li').eq(_showTab).addClass('active');
	$('.tab_content3').hide().eq(_showTab).show();

	// 當 li 頁籤被點擊時...
	// 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
	$('ul.tabs3 li').click(function() {
		// 找出 li 中的超連結 href(#id)
		var $this = $(this),
			_clickTab = $this.find('a').attr('href');
		// 把目前點擊到的 li 頁籤加上 .active
		// 並把兄弟元素中有 .active 的都移除 class
		$this.addClass('active').siblings('.active').removeClass('active');
		// 淡入相對應的內容並隱藏兄弟元素
		$(_clickTab).stop(false, true).fadeIn().siblings().hide();

		return false;
	}).find('a').focus(function(){
		this.blur();
	});
});