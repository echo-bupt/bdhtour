<?php
require_once "Global.function.php";
class Session {
	
	private $lifetime		= 1800;

	private $session_name	= '';

	private $session_id		= '';

	private $session_time	= '';

	private $session_md5	= '';

	private $time			= "";

	private $initdata		= array();
	/** 
	 *
	 *  构造函数
	 *
	 */
//保证cookie里面存储的sessionid是唯一的，这样就防止网络将sessionid劫持。第一次我们得到这个sessionid。以后的访问如果sessionid被劫持，那么在访问其他页面的时候要动态检测的，要根据客户端的浏览器等等这些信息进行动态与提交的sessionid进行验证，如果变化了ip或者浏览器。将重新生成sessionid这样就不会访问到我们用户的session数据了。

	//一开始我们对session的初步处理。这里是采用自助控制session的形式。
	function __construct($session_name = 'sess',$session_id = '',$lifetime = 1800) {
		$GLOBALS['_session'] = array();
		$this->session_name = $session_name;
		$this->lifetime		= $lifetime;
		$this->_time  = time();
		$tmpsess_id = '';
		if($session_id) {
			//先看用户有没有传递进来sessionid。如果没有传进来再去COOKIE取。
			//如果是第一次访问页面用户没有传递进来或者COOKIE里面没有，那么就去gene_session_id()生成session的name(sessionid)，然后将session的name(sessionid)存进数据库。
			$tmpsess_id = $session_id;
		} else {

			//我们存在cookie里面的是32位MD5加密数据与32位循环码连接而成。

			//1,,,cookie的存活时间多长对吧。
			//得到对应于session数据的session名称。也是浏览器携带的cookie用于保存session名称。
			p($_COOKIE);
			$tmpsess_id = cgetcookie($session_name);
			p($_COOKIE);

			echo "cookie.</br>";
			echo $tmpsess_id;
			echo "</br>";
		}
		//如果从cookie中取到了进行验证，验证通过将session的name定值为前32位。
		//主要也是为了防止用户传入的不是32位。我们自身从cookie里面取到的一般都是32位。
		//另外拿到cookie信息后，为了防止其他劫持该COOKIE数据进而去请求，这里进行验证，保证一个客户端用户唯一。verify函数起的作用。
		//确认无误后将值赋给$this->session_id来请求数据。
		if($tmpsess_id && $this->verify($tmpsess_id)) {
			//md5会生成32位的，，，所以这里我们从32截取，只为了验证CRC32验证码。
			$this->session_id = substr($tmpsess_id,0,32);
		}
		ECHO $this->session_id."</br>";

		if($this->session_id) {
			//如何借助唯一的标识读取session数据。
			$this->read_session();

		} else {
			//我们去看他是如何存储的$tmpsess_id 。
			//session_id 不存在,生成，写入到cookie
			//就是一个32位的唯一的id。
			$this->session_id = $this->gene_session_id();
			echo "new cookie.</br>";
			$this->init_session();
			//存入到cookie的是sessionid+(ip，客户端+sessionid的32位循环码)。
			echo "here we set the new cookie".$this->session_id."</br>";
			//这里sessionid的对应值是
			echo $this->session_id.$this->gene_salt($this->session_id);
			
			csetcookie($this->session_name,$this->session_id.$this->gene_salt($this->session_id));
		}
		//当脚本执行完后执行该函数。是index.php整个页面，而不是session这个类。
		//在new该类时该条语句生效。
		register_shutdown_function(array(&$this, 'gc'));
	}

	/**
	 *
	 * DB中insert新的session
	 *
	 */
	private function init_session() {
/*		DB::getDB()->insert("session",array("session_id"=>$this->session_id,"session_data"=>serialize(array()),'time'=>$this->_time));*/
		$data=array("session_id"=>$this->session_id,"session_data"=>"","time"=>$this->_time);
		M("session")->add($data);
	}
	
	/**
	 *
	 * 生成session_id
	 *
	 */
	private function gene_session_id() {
		$id = strval(time());  //相当于是把数字转换为字符串，获得变量的字符串值。
		while(strlen($id) < 32) {
			$id .= mt_rand();
		}
		//生成一个唯一的id，$id是相当于前缀。得到一个唯一的sessionid标识。
		return md5(uniqid($id,true));
	}
	
	/**
	 *
	 * 生成salt,验证
	 *
	 */
	private function gene_salt($session_id) {
		$ip = getClientIp();
		//生成str的 32 位循环冗余校验码多项式。这通常用于检查传输的数据是否完整。
		//验证唯一性。
		$res= sprintf("%8u",crc32(ROOT_PATH.(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"").$ip.$session_id));
/*		var_dump(SITEPATH.$_SERVER['HTTP_USER_AGENT'],$ip,$res);
		exit();*/
		return $res;
	}
	
	/**
	 *
	 * 生成salt,验证
	 *
	 */
	//我们验证的仅仅是后面部分的32位循环校正码。sessionid如果被截取了肯定是一样的啊!!
	private function verify($tmpsess_id) {
		// var_dump(substr($tmpsess_id,32));
		//将取出来的sessionname的32位后面的也就是客户端+ip+sessionid生成的32为循环码唯一标识码。
		return substr($tmpsess_id,32) == $this->gene_salt(substr($tmpsess_id,0,32));
	}
	
	/**
	 *
	 * 读出已知session
	 *
	 */

	//只要是第二次访问能从cookie里面得到sessionid便可会走这个函数，读取session数据交给globals变量存储以及供其他使用。以及更新$this->session_md5		= md5('a:0:{}');
	//$this->session_time		= 0;

	//相当于是必须先走read_session他才会设置$GLOBALS['_SESSION']
	private function read_session() {
		//将$GLOBALS['_SESSION']赋值为array之后，就相当于开启了SESSION。
		// $session = DB::getDB()->selectrow("session","*","session_id = '".$this->session_id."'");
		$session=M("session")->where(array("session_id"=>$this->session_id))->find();
		echo "content";
		p($session);
		if(empty($session)) { //session为空,
			$this->init_session();	
			$this->session_md5		= md5('a:0:{}');
			$this->session_time		= 0;
			$GLOBALS['_SESSION']	= array();
		} else { 
			//存储session的时间+session的存活时间<当前时间，表示未过期。
			//前面csetcookie的时候，是将携带session的cookie的存活时间设置为0，这样浏览器关闭后就会失效。
			//这是模拟了session的回话机制。这里$this->lifetime是模仿了session的生命周期。当session数据未过期时从数据库读取session数据，并且将数据存入到$GLOBALS全局变量中。将数据库数据存到全局变量中，实现类似session数据的功能。
			if(!empty($session['session_data'])  && $session['time']  > $this->_time - $this->lifetime) {
				//存储这两个是为了更新session的时候看看数据是否有变化以及session的time是不是离现在的time()差很多。在write_session函数里面会用得到。
				$this->session_md5		= md5($session['session_data']);
				$this->session_time		= $session['time'];
				//即使$GLOBALS['_SESSION']是一个序列化后的内容打印结果也是空，，因为序列化的是一个空数组!!!


				//保证session数据是从数据库读取的!!!!
				$GLOBALS['_SESSION']    = $session['session_data'];
			} else { //session过期
				$this->session_md5		= md5("");
				$this->session_time		= 0;
				$GLOBALS['_SESSION']	= "";
			}
		}
	}
	
	/**
	 *
	 * 更新session
	 *
	 */
	public function write_session() {
		//a:0:{}  这是序列化空数组后的结果。
		//将数据与time同时更新。
		p($GLOBALS['_SESSION']);
		$data = !empty($GLOBALS['_SESSION'])?$GLOBALS['_SESSION']['adname']:"";
		$this->_time = time();
		
		//session未变化,这个前提是先读取了session，也就是sessionid已经存在而不是我们第一次写入sessionid。
/*		var_dump($this->session_md5);
		var_dump(md5($data));*/
		if(md5($data) == $this->session_md5 && $this->_time - $this->session_time < 10 ) {
			// echo "用户10s内刷新的很快不需要调用更新,不需要进行更新操作。";
			return true;
		}
		//上面表示session里面的数据没有发生变化，并且session刚存入不久!!!!!比如用户第一次访问，那么刚刚写入session时间很多根本不需要更新。


/*

1,,在不是第一次访问，也就是有sessionid的情况下，，每一次都会走readsession目的是看看session有没有过期，如果session过期就将数据清空!也就是将GLOBALS[_SESSION]置为空。但是这并不影响我们往session里面存数据(也就是说存入session的数据并不是为空了)，因为脚本结束后我们会走write_session，会将data数据从globalS重新获取一下更新到数据库。但是如果我们后面没有往session里面存数据自然就被更新为空了。。


2，，write_session如果session数据没有发生变化，，并且是用户在短时间内刷新，那么就不去update数据。如果长时间内或者数据已经改变(这个就是与read_session读来的数据进行比较得知了)，那么就去更新。。更新时间的目的也是为了维持持续性登陆。只要用户在操作，就去更新time，这样在每一次走readsession的时候不会说是session已经过期了!@@!!

3,,,利用GLOBALS【—_SEESION】做到了不用在服务器段存储session。利用cookie来保证sessionid的传输。利用session类里面的lifetime来确保session的存活时间!!!

4,,我们读取session是直接从GLOBALS里面读取，，没有走数据库里面的内容吧???还是说我们在readsessiion的时候将数据库存储的session数据复制给了GLOBALS，直接从GLOBALS里面读不行么???测试一下


5,cookie中sessionid的存活期关系着我们session数据是否从数据库里面有效读取。????有效时间???












*/



		// echo '</br>here  we are goging to update session</br>';
		//这里是将我们的session数据更新到数据库中去!!!!每一次脚本结束的时候都会去更新一下!!
/*		$ret = DB::getDB()->update("session",array("time"=>$this->_time,"session_data"=>addslashes($data)),"session_id='".$this->session_id."'",true);
*/		
$data=array("time"=>$this->_time,"session_data"=>$data);
	$ret=M("session")->where(array("session_id"=>$this->session_id))->update($data);
	return $ret;
	}
	
	/**
	 *
	 * 执行gc
	 *
	 */
	public function gc() {
		//每一次访问页面都会去更新session数据以及以一定的概率去垃圾回收过期文件。
		$this->write_session();
/*		if($this->_time % 2 == 0) {
			DB::getDB()->delete("session","time<".($this->_time - $this->lifetime));
		}*/
		return true;
	}

}
