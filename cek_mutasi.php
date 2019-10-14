<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Cek Mutasi - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
				<div class='col-md-12'>
					<section class="card card-red mb-3">
						<header class="card-header">
							Detail login untuk melihat mutasi
						</header>
						<div class="card-block">
							<div class='alert alert-info'>
								Fitur ini di gunakan untuk melihat mutasi, biasanya ini di gunakan saat ada pengguna yang salah transfer nominal, kita cek dari mutasi ini untuk melihat apakah memang dia sudah transfer atau belum
							</div>
							Untuk mutasi Bank BCA, BRI, MANDIRI, BNI : <br>
							Link : <a href='https://app.mutasibank.co.id/login' target='_blank'>https://app.mutasibank.co.id/login</a><br>
							User : masdew95@gmail.com<br>
							Pass : KitaPastiBisa100%<br>
							
							<p>&nbsp;<p>
							Untuk mutasi Gopay Manual, OVO Manual : <br>
							Link : <a href='https://cekmutasi.co.id/app/login' target='_blank'>https://cekmutasi.co.id/app/login</a><br>
							User : masdew95@gmail.com<br>
							Pass : KitaPastiBisa100%<br>
							
							<p>&nbsp;<p>
							Untuk mutasi WINPAY (BRIVA, MANDIRI VA, BNI VA, PERMATA VA, INDOMARET, ALFAMART) : <br>
							Link : <a href='https://member.winpay.id' target='_blank'>https://member.winpay.id</a><br>
							User : staff_bukakios<br>
							Pass : KitaPastiBisa100%<br>
							
							<p>&nbsp;<p>
							Untuk mutasi MIDTRANS (GOPAY INSTAN) : <br>
							Link : <a href='https://dashboard.midtrans.com/' target='_blank'>https://dashboard.midtrans.com</a><br>
							User : cs@bukakios.net<br>
							Pass : KitaPastiBisa100%<br>
							
						</div>
					</section>
					
					
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
</body>
</html>