<?PHP
if(isset($_SESSION[$key_login_admin]) or isset($_COOKIE[$key_login_admin])){
	if(isset($_SESSION[$key_login_admin])){
		$admin_id = $_SESSION[$key_login_admin];
		$code_secret = $_SESSION[$key_login_code];
	}else{
		$admin_id = $_COOKIE[$key_login_admin];
		$code_secret = $_COOKIE[$key_login_code];
	}
	$admin_id = abs((int)$admin_id);
	$admin_id = htmlentities($admin_id);
	$data_admin = $db->fetch("select name,username,email,image,code_secret,level,user_id from admin where id='$admin_id'");
	if(isset($data_admin['code_secret'])){
		$code_secret_db = md5(md5("$admin_id:$data_admin[code_secret]"));
		$admin_email = $data_admin['email'];
		$admin_username = $data_admin['username'];
		$admin_name = $data_admin['name'];
		$admin_image = $data_admin['image'];
		$admin_level = $data_admin['level'];
		$admin_user_id = $data_admin['user_id'];
		
		if($code_secret!=$code_secret_db){
			header("location:$c_url/logout.php");
			exit;
		}
		if($admin_level==1){
			$admin_level_name = "Administrator";
		}else if($admin_level==2){
			$admin_level_name = "Customer Service";
		}else if($admin_level==3){
			$admin_level_name = "Manajemen";
		}else if($admin_level==4){
			$admin_level_name = "Keuangan";
		}else if($admin_level==5){
			$admin_level_name = "Enginer";
		}else if($admin_level==6){
			$admin_level_name = "Marketing";
		}
	}else{
		//header("location:$c_url/logout.php");
		echo "Sepertinya ada kesalahan saat mengambil data ke database, coba refresh halaman ini :)";
	}
}else{
	header("location:$c_url/?e=3");
}
?>