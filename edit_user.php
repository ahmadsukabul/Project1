<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_act/_edit_user.php");
if(!isset($_GET['id'])){
	echo "need id!";
	exit;
}
$id = abs((int)$_GET['id']);
$data = $db->fetch("select * from users where id='$id'");
if(!isset($data['id'])){
	echo "User Tidak Di Temukan";
	exit;
}
$csrf = $app->csrf();
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Edit User <?PHP echo $id; ?> - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class='col-md-12 col-xs-12 col-lg-12'>
					
						<?PHP 
							if(isset($_GET['e'],$_SERVER['HTTP_REFERER'])){
							?>
							<div class="alert alert-danger alert-fill alert-close alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<i class="font-icon font-icon-inline font-icon-warning"></i>
									<strong>Ada Masalah!!</strong><br>
									<?PHP echo $_SESSION['error_msg']; ?>
							</div>
							<?PHP } ?>
							
							
							<?PHP 
							if(isset($_GET['s'],$_SERVER['HTTP_REFERER'])){
							?>
							<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<i class="fa fa-check"></i>
									<strong>Berhasil!!</strong><br>
									<?PHP echo $_SESSION['success_msg']; ?>
							</div>
							<?PHP } ?>
					
					<section class="card card-green mb-3">
						<header class="card-header">
							Edit User <?PHP echo $id; ?>
						</header>
						<div class="card-block">
							
							<form action='' method='post'>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Nama User</label>
										<input value='<?PHP echo $data['nama']; ?>' name='nama' type="text" class="form-control" placeholder="Andi" required>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Email User</label>
										<input value='<?PHP echo $data['email']; ?>' name='email' type="text" class="form-control" placeholder="user@gmail.com" required>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Nomor HP User</label>
										<input value='<?PHP echo $data['hp']; ?>' name='hp' type="text" class="form-control" placeholder="0822xxxxxx" required>
									</fieldset>
								</div>
							</div>
							
							<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='edit'/>
							<button class='btn btn-success'>Simpan</button>
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