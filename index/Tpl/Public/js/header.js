window.onload=function()
{
var oUl=document.getElementById("center").getElementsByTagName("ul")[0];
  var aLi=document.getElementById("center").getElementsByTagName("li");
  var oneSize=aLi[0].offsetWidth;
  var iNow=0;
  var iNow2=0;
  function fixUl()
  {
      oUl.style.width=aLi.length*oneSize+"px";
  }
  fixUl();
  //点击:
  
  
  //定时器:
  function autoMove()
  {
      iNow++;//这是控制className自动运动的！因为iNow2与iNow不同，iNow2需要继续++,而不是将其拉回！
      if(iNow==aLi.length)
          {
              iNow=0;
              aLi[0].style.position="relative";
              aLi[0].style.left=aLi.length*oneSize+"px";//注意这是相当于ul的left值！！是正的！！
          }
          iNow2++;
          miaovStartMove(oUl,{left:-iNow2*oneSize},MIAOV_MOVE_TYPE.BUFFER,function()
  {
      if(iNow==0)
          {
              //还原，进行完缓冲运动后要进行还原！
               aLi[0].style.position="static";
               iNow2=0;
               oUl.style.left=0;
          }
  }    
  )
          
      
 $(function()
{
	$("#search").click(function()
	{
		$(this).val('');
	})
})    
  }
 // var timer=setInterval(autoMove,6000);
}
