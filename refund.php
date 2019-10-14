<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
//require_once("_/_session_level_1.php");
if(isset($_POST['act'])){
	require_once("_act/_refund.php");
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
	<title>Refund Transaksi - <?PHP echo $c_name; ?></title>
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
					
					?>
					<section class="card card-red mb-3">
						<header class="card-header">
							Batalkan dan refund transaksi
						</header>
						<div class="card-block">
							<div class='alert alert-info'>
								Fitur ini di gunakan untuk membatalkan transaksi dan mengembalikan dana ke pelanggan, biasanya karna transaksi double, atau nomor sn salah
							</div>
							<form action='' method='post'>
								<fieldset class="form-group">
									<label class="form-label">Trx id</label>
									<input type='text' name='trx_id' class='form-control' placeholder='213bc3e69533ccd5342278f29b393608' required/>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Pesan Gagal </label>
									<textarea required name='pesan_gagal' class='form-control'>Transaksi double, dana sudah kami refund</textarea>
								</fieldset>
								<input type='hidden' name='act' value='refund'/>
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