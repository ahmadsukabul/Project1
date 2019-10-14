<?PHP
if(isset($_SESSION[$key_login_admin])){
	$admin_id = $_SESSION[$key_login_admin];
	$code_secret = $_SESSION[$key_login_code];
}else{
	$admin_id = $_COOKIE[$key_login_admin];
	$code_secret = $_COOKIE[$key_login_code];
}
$admin_id = abs($admin_id);
$admin_id = htmlentities($admin_id);
$data_admin = $db->fetch("select code_secret from admin where id='$admin_id'");
if(isset($data_admin['code_secret'])){
	$code_secret_db = md5(md5("$admin_id:$data_admin[code_secret]"));
	if($code_secret==$code_secret_db){
		header("location:$c_url/home.php?s=1");
	}else{
		
	}
}else{
	header("location:$c_url/logout.php");
}
?>