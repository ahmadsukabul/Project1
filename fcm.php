<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
//require_once("_/_session_level_1.php");
if(isset($_POST['act'])){
	require_once("_act/_fcm.php");
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
	<title>Kirim Notifikasi APP (FCM) - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
				<div class='col-md-12'>
					<?PHP
					if(isset($_GET['s'])){
						$s = $_GET['s'];
						if($s==1){
							echo "<div class='alert alert-success'>$_SESSION[success_msg]</div>";
						}
					}
					
					if(isset($_GET['e'])){
						$e = $_GET['e'];
						if($e==1){
							echo "<div class='alert alert-danger'>Gagal mengirim pesan!</div>";
						}
					}
					?>
					<section class="card card-red mb-3">
						<header class="card-header">
							Kirim Notifikasi ke hp pengguna (FCM)
						</header>
						<div class="card-block">
							<div class='alert alert-info'>
								Fitur ini di gunakan untuk memberi notif masal ke pengguna
							</div>
							<form action='' method='post'>
								<fieldset class="form-group">
									<label class="form-label">Tipe Pesan </label>
									<select class='form-control' name='tipe'>
										<option value=1>Teks saja</option>
										<option value=2>Teks dan icon</option>
										<option value=3>Teks, icon, dan large image</option>
									</select>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Judul Pesan </label>
									<input type='text' name='judul' class='form-control' required/>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Isi Pesan </label>
									<textarea required name='isi' class='form-control'></textarea>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Icon (optional) </label>
									<input type='text' name='icon' class='form-control'/>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Large Image (optional) </label>
									<input type='text' name='image' class='form-control'/>
								</fieldset>
								<input type='hidden' name='act' value='send_all'/>
								<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
								<button class='btn btn-success'>Kirim</button>
							</form>
						</div>
					</section>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Kirim Notifikasi hanya ke 1 pengguna saja
						</header>
						<div class="card-block">
							<div class='alert alert-info'>
								Fitur ini di gunakan untuk memberi notif hanya ke pengguna terterntu
							</div>
							<form action='' method='post'>
								<fieldset class="form-group">
									<label class="form-label">Masukan ID Pengguna * </label>
									<input type='text' name='uid' class='form-control' placeholder='12345' required/>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Tipe Pesan </label>
									<select class='form-control' name='tipe'>
										<option value=1>Teks saja</option>
										<option value=2>Teks dan icon</option>
										<option value=3>Teks, icon, dan large image</option>
									</select>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Judul Pesan </label>
									<input type='text' name='judul' class='form-control' required/>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Isi Pesan </label>
									<textarea required name='isi' class='form-control'></textarea>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Icon (optional) </label>
									<input type='text' name='icon' class='form-control'/>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Large Image (optional) </label>
									<input type='text' name='image' class='form-control'/>
								</fieldset>
								<input type='hidden' name='act' value='send_one'/>
								<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
								<button class='btn btn-success'>Kirim</button>
							</form>
						</div>
					</section>
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
</body>
</html>