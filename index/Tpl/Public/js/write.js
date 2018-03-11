$(function()
{
	getDay();
	//当选择离开时:
	
	$("#updatetime").click(function()
	{
		update();
	})
		$("#updatetime2").click(function()
	{
		update();
	})
		$("#jia").click(function()
		{
			var price_ping=parseInt($("#price_ping").val());
			var price_mo=parseInt($("#price_mo").val());
			var date1=$("#updatetime").val();
			var date2=$("#updatetime2").val();
			var date_1=convertTimes(date1);
			var date_2=convertTimes(date2);
			var num=(date_2-date_1)/(24*3600*1000);
			var res=getWeek(date1,num);
		    var totalpricePer=res[0]*price_mo+res[1]*price_ping;
			var yuan=parseInt($("#ding").text());
			$("#ding").text("");
			$("#ding").text(yuan+parseInt(1));
			$("#dingNum").val(yuan+parseInt(1));
			$("#priceall").text(totalpricePer*(yuan+parseInt(1)));
			$("#total_price").val(totalpricePer*(yuan+parseInt(1)));
			$("#name").clone(true).css("display","block").appendTo($("#room_name"));
			if($(".name").length>yuan+parseInt(1))
			{
				$(".name").last().remove();
			}
		})
		$("#jian").click(function()
		{
			var price_ping=parseInt($("#price_ping").val());
			var price_mo=parseInt($("#price_mo").val());
			var date1=$("#updatetime").val();
			var date2=$("#updatetime2").val();
			var date_1=convertTimes(date1);
			var date_2=convertTimes(date2);
			var num=(date_2-date_1)/(24*3600*1000);
			var res=getWeek(date1,num);
		    var totalpricePer=res[0]*price_mo+res[1]*price_ping;
			var yuan=parseInt($("#ding").text());
			if(yuan==0)
			{
				$("#ding").text('0');
				$("#dingNum").val(0);
				$("#total_price").val(0);
			}else{
			$("#ding").text("");
			$("#ding").text(yuan-parseInt(1));
			$("#dingNum").val(yuan-parseInt(1));
			$("#priceall").text(totalpricePer*(yuan-parseInt(1)));
			$("#total_price").val(totalpricePer*(yuan-parseInt(1)));
		}
		if($(".name").length>=2)
		{
					$(".name").last().remove();
		}

		})

		//继续添加:
		$("#add").click(function()
		{
			$("#name").clone(true).css("display","block").appendTo($("#room_name"));
		})
		$(".sub").click(function()
		{
			var ss=$(".tel").val();
			var name=$(".ftname").val();
			if(name=='')
			{
				alert("请输入入住人姓名!");
				return false;
			}
			var re=/^(1[0-9]{10})$/;
			if(!re.test(ss))
			{
				alert("请输入合适的手机号!");
				return false;
			}
			return true;
		})
})
//根据日期 得到是星期几
function getWeekByDay(dayValue){ //dayValue=“2014-01-01”
 var day = new Date(Date.parse(dayValue.replace(/-/g, '/'))); //将日期值格式化
    var today = new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六"); //创建星期数组
    return today[day.getDay()];  //返一个星期中的某一天，其中0为星期日
}
function getDay()
{
	var price_ping=parseInt($("#price_ping").val());
	var price_mo=parseInt($("#price_mo").val());
	var date1=$("#updatetime").val();
	var date_1=convertTimes(date1);
	$("#week1").text(getWeekByDay(date1));
	var date2=$("#updatetime2").val();
	var date_2=convertTimes(date2);
	if(date_2>date_1)
	{
		var num=(date_2-date_1)/(24*3600*1000);
		$("#num").text(num);
		$("#days").val(num);
		var res=getWeek(date1,num);
		var totalpricePer=res[0]*price_mo+res[1]*price_ping;
		var nums=parseInt($("#ding").text());
		$("#priceall").text(totalpricePer*nums);
		$("#total_price").val(totalpricePer*nums);
	}
	
	$("#week2").text(getWeekByDay(date2));
}
function update()
{
	var obj=$(".lcui_border");
		obj.click(function()
		{
			var timer=setTimeout("getDay()",100);
		})

}
   function convertTimes( date ){  
        var date = date.split('-');  
        d = new Date();  
        d.setFullYear(date[0]);  
        d.setMonth(date[1]-1);  
        d.setDate(date[2]);  
        return Date.parse(d);  
    }  

function getWeek(first,num)
{
	var time=convertTimes(first);
	var week=new Array();
	week[0]=0;
	week[1]=0;
	for(var i=0;i<num;i++)
	{
		//必须经过daTE.parse函数实例化的对象才能 getDay();
		var dayTime = new Date(Date.parse(new Date(time)));
		var dayWeek=dayTime.getDay();
		time=time+3600*24*1000;
		if(dayWeek==5 || dayWeek==6)
		{
			++week[0]
		}else{
			++week[1];
		}
	}

	return week;
}