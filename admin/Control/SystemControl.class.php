<?php
class SystemControl extends CommonControl{
	function web_set()
	{
		//删除temp文件夹:
		$pathIndex=ROOT_PATH."index/temp";
		$pathAdmin=ROOT_PATH."admin/temp";
		$Ires=$this->delAllFiles($pathIndex);
		$Ares=$this->delAllFiles($pathAdmin);
		$this->success("已清除所有缓存内容!");
	}
	function delAllFiles($path,$type='')
	{
    //组合适应于 文件\*的路径格式。
    $patten=$path."\\*";
    $file=glob($patten);
    foreach ($file as $k => $v) {
        if($type!='')
        {
            if(is_dir($v))
            {
                $this->delAllFiles($v,$type);
                rmdir($v);
            }elseif(strrchr($v, '.')==$type && !is_dir($v))
            {
                @unlink($v);
            }
        }else{
            //删除所有文件。
            if(is_dir($v))
            {
                $this->delAllFiles($v,$type);
                //如果是文件夹遍历删除里面的所有文件后再去删除该文件夹。
                rmdir($v);
            }else{
                @unlink($v);
            }
        }
    }
    return true;
}
}

?>