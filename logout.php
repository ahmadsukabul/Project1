<?PHP
require_once("config.php");
unset($_SESSION[$key_login_admin]);
if (isset($_COOKIE[$key_login_admin])) {
    unset($_COOKIE[$key_login_admin]);
    setcookie($key_login_admin, "0", time() - 3600, '/');
    //return true;
}
header("location:$c_url/?e=2");
?>