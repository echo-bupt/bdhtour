<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?>    <div id="footer">

      <div id="footer_content">

        <div class="biao">

          <div class="theme-logo">

          <strong>BeiDaihe</strong>travel

        </div>

        <p>北戴河宾馆酒店在线订房网隶属于秦皇岛市嘉程旅游服务有限责任公司.</p>

        <p>是一家专业提供秦皇岛宾馆酒店，北戴河宾馆酒店，南戴河宾馆酒店，昌黎黄金海岸宾馆酒店在线预订和网上出票的平台</p>

        </div>

        <div class="contact">

          <h3>联系我们</h3>

        <ul>

          <li class="glyph-home">

            河北省秦皇岛市

            <br>

            海港区文化路134号

          </li>

          <li class="glyph-briefcase">Phone : 0335-7922911</li>

          <li class="glyph-envelope">Email : wwg19@163.com</li>

        </ul>

        </div>

        <div class="img">

          <img src="http://localhost/bdhtour/./index/Tpl/Public/images/notice.png"/>

        </div>

      <div class="article">
        <ul>
          <?php if(is_array($article)):?><?php  foreach($article as $v){ ?>
          <li><span class="circle"></span><a href="http://localhost/bdhtour/index.php/index/artail/?aid=<?php echo $v['aid'];?>"><?php echo $v['title'];?></a></li>
         <?php }?><?php endif;?>
        </ul>
      </div>

      </div>

      <div class="notice">

        <p class="p1"> 版权：北戴河宾馆酒店在线订房网 Copyright 2005-2017 Corporation, All Rights Reserved<span>备案序号：冀ICP备15013003号-1</span>

        </p>

<p class="p2">订房热线：183-0335-9123</p>

      </div>



    </div>