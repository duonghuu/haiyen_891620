<?php if(!defined('_lib')) die("Error");

	function info_user($id)
	{
		global $d;		
		$sql = "select * from #_user where id='".$id."'";
		$d->query($sql);
		$item = $d->fetch_array();
		return $item;
	}
	
	function logout(){	
		global $login_name,$config_url_ssl;
		unset($_SESSION[$login_name]);
		unset($_SESSION['login']);
		transfer(_dangxuatthanhcong, $config_url_ssl);
	}
?>