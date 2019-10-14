<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
if(!isset($_SESSION['sudo'])){
	echo "<h1>ACCESS FORBIDDEN!!";
	exit;
}
//cek sudah login?
if(isset($_SESSION[$key_login_admin]) or isset($_COOKIE[$key_login_admin])){
	require_once("_/session_cookie_index_cek.php");
}
if(isset($_POST['email'],$_POST['csrf'])){
	$keep = "off";
	if(isset($_POST['keep'])){
		echo $keep = $_POST['keep'];
	}
	$csrf = $_POST['csrf'];
    $email = $db->escape_string($_POST['email']);
    $pw_string = $_POST['password'];
    $password = md5(md5($pw_string));
    $pw_salt = sha1(md5($pw_string));
    $pw_hash = md5($pw_string.$pw_salt); //hashing pw baru
	$data = $db->fetch("select id,code_secret,level from admin where (email='$email' or username='$email') and password='$pw_hash'");
	if(isset($data['id'])){
        //login success
        $role = 'role';
        $admin_id = $data['id'];
        $level = $data['level'];
		$code_secret = $data['code_secret'];
		$code_login = md5(md5("$admin_id:$code_secret"));
		if($keep=="on"){
			//login pake cookies
			setcookie($key_login_admin, $admin_id, time() + (86400 * 30), "/"); //login 30 hari
            setcookie($key_login_code, $code_login,  time() + (86400 * 30), "/"); 
            setcookie($role, $level, time() + (86400 * 30), "/"); //login 30 hari
		}else{
			//login pake session
			$_SESSION[$key_login_admin] = $admin_id;
            $_SESSION[$key_login_code] = $code_login;
            $_SESSION['role'] = $level;
        }
        // echo "cookie : ".$_COOKIE['role'];;
        // echo "<br/>session : ".$_SESSION['role'];;
		header("location:$c_url/home3.php?s=1");
	}else{
		//login failed
		header("location:$c_url/?e=1");
	}
	exit;
}else{
	$csrf = $app->csrf();
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?PHP echo "Login - $c_name"; ?></title>
	<link href="img/favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" href="css/separate/pages/login.min.css">
    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box" method='post' action=''>
                    <div class="sign-avatar">
                        <img src="img/avatar-sign.png" alt="">
                    </div>
                    <header class="sign-title">Sign In</header>
					<?PHP 
					if(isset($_GET['e'])){
						$e = $_GET['e'];
						if($e==1){
							echo "<div class='alert alert-danger'>Email atau password salah!!</div>";
						}
					}
					?>
                    <div class="form-group">
                        <input name='email' type="text" class="form-control" placeholder="E-Mail or Username"/>
                    </div>
                    <div class="form-group">
                        <input name='password' type="password" class="form-control" placeholder='Password'/>
                    </div>
                    <div class="form-group">
                        <div class="checkbox float-left">
                            <input type="checkbox" name='keep' id="signed-in"/>
                            <label for="signed-in">Keep me signed in</label>
                        </div>
                    </div>
					<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
                    <button type="submit" class="btn btn-rounded">Sign in</button>
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </form>
            </div>
        </div>
    </div><!--.page-center-->


<script src="js/lib/jquery/jquery-3.2.1.min.js"></script>
<script src="js/lib/popper/popper.min.js"></script>
<script src="js/lib/tether/tether.min.js"></script>
<script src="js/lib/bootstrap/bootstrap.min.js"></script>
<script src="js/plugins.js"></script>
    <script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="js/app.js"></script>
</body>
</html>