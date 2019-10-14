<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_topup_metode.php");
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
	<title>Daftar Metode Topup - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-md-12 col-xs-12 col-lg-12">
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
							Tambah Metode Baru
						</header>
						<div class="card-block">
							<form action="" method="post">
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label" for="tipe">Pilih Tipe</label>
										<select required="" id="tipe" name="tipe" class="form-control">
											<option value="0">--Silahkan pilih--</option>
											<option value="1">Bank Transfer</option>									
											<option value="2">Virtual Account</option>									
											<option value="3">E-MONEY</option>									
											<option value="5">ClickPay (Online)</option>									
											<option value="4">Lainya</option>									
										</select>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Nama Metode</label>
										<input name='nama_metode' class='form-control' type='text' placeholder='GOPAY' required/>
									</fieldset>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Biaya Admin</label>
										<input name='biaya_admin' class='form-control' type='number' placeholder='2000' required/>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Minimal Nilai Topup</label>
										<input name='min_topup' class='form-control' type='number' placeholder='20000' required/>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Maksimal Nilai Topup</label>
										<input name='max_topup' class='form-control' type='number' placeholder='2000000' required/>
									</fieldset>
								</div>
							</div>
							<fieldset class="form-group">
								<label class="form-label">Deskripsi</label>
								<textarea cols='5' class='form-control' name='deskripsi'></textarea>
							</fieldset>
							<fieldset class="form-group">
								<label class="form-label">Link Gambar Metode</label>
								<input name='gambar' class='form-control' type='text' placeholder='https://assets.bukakios.net/img/bri.jpg' required/>
							</fieldset>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label" for="tipe">Nomor Rekening</label>
										<input name='nomor_rekening' class='form-control' type='number' placeholder='90000xxxx'/>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Nama Rekening</label>
										<input name='nama_rekening' class='form-control' type='text' placeholder='UDIN'/>
									</fieldset>
								</div>
							</div>
							<input type='hidden' name='act' value='add'/>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<button class="btn btn-primary">Tambahkan</button>
							</form>
							
						</div>
					</section>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Daftar Metode Topup Tersedia
						</header>
						<div class="card-block">
							<div id="pageData"></div>
							<span class="flash"></span>				
						</div>
					</section>
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	<script>
	$(document).ready(function(){
		changePagination('1', 'all', '');    
		});
		function changePagination(page, action, q){
			$(".flash").show();
			$(".flash").fadeIn(400).html
			('Loading...');
			var dataString = 'page='+ page;
			dataString = dataString + '&action='+action+'&q='+q;
			$.ajax({
				type: "POST",
				url: "ajax/load_topup_metode.php",
				data: dataString,
				cache: false,
				success: function(result){
					$(".flash").hide();
					$("#pageData").html(result);
				}
			});
		}
	</script>
</body>
</html>