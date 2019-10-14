<?PHP
SESSION_START();
$api_url = "http://localhost/2019/bukakios/api.bukakios.net";
$apps_url = "https://apps.bukakios.net";
$notif_url = "http://notif.bukakios.net";
$assets_url = "http://localhost/2019/bukakios/assets.bukakios.net";
$api_delete_cache = "$api_url/delete_cache";
$api_key = "77e2edcc9b40441200e31dc57dbb8829";
$api_limit = 10;
$c_limit = 30;
$c_url = "http://localhost/2019/bukakios/admin.bukakios.net";
$c_name = "Admin BukaKios";
$key_login_admin = "admin_login_bukakios";
$key_login_code = "admin_login_bukakios_kode";
define('ROOT', dirname(__FILE__));
define('FILE_PUT_CONTENTS_ATOMIC_TEMP ', 0777);
define('_FCM_KEY', 'AAAAp8StuRI:APA91bF8eKi2LmdKGixmyKZHb_8_K6_a9ATTS_rHUmNMsqjxFftxiG0SoAZ6wY-wwfZ24QfV4hCZyrK3G7BHSFxiUFU76H-cemAkMYkgWnBF9vCpsF5xKHaR4s3d-xEXLLOfmDfwkeCd');
$fcm_key = _FCM_KEY;
$my_cache_folder = ROOT."/cache";
require_once("core/app.class.php");
$app=new App();
$today = date("Y-m-d");
$now = date("H:i:s");
date_default_timezone_set("Asia/Jakarta");
if(isset($auto_connect) and $auto_connect==1){
	require_once("config_db.php");
}

/*
API FOR TRANSACTION HERE
*/
$buy_api_url = "http://javah2h.bukakios.net/v2";
$buy_api_key = "a767116de8cd7691f2c3a3d7379691b5";
$ppop_api_url = "http://ppob.bukakios.net/v2";
$ppop_api_key = "-";
$jab_url = "http://localhost/2019/bukakios/jab.bukakios.net";
$jab_key = "a284df1155ec3e67286080500df36a9a";

$today = date("Y-m-d");
$now = date("H:i:s");

//other
$slack_token = "xoxp-652786859216-654616736791-685666921141-abba2731685ccc3f74ac499e0cd21fc1";

//user approvel
$user_approvel = array(1,2,6,7); //dewa,angga,lilis,imam
?>