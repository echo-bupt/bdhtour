<?php
class CommonControl extends Control{
	function getArticle()
	{
		 $data=M("article")->order("time desc")->limit(5)->all();
		 return $data;
	}
}


?>