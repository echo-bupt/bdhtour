$(function()
	{
	var tag=$(".tag-filter li").length;
	var ktag=$(".tag-filterd li").length;
	for(var i=0;i<=tag;i++)
	{
		$(".tag-filter li a").eq(i).click(function()
		{
			$(".tag-filter li a").removeClass();
			$(this).addClass("selected");
			var aid=$(this).attr("aid");
			$.post(app+"/index/getHotel",{"aid":aid},function(data)
			{
				$(".tag-filter-container").html(data);
			})
		})
	}
		for(var i=0;i<=ktag;i++)
	{
		$(".tag-filterd li a").eq(i).click(function()
		{
			$(".tag-filterd li a").removeClass();
			$(this).addClass("selected");
			var aid=$(this).attr("aid");
			$.post(app+"/index/getTicket",{"aid":aid},function(data)
			{
				$(".jingdian_list").html(data);
			})
			})
	}

})
