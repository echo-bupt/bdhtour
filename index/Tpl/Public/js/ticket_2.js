$(function()
{
	//默认一张成人票.
	var tag=$(".jia").length;
	for(var i=0;i<tag;i++)
	{
		$(".jia").eq(i).click(function()
		{
			var count=$(this).next().text();
			var val=parseInt($(this).prev().children("input").val());
			var price=parseInt($(".price").eq(count).text());
			var total=parseInt($("#total_p").text());
			$(this).prev().children("input").val('');
			$(this).prev().children("input").val(val+1);
			$("#total_p").text(total+price);
			$("#total_p1").val(total+price);
		})
		$(".jian").eq(i).click(function()
		{
			var count=$(this).next().text();
			var obj=$(this).next().next().children("input");
			var val=parseInt(obj.val());
			var price=parseInt($(".price").eq(count).text());
			var total=parseInt($("#total_p").text());
			if(val==0)
			{
				obj.val(0);
			}else{
				obj.val('');
				obj.val(val-1);
				$("#total_p").text(total-price);
				$("#total_p1").val(total-price);
			}

		})
	}
	$(".b_sub").click(function()
	{
		var txt=$("#uname").val();
		var tel=$("#tel").val();
		var idnum=$("#idnum").val();
		var re=/^(1[0-9]{10})$/;
		var isIDCard=/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/; 
		if(txt=="")
		{
			alert("取票人姓名不得为空!");
			return false;
		}
		if(!re.test(tel))
		{
			alert("请输入合适的手机号!");
			return false;
		}
		if(!isIDCard.test(idnum))
		{
			alert("请输入合法的身份证号");
			return false;
		}
		return true;
	})
})