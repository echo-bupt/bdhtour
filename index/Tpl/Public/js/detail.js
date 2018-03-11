$(function()
{
	var obj=$(".img_list img")
	var len=obj.length;
	for(var i=0;i<len;i++)
	{
		obj.eq(i).click(function()
		{
			var src=$(this).attr("src");
			$("#big").attr("src",src);
			return false;
		})
	}
})