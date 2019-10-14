<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_REQUEST['act'])){
    $act = $_REQUEST['act'];
    require_once("_act/_setting.php");
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
	<title>Setting Akun - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php"); ?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	<div class="page-content">
    <div class="container-fluid">
			<div class='row'>
				<div class='col-md-12'>
                    <?PHP 
                    require_once("_/_alert_message.php");
                    ?>
                    <section class="card mb-3">
						<header class="card-header card-header-lg">
							Edit Akun
						</header>
						<form method='post' action='' class="card-block">
							<fieldset class="form-group">
								<label class="form-label" for="pulsa_nomor">Nama Lengkap *</label>
								<input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Saya" required="" value='<?PHP echo $admin_name; ?>'>
							</fieldset>
							<fieldset class="form-group">
								<label class="form-label" for="email">Email *</label>
								<input id="email" name="email" type="text" class="form-control" placeholder="Nama Saya" required="" value='<?PHP echo $admin_email; ?>'>
							</fieldset>
                            <input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
								<input type='hidden' name='act' value='setting_general'/>
							<button id='btn_simpan_general' onclick='btn_simpan_general()' class='btn btn-success'>Simpan</button>
						</form>
					</section>

                    <section class="card mb-3">
						<header class="card-header card-header-lg">
							Ganti Password
						</header>
						<form method='post' action='' class="card-block">
							<fieldset class="form-group">
								<label class="form-label" for="password_old">Password lama *</label>
								<input id="password_old" name="password_old" type="password" class="form-control" required=""/>
							</fieldset>
							<fieldset class="form-group">
								<label class="form-label" for="passowrd_new">Password Baru *</label>
								<input id="passowrd_new" name="passowrd_new" type="password" class="form-control" required=""/>
							</fieldset>

                            <fieldset class="form-group">
								<label class="form-label" for="passowrd_repeat">Ulangi Password Baru *</label>
								<input id="passowrd_repeat" name="passowrd_repeat" type="password" class="form-control" required=""/>
							</fieldset>
                            
                            <input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
						    <input type='hidden' name='act' value='setting_password'/>
							<button id='btn_simpan_password' onclick='btn_simpan_password()' class='btn btn-danger'>Ganti Password</button>
						</form>
					</section>
					
				</div>
			</div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
</body>
</html>
