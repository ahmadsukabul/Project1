<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
$prefix_session = "rk_topup";
if(isset($_POST['mulai'],$_POST['sampai'])){
	$start_date = "$_POST[mulai] 00:00:00";
	$end_date = "$_POST[sampai] 23:59:00";
	$_SESSION[$prefix_session."_start_date"] = "$start_date";
	$_SESSION[$prefix_session."_end_date"] = "$end_date";
}
if(!isset($_SESSION[$prefix_session."_start_date"])){
	$default_start = "$today 00:00:00";
	$default_end = "$today 23:59:00";
	$_SESSION[$prefix_session."_start_date"] = "$default_start";
	$_SESSION[$prefix_session."_end_date"] = "$default_end";
}

$d_start = $_SESSION[$prefix_session."_start_date"];
$d_end = $_SESSION[$prefix_session."_end_date"];
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Rangkuman Trx H2H - <?PHP echo $c_name; ?></title>
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
							Rangkuman Transaksi Di H2H
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
							
							<!-- table aja -->
							<table id='table-edit2' class="table table-hover table-bordered">
							  <thead> 
								<tr>
								  <th>Nama H2H</th>
								  <th class='color-green'>Jumlah Trx <i class='fa fa-check'></i></th>
								  <th class='color-green'>Total Trx <i class='fa fa-check'></i></th>
								  <th class='color-red'>Jumlah Trx <i class='fa fa-close'></i></th>
								  <th class='color-red'>Total Trx <i class='fa fa-close'></i></th>
								</tr>
							  </thead>
							  <tbody>
							<?PHP 
							$h2h = $db->fetch_multiple("select id_h2h,nama_h2h from h2h order by id_h2h ASC");
							foreach($h2h as $h){
								$h2h_id = $h['id_h2h'];
								$h2h_name = $h['nama_h2h'];
								$jml_berhasil = $db->num_rows("select id from transaksi where created_at>='$d_start' and created_at<='$d_end' and status=1 and h2h_id='$h2h_id'");
								$jml_gagal = $db->num_rows("select id from transaksi where created_at>='$d_start' and created_at<='$d_end' and status>1 and h2h_id='$h2h_id'");
								$total_berhasil = $db->fetch("select sum(price_master) from transaksi where created_at>='$d_start' and created_at<='$d_end' and status=1 and h2h_id='$h2h_id'");$total_berhasil=$total_berhasil[0];
								$total_gagal = $db->fetch("select sum(price_master) from transaksi where created_at>='$d_start' and created_at<='$d_end' and status>1 and h2h_id='$h2h_id'");$total_gagal=$total_gagal[0];
							?>
							
							<tr>
							  <td><?PHP echo $h2h_name; ?></td>
							  <td class='color-green'><?PHP echo $app->angka_id($jml_berhasil); ?></td>
							  <td class='color-green'><?PHP echo $app->idr($total_berhasil); ?></td>
							  <td class='color-red'><?PHP echo $app->angka_id($jml_gagal); ?></td>
							  <td class='color-red'><?PHP echo $app->idr($total_gagal); ?></td>
							</tr>
							
							<?PHP
							}
							?>
								</tbody>
							</table>
							
							
							
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