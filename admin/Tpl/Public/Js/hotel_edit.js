$(function()
{
	var roomBtn=$("#roomBtn").val();
	if(roomBtn==1)
	{
		$("#room").css("display","block");
	}
	$("#addDiv").find(".btn").css("display","none").eq(0).css("display","inline-block");
	$("#addBtn0").live("click",function()
	{
		$("#room").clone(true).css("display","block").appendTo("#addDiv");
	})
		$("#rBtn").live("click",function()
	{
		$("#room").clone(true).css("display","block").appendTo("#addDiv");
	})
})