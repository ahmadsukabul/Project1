<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_ovo.php");
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
	<title>Daftar OVO - <?PHP echo $c_name; ?></title>
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
							Masukan Akun Ovo baru untuk transfer bank
						</header>
						<div class="card-block">
							<form action='' method='post'>
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<fieldset class="form-group">
										<label class="form-label">Nomor Ovo</label>
										<input name='nomor' type="text" class="form-control" placeholder="0859xxxx" required>
									</fieldset>
									<fieldset class="form-group">
										<label class="form-label">Nama Ovo</label>
										<input name='nama' type="text" class="form-control" placeholder="DEWA (IN-OUT)" required>
									</fieldset>
								</div>
							</div>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='add'/>
							<button class='btn btn-success'>Simpan</button>
							</form>
							<hr>
							<form action='' method='post'>
							<div class='alert alert-success'>
							Gunakan ini untuk pencatatan topup ke akun ovo
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Pilih Akun OVO</label>
										<select name='ovo_id' class='form-control'>
											<?PHP
											$all = $db->fetch_multiple("select id,number,name from ovo_bank order by id desc");
											foreach($all as $a){
												echo "<option value='$a[id]'>$a[number] [ $a[name] ]</option>";
											}
											?>
										</select>
									</fieldset>
								</div>
								<div class='col-lg-6 col-md-6'>
									<fieldset class="form-group">
										<label class="form-label">Masukan Nominal Topup</label>
										<input name='nominal' type="text" class="form-control" placeholder="100000" required>
									</fieldset>
								</div>
							</div>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='topup'/>
							<button class='btn btn-success'>Simpan</button>
							</form>
						</div>
					</section>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Semua Daftar OVO Bank
						</header>
						<div class="card-block">
							<span class="flash"></span>
							<div id="pageData"></div>
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
				url: "ajax/load_ovo.php",
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