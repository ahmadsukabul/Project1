<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_POST['act'])){
	require_once("_act/_jab_send.php");
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
	<title>Jabber Send Message - <?PHP echo $c_name; ?></title>
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
							echo "<div class='alert alert-success'>Sukses Mengirim pesan!!</div>";
						}
					}
					
					if(isset($_GET['e'])){
						$e = $_GET['e'];
						if($e==1){
							echo "<div class='alert alert-danger'>Gagal mengirim pesan!</div>";
						}
					}
					?>
					<section class="card card-blue mb-3">
						<header class="card-header">
							Kirim Peesan ke jabber H2H
						</header>
						<div class="card-block">
							<div class='alert alert-info'>
								Fitur ini bisa di gunakan untuk, deposit saldo, mengulangi transaksi yang gagal, update harga, cek harga, update status produk
							</div>
							<form action='' method='post'>
								<fieldset class="form-group">
									<label class="form-label">Tujuan </label>
									<select class='form-control' name='to'>
										<?PHP 
										$h2h_list = $db->fetch_multiple("select id_h2h,jabber_h2h,nama_h2h from h2h order by id_h2h ASC");
										foreach($h2h_list as $h2h){
											echo "<option value='$h2h[id_h2h]'>$h2h[nama_h2h] | $h2h[jabber_h2h]</option>";
										}
										?>
									</select>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Isi pesan </label>
									<textarea name='isi' class='form-control'></textarea>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Trx ID (optional) </label>
									<input type='text' name='trx_id' class='form-control' value='null'/>
								</fieldset>
								<input type='hidden' name='act' value='send'/>
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