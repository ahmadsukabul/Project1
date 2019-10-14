<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
$total = $db->num_rows("select id from transaksi");
if(isset($_POST['mulai'],$_POST['sampai'])){
	$start_date = "$_POST[mulai] 00:00:00";
	$end_date = "$_POST[sampai] 23:59:00";
	$_SESSION['rk_start_date'] = "$start_date";
	$_SESSION['rk_end_date'] = "$end_date";
}
if(!isset($_SESSION['rk_start_date'])){
	$default_start = "$today 00:00:00";
	$default_end = "$today 23:59:00";
	$_SESSION['rk_start_date'] = "$default_start";
	$_SESSION['rk_end_date'] = "$default_end";
}

$d_start = $_SESSION['rk_start_date'];
$d_end = $_SESSION['rk_end_date'];

$q_profit = $db->fetch("select sum(profit) from transaksi where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$profit = $q_profit[0];

$q_pengeluaran = $db->fetch("select sum(price_master) from transaksi where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$pengeluaran = $q_pengeluaran[0];

$q_user_topup = $db->fetch("select sum(nominal_topup) from topup where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$user_topup = $q_user_topup[0];

$q_master_topup = $db->fetch("select sum(jumlah_deposit) from deposit_master where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$master_topup = $q_master_topup[0];

$transaksi = $db->num_rows("select id from transaksi where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$transaksi_gagal = $db->num_rows("select id from transaksi where status!=1 and created_at>='$d_start' and created_at<='$d_end'");
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Rangkuman Ringkas - <?PHP echo $c_name; ?></title>
	<link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
	<link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class='col-md-12 col-xs-12 col-lg-12'>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Ringkasan
						</header>
						<div class="card-block">
							<div id='top-action' style='margin-bottom:20px'>
							<form action='' method='post'>
								<div class='row'>
									
									<div class='col-md-5'>
										<fieldset>
											<label>Mulai Dari</label>
											<input id='mulai' class="flatpickr form-control" name="mulai" type="text" placeholder="Pilih tanggal.."/>
										</fieldset>
									</div>
									<div class='col-md-5'>
										<fieldset>
											<label>Sampai Dengan</label>
											<input id='sampai' class="flatpickr form-control" name='sampai' type="text" placeholder="Pilih tanggal.."/>
										</fieldset>
									</div>
									<div class='col-md-2'>
										.<br>
										<button class='btn btn-primary btn-md btn-block'><i class='fa fa-search'></i></button>
									</div>
									
								</div>
							</form>
							</div>
							<hr>
							From : <b><?PHP echo $d_start; ?></b><br>
							Tooo : <b><?PHP echo $d_end; ?></b><br>
							<p>
							<div class="row">
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $app->idr($user_topup); ?></div>
							<div class="caption color-blue">Total Topup User</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="fa fa-users color-green"></span> User topup ke sistem</div>
					</section><!--.widget-simple-sm-->
				</div>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $app->idr($pengeluaran); ?></div>
							<div class="caption color-red">Total Pengeluaran H2H</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="fa fa-money color-red"></span> Pengeluaran bukakios untuk belanja di H2H</div>
					</section><!--.widget-simple-sm-->
				</div>
	        </div>
			<div class='row'>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $app->idr($profit); ?></div>
							<div class="caption color-green">Profit Bersih</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="font-icon font-icon-bookmark color-green"></span> Keuntungan Bersih Bukakios</div>
					</section><!--.widget-simple-sm-->
				</div>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $app->idr($master_topup); ?></div>
							<div class="caption color-red">Topup Saldo H2H</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="font-icon font-icon-wallet color-red"></span> Jumlah Topup Bukakios ke H2H</div>
					</section><!--.widget-simple-sm-->
				</div>
			</div>
			
			<div class='row'>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $app->angka_id($transaksi); ?></div>
							<div class="caption color-green">Jumlah Transaksi Berhasil</div>
						</div>
					</section><!--.widget-simple-sm-->
				</div>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $app->angka_id($transaksi_gagal); ?></div>
							<div class="caption color-red">Jumlah Transaksi Gagal</div>
						</div>
					</section><!--.widget-simple-sm-->
				</div>
			</div>
			
			
						</div>
					</section>
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
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
</body>
</html>