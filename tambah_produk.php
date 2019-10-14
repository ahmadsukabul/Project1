<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_tambah_produk.php");
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
	<title>Tambah Produk Baru - <?PHP echo $c_name; ?></title>
	<link rel="stylesheet" href="css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="css/separate/vendor/select2.min.css">
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
							echo "<div class='alert alert-success'>Sukses menambahkan produk baru :)</div>";
						}else if($s==2){
							echo "<div class='alert alert-success'>Sukses menghapus produk :)</div>";
						}
					}
					
					if(isset($_GET['e'])){
						$e = $_GET['e'];
						if($e==1){
							echo "<div class='alert alert-danger'>Gagal Menambahkan produk karna nama produk sudah ada!!</div>";
						}else if($e==2){
							echo "<div class='alert alert-danger'>Gagal Menambahkan produk karna crsf token salah, silahkan coba lagi!!</div>";
						}else if($e==3){
							echo "<div class='alert alert-danger'>Gagal menghapus produk karna crsf token salah, silahkan coba lagi!!</div>";
						}
					}
					?>
					<section class="card card-green mb-3">
						<header class="card-header">
							Masukan Produk Baru
						</header>
						<div class="card-block">
							
							<form action='' method='post'>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Pilih Operator</label>
										<select id='operator' name='operator' class="select2 select2-photo">
											<option data-photo='<?PHP echo "$c_url/favicon.ico"; ?>' value=0>Silahkan Pilih ...</option>
											<?PHP
												$putama_s = $db->fetch_multiple("select id,product_name,product_logo from p_operator order by product_name ASC");
												foreach($putama_s as $putama){
													echo "<option data-photo='$putama[product_logo]' value='$putama[id]'>$putama[product_name]</option>";
												}
											?>
										</select>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Nama Produk</label>
										<input name='nama_produk' type="text" class="form-control" id="tipe_produk" placeholder="AXIS DATA BRONET" required>
									</fieldset>
									
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Kode Produk</label>
										<input name='kode' type="text" class="form-control" placeholder="AIGO1" required>
									</fieldset>
								</div>
							</div>
							<div class="row">
								
								<div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">Harga H2H</label>
										<input name='harga' type="number" class="form-control" placeholder="5325" required>
									</fieldset>
								</div>
								<div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">Price Markup (keuntungan)</label>
										<input name='untung' type="number" class="form-control" placeholder="200" required>
									</fieldset>
								</div>
								<div class="col-lg-3 col-md3">
									<fieldset class="form-group">
										<label class="form-label">Default Price Sell (pengguna)</label>
										<input name='sell' type="number" class="form-control" placeholder="7000" required>
									</fieldset>
								</div>
								<div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">H2H</label>
										<select name='h2h' class='form-control'>
											<?PHP
											$h2h_list = $db->fetch_multiple("select id_h2h,nama_h2h from h2h order by id_h2h asc");
											foreach($h2h_list as $h2h){
												echo "<option value='$h2h[id_h2h]'>$h2h[nama_h2h]</option>";
											}
											?>
										</select>
									</fieldset>
								</div>
							</div>
							
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='add'/>
							<button class='btn btn-success'>Simpan</button>
							</form>
						</div>
					</section>
					<section id='divnya'>
						
					</section>
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
		
	var operator = $("#operator");
	operator.change(function(e) {
		var opid = operator.val();
		var divnya = $("#divnya");;
		if(opid>0){
			$.ajax({url: 'ajax/load_show_operator_list.php?operator='+opid,
			success: function(output) {
				divnya.html(output);
			},
				error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status + " "+ thrownError);
				divnya.hide();
			}});
		}
	});
	</script>
</body>
</html>