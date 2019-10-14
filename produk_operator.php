<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php"); //hanya level 1=admin
if(isset($_REQUEST['act'])){
	require_once("_act/_produk_operator.php");
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
	<title>Produk Operator - <?PHP echo $c_name; ?></title>
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
							Masukan Produk Operator Baru
						</header>
						<div class="card-block">
							
							<form action='' method='post'>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Pilih Produk Utama</label>
										<select name='id_kategori' class='form-control'>
											<option value=0>--Silahkan pilih--</option>
											<?PHP
												$putama_s = $db->fetch_multiple("select id,product_name from p_kategori order by id ASC");
												foreach($putama_s as $putama){
													echo "<option value='$putama[id]'>$putama[product_name]</option>";
												}
											?>
										</select>
										<small class="text-muted">Pilih ini sebagai produk induknya.</small>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Nama Produk</label>
										<input name='nama_produk' type="text" class="form-control" id="tipe_produk" placeholder="AXIS DATA BRONET" required>
									</fieldset>
									
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Produk id</label>
										<input name='produk_id' type="text" class="form-control" placeholder="AIGO" required>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Prefix</label>
										<input name='prefix' type="text" class="form-control" placeholder="0812,0852,0811,0823" required>
										<small class="text-muted">Kalau pulsa,data,sms,telpon wajib ada prefix</small>
									</fieldset>
								</div>
							</div>
							<fieldset class="form-group">
								<label class="form-label">Logo</label>
								<input name='logo' type="text" class="form-control" placeholder="https://assets.bukakios.net/img/tsel.png" required>
							</fieldset>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='add'/>
							<button class='btn btn-success'>Simpan</button>
							</form>
						</div>
					</section>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Semua Daftar Produk Operator
						</header>
						<div class="card-block">
							<div id='top-action' style='margin-bottom:20px'>
								<span class="input-group"  style='width:30%'>
									<input class="form-control" required type="text" name="keyword" id="search_cat" placeholder='Enter keyword...' onkeyup='changePagination(1, "search", this.value)'>
									<span class="input-group-btn">
									<button class="btn btn-default"><i class='fa fa-search'></i></button>
									</span>
								</span>
							</div>
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
		changePagination('1', 'all_produk', '');    
		});
		function changePagination(page, action, q){
			$(".flash").show();
			$(".flash").fadeIn(400).html
			('Loading...');
			var dataString = 'page='+ page;
			dataString = dataString + '&action='+action+'&q='+q;
			$.ajax({
				type: "POST",
				url: "ajax/load_produk_operator.php",
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