<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(!isset($_GET['id'])){
	echo "need id!";
	exit;
}
$id = abs((int)$_GET['id']);
$data = $db->fetch("select * from topup_metode where id='$id'");
if(!isset($data['id'])){
	echo "Metode Tidak Di Temukan";
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
	<title>Edit Metode Topup - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-md-12 col-xs-12 col-lg-12">
					<section class="card card-green mb-3">
						<header class="card-header">
							Edit Metode Topup
						</header>
						<div class="card-block">
							<form action="topup_metode.php" method="post">
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label" for="tipe">Pilih Tipe</label>
										<select required="" id="tipe" name="tipe" class="form-control">
											<option value="<?PHP echo $data['metode_kategori_id']; ?>">[TIDAK BERUBAH]</option>
											<option value="1">Bank Transfer</option>									
											<option value="2">Virtual Account</option>									
											<option value="3">E-MONEY</option>									
											<option value="4">Lainya</option>									
										</select>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Nama Metode</label>
										<input name='nama_metode' class='form-control' type='text' placeholder='GOPAY' required value='<?PHP echo $data['nama_metode']; ?>'/>
									</fieldset>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Biaya Admin</label>
										<input name='biaya_admin' class='form-control' type='number' placeholder='2000' value='<?PHP echo $data['biaya_admin']; ?>' required/>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Minimal Nilai Topup</label>
										<input name='min_topup' class='form-control' type='number' placeholder='20000' value='<?PHP echo $data['min_topup']; ?>' required/>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Maksimal Nilai Topup</label>
										<input name='max_topup' class='form-control' type='number' placeholder='2000000' value='<?PHP echo $data['max_topup']; ?>' required/>
									</fieldset>
								</div>
							</div>
							<fieldset class="form-group">
								<label class="form-label">Deskripsi</label>
								<textarea cols='5' class='form-control' name='deskripsi'><?PHP echo $data['deskripsi']; ?></textarea>
							</fieldset>
							<fieldset class="form-group">
								<label class="form-label">Link Gambar Metode</label>
								<input name='gambar' class='form-control' type='text' placeholder='https://assets.bukakios.net/img/bri.jpg' required value='<?PHP echo $data['gambar_metode']; ?>'/>
							</fieldset>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label" for="tipe">Nomor Rekening</label>
										<input name='nomor_rekening' class='form-control' type='text' placeholder='90000xxxx' value='<?PHP echo $data['nomor_rekening']; ?>'/>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Nama Rekening</label>
										<input name='nama_rekening' class='form-control' type='text' placeholder='UDIN' value='<?PHP echo $data['nama_rekening']; ?>'/>
									</fieldset>
								</div>
							</div>
							<input type='hidden' name='act' value='edit'/>
							<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<button class="btn btn-primary">Simpan</button>
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