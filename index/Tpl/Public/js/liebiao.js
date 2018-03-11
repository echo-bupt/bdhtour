$(function()
{

	var tag=$(".tag-filter li").length;
	var ktag=$(".tag-filters li").length;
	for(var i=0;i<tag;i++)
	{
		$(".tag-filter li a").eq(i).click(function()
		{
			$(".tag-filter li a").removeClass();
			$(this).addClass("selected");
			var aid=$(this).attr("aid");
			var htype=$(".container").attr("htype")?$(".container").attr("htype"):1;
			$.post(app+"/index/getHotel",{"aid":aid,"lei":2,"htype":htype},function(data)
			{
				$(".container").html(data);
			})
		})
	}
			for(var i=0;i<ktag;i++)
	{
		$(".tag-filters li a").eq(i).click(function()
		{
			alert(1);
			$(".tag-filters li a").removeClass();
			$(this).addClass("selected");
			var aid=$(this).attr("aid");
			var htype=$(".container").attr("htype")?$(".container").attr("htype"):1;
			$.post(app+"/index/getTicket",{"aid":aid,"lei":2,"htype":htype},function(data)
			{
				$(".container").html(data);
			})
			})
	}
})