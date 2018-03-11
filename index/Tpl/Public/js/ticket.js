$(function()
{
	getDay();
	//当选择离开时:
	
	$("#updatetime").click(function()
	{
		update();
	})
		$("#jia").click(function()
		{
			var price=parseInt($("#price").text());
			var yuan=parseInt($("#ding").val());
			$("#ding").val("");
			$("#ding").val(yuan+parseInt(1));
			$("#total_p").text(price*(yuan+parseInt(1)));

		})
		$("#jian").click(function()
		{
			var price=parseInt($("#price").text());
			var yuan=parseInt($("#ding").val());
			if(yuan==0)
			{
				$("#ding").text('0');
			}else{
			$("#ding").val("");
			$("#ding").val(yuan-parseInt(1));
			$("#total_p").text(price*(yuan-parseInt(1)));
		}
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
	var price=parseInt($("#price").text());
	var date1=$("#updatetime").val();
	var date_1=convertTimes(date1);
	$("#week1").text(getWeekByDay(date1));
	var nums=parseInt($("#ding").val());
	$("#priceall").text(price*nums);
	
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
		if(dayWeek==6 || dayWeek==0)
		{
			++week[0]
		}else{
			++week[1];
		}
	}

	return week;
}