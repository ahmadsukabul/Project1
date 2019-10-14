<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_GET['id'])){
	$id = abs((int)$_GET['id']);
	$data = $db->fetch("select * from verify_id where id='$id'");
	$uid = $data['uid'];
	$url_ktp = $data['url_ktp'];
	$url_selfi = $data['url_selfi'];
	$created_at = $data['created_at'];
	$data_user = $db->fetch("select nama,email,hp,nama_toko,verif_user,saldo from users where id='$uid'");
	$nama = $data_user['nama'];
	$email = $data_user['email'];
	$hp = $data_user['hp'];
	$statusnya = "<span class='label label-danger'>Belum</span>";
	if($data_user['verif_user']==1){
		$statusnya = "<span class='label label-success'>Sudah</span>";
	}
}else{
	echo "need id!";
	exit;
}
if(isset($_REQUEST['act'])){
	require_once("_act/_verif_id_info.php");
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Verif Identitas #<?PHP echo $id; ?> - <?PHP echo $c_name; ?></title>
	<link rel="stylesheet" href="css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="css/separate/vendor/select2.min.css">
	<link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
	<link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
			<div class='row'>
								<div class="col-lg-12 col-md-12">
									<table class='table table-bordered table-hover' style='margin-bottom:20px'>
										<thead>
											<tr>
											  <th colspan=3><center>Informasi User</center></th>
											</tr>
										 </thead>
										 <tbody>
											<tr class=''>
												<td>User ID</td>
												<td>#<?PHP echo $uid; ?></td>
											</tr>
											<tr class=''>
												<td>Nama</td>
												<td><?PHP echo "$nama"; ?></td>
											</tr>
											<tr class=''>
												<td>Nama Toko</td>
												<td><?PHP echo "$data_user[nama_toko]"; ?></td>
											</tr>
											<tr class=''>
												<td>Email/HP</td>
												<td><?PHP echo "$email / $hp"; ?></td>
											</tr>
											<tr class=''>
												<td>Saldo</td>
												<td><?PHP echo $app->idr($data_user['saldo']); ?></td>
											</tr>
											<tr class=''>
												<td>Status</td>
												<td><?PHP echo "$statusnya $data_user[verif_user]"; ?></td>
											</tr>
										 </tbody>
									</table>
								</div>
							</div>
	        <div class="row">
	            <div class="col-md-12 col-xs-12 col-lg-12">
					<section class="card card-green mb-3">
						<header class="card-header">
							Data Verifikasi
						</header>
						<div class="card-block">
							<form action="" method="post">
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label" for="tipe">Foto KTP/SIM</label>
										<img src='<?PHP echo $url_ktp; ?>' style='max-width:100%'/>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label" for="tipe">Foto Selfi Dengan KTP/SIM</label>
										<img style='max-width:100%' src='<?PHP echo $url_selfi; ?>'/>
									</fieldset>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Masukan Nama Di Yang Di KTP</label>
										<input name='nama_ktp' class='form-control' type='text' placeholder='Eldi' required/>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Masukan Nomor KTP/SIM</label>
										<input name='nomor_ktp' class='form-control' type='text' placeholder='140243011950003' required/>
									</fieldset>
								</div>
								
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Masukan Tanggal Lahir</label>
										<input id='tanggal_lahir' class="flatpickr form-control" name='tanggal_lahir' type="text" placeholder="Pilih tanggal.." required/>
									</fieldset>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">Pilih Provinsi</label>
										<select id='provinsi' name='provinsi' class="select2">
											<option>--Pilih Provinsi--</option>
											<?PHP
											$data_provinsi = file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi");
											$data_provinsi = json_decode($data_provinsi,true);

											//ambil data dari sql
											// foreach
											//masukkand data ke arary

											// dattmp[];
											if(!$data_provinsi['error']){
												foreach($data_provinsi['semuaprovinsi'] as $provinsi){
													//data disimpan ke array juga
													echo "<option value='$provinsi[id]'>$provinsi[nama]</option>";	
													
												}

												//looping ke dua array
												//pake for 
												// 
											}
											?>
										</select>
									</fieldset>
								</div>
								<div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">Pilih Kabupaten</label>
										<select id='kabupaten' name='kabupaten' class='select2' disabled>
											<option value='0'>--Pilih Provinsi Dulu--</option>
										</select>
									</fieldset>
								</div>
								<div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">Pilih Kecamatan</label>
										<select id='kecamatan' name='kecamatan' class='select2' disabled>
											<option value='0'>--Pilih kabupaten Dulu--</option>
										</select>
									</fieldset>
								</div>
								<div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">Pilih Kelurahan</label>
										<select id='kelurahan' name='kelurahan' class='select2' disabled>
											<option value='0'>--Pilih kecamatan dulu--</option>
										</select>
									</fieldset>
								</div>
							</div>
							<fieldset class="form-group">
								<label class="form-label">Pilih Jenis Kelamin</label>
								<select name='jk' class='form-control'>
									<option value='L'>Laki-Laki</option>
									<option value='P'>Perempuan</option>
								</select>
							</fieldset>
							<fieldset class="form-group">
								<label class="form-label">Alamat Lengkap sesuai ktp</label>
								<textarea cols='5' class='form-control' name='alamat_lengkap' required></textarea>
							</fieldset>
							<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
							<input type='hidden' name='uid' value='<?PHP echo $uid; ?>'/>
							<input type='hidden' name='act' value='approve'/>
							<button class="btn btn-success">Approve Dan Simpan</button>
							</form>
							
						</div>
					</section>
					
					<section class="card card-red mb-3">
						<header class="card-header">
							Tolak Verifikasi
						</header>
						<div class="card-block">
							<form action='' method='post'>
								<fieldset class="form-group">
									<label class="form-label">Alasan di tolak</label>
									<textarea cols='5' class='form-control' name='alasan' required>mohon lampirkan foto selfi kamu sambil memegang ktp </textarea>
								</fieldset>
								<input type='hidden' name='act' value='deny'/>
								<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
								<input type='hidden' name='uid' value='<?PHP echo $uid; ?>'/>
								<button class="btn btn-danger">Tolak</button>
							</form>
						</div>
					</section>
					<?PHP if($admin_id==1){ ?>
					<section class="card card-red mb-3">
						<header class="card-header">
							Only Admin
						</header>
						<div class="card-block">
							<form action='' method='post'>
								<input type='hidden' name='act' value='fast'/>
								<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
								<input type='hidden' name='uid' value='<?PHP echo $uid; ?>'/>
								<button class="btn btn-warning">Approve Fast</button>
							</form>
						</div>
					</section>
					<?PHP } ?>
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	<script src="js/lib/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="js/lib/select2/select2.full.min.js"></script>
	<script>
	if ($('.bootstrap-select').length) {
		// Bootstrap-select
		$('.bootstrap-select').selectpicker({
			style: '',
			width: '100%',
			size: 8
		});
	}

	if ($('.select2').length) {
		// Select2
		//$.fn.select2.defaults.set("minimumResultsForSearch", "Infinity");

		$('.select2').not('.manual').select2();

		$(".select2-icon").not('.manual').select2({
			templateSelection: select2Icons,
			templateResult: select2Icons
		});

		$(".select2-arrow").not('.manual').select2({
			theme: "arrow"
		});

		$('.select2-no-search-arrow').select2({
			minimumResultsForSearch: "Infinity",
			theme: "arrow"
		});

		$('.select2-no-search-default').select2({
			minimumResultsForSearch: "Infinity"
		});

		$(".select2-white").not('.manual').select2({
			theme: "white"
		});

		$(".select2-photo").not('.manual').select2({
			templateSelection: select2Photos,
			templateResult: select2Photos
		});
	}

	function select2Icons (state) {
		if (!state.id) { return state.text; }
		var $state = $(
			'<span class="font-icon ' + state.element.getAttribute('data-icon') + '"></span><span>' + state.text + '</span>'
		);
		return $state;
	}

	function select2Photos (state) {
		if (!state.id) { return state.text; }
		var $state = $(
			'<span class="user-item"><img src="' + state.element.getAttribute('data-photo') + '"/>' + state.text + '</span>'
		);
		return $state;
	}

	</script>
	<script type="text/javascript" src="js/lib/flatpickr/flatpickr.min.js"></script>
	<script>
	$(document).ready(function(){
		/* ==========================================================================
			 Datepicker
			 ========================================================================== */

			$('.flatpickr').flatpickr();
			$("#flatpickr-disable-range").flatpickr({
				disable: [
					{
						from: "2016-08-16",
						to: "2016-08-19"
					},
					"2016-08-24",
					new Date().fp_incr(30) // 30 days from now
				]
			});
		   
		});
	</script>
	<script>
		var provinsi = $("#provinsi");
		var kabupaten = $("#kabupaten");
		var kecamatan = $("#kecamatan");
		var kelurahan = $("#kelurahan");
		provinsi.change(function(e) {
			var provinsi_id = provinsi.val();
			kabupaten.empty();
			if(provinsi_id>0){
				var url_json = 'ajax/load_indo_kabupaten.php?id='+provinsi_id;
				//var url_json = 'http://dev.farizdotid.com/api/daerahindonesia/provinsi/'+provinsi_id+'/kabupaten';
				kabupaten.append($('<option></option>').attr('value', 0).text("--Pilih Kabupaten--"));
				$.getJSON(url_json, function (data) {
				  $.each(data.kabupatens, function (key, entry) {
					kabupaten.prop('disabled', false);
					kabupaten.append($('<option></option>').attr('value', entry.id).text(entry.nama));
				  })
				});	
			}
		});
		
		kabupaten.change(function(e) {
			var kabupaten_id = kabupaten.val();
			kecamatan.empty();
			if(kabupaten_id>0){
				var url_json = 'ajax/load_indo_kecamatan.php?id='+kabupaten_id;
				kecamatan.append($('<option></option>').attr('value', 0).text("--Pilih Kecamatan--"));
				$.getJSON(url_json, function (data) {
				  $.each(data.kecamatans, function (key, entry) {
					kecamatan.prop('disabled', false);
					kecamatan.append($('<option></option>').attr('value', entry.id).text(entry.nama));
				  })
				});	
			}
		});
		
		kecamatan.change(function(e) {
			var kecamatan_id = kecamatan.val();
			kelurahan.empty();
			if(kecamatan_id>0){
				var url_json = 'ajax/load_indo_kelurahan.php?id='+kecamatan_id;
				kelurahan.append($('<option></option>').attr('value', 0).text("--Pilih Kelurahan--"));
				$.getJSON(url_json, function (data) {
				  $.each(data.desas, function (key, entry) {
					kelurahan.prop('disabled', false);
					kelurahan.append($('<option></option>').attr('value', entry.id).text(entry.nama));
				  })
				});	
			}
		});
	</script>
</body>
</html>