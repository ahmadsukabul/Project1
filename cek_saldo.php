<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_cek_saldo.php");
}else{
	$csrf = $app->csrf();
}
$total = $db->num_rows("select id from deposit_master");
//sisa saldo
/*cek saldo master */
$data_cek_saldo = array("key"=>$buy_api_key);
$respon_saldo = $app->curl_post("$buy_api_url/cek_saldo.php",$data_cek_saldo);
$data_saldo = json_decode($respon_saldo,true);
if(isset($data_saldo['balance'])){
	$sisa_saldo = $data_saldo['balance'];
	$sisa_saldo = $app->idr($sisa_saldo);
}else{
	$sisa_saldo = "Not Connect";
}
/*total deposit sepanjang masa */$total_deposit = $db->fetch("SELECT SUM(jumlah_deposit) AS total_deposit FROM deposit_master where status=1");$total_deposit=$total_deposit[0];$total_deposit = $app->idr($total_deposit);
$total_topup = $db->fetch("SELECT SUM(nominal_topup) AS total_topup FROM topup where status=1");$total_topup=$total_topup[0];$total_topup = $app->idr($total_topup);
$total_transaksi = $db->fetch("SELECT SUM(price_client) AS total_transaksi FROM transaksi where status=1");$total_transaksi=$total_transaksi[0];$total_transaksi = $app->idr($total_transaksi);

?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Saldo Master - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
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
	        <div class="row">
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $sisa_saldo; ?></div>
							<div class="caption color-blue">Sisa Saldo Master</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="arrow color-green">↑</span> 3% increase <strong>1w ago</strong></div>
					</section><!--.widget-simple-sm-->
				</div>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $total_deposit; ?></div>
							<div class="caption color-red">Total Deposit</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="arrow color-green">↑</span> 3% increase <strong>1w ago</strong></div>
					</section><!--.widget-simple-sm-->
				</div>
	        </div>
			<div class='row'>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $total_topup; ?></div>
							<div class="caption color-green">Total Topup User</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="arrow color-green">↑</span> 3% increase <strong>1w ago</strong></div>
					</section><!--.widget-simple-sm-->
				</div>
				<div class="col-md-6">
					<section class="widget widget-simple-sm">
						<div class="widget-simple-sm-statistic">
							<div class="number"><?PHP echo $total_transaksi; ?></div>
							<div class="caption color-green">Total Transaksi User</div>
						</div>
						<div class="widget-simple-sm-bottom statistic"><span class="arrow color-green">↑</span> 3% increase <strong>1w ago</strong></div>
					</section><!--.widget-simple-sm-->
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<section class="card card-blue mb-3">
						<header class="card-header">
							Riwayat Deposit
						</header>
						<div class="card-block">
							Total Deposit : <?PHP echo $total; ?><p>
							<div id='top-action' style='margin-bottom:20px'>
								<div class="dropdown show">
								  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Request Deposit Baru
								  </a>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="<?PHP echo "cek_saldo.php?act=req&bank=bri&csrf=$csrf&nominal=1000000"; ?>">Ke Bank BRI</a>
									<a class="dropdown-item" href="<?PHP echo "cek_saldo.php?act=req&bank=bni&csrf=$csrf&nominal=1000000"; ?>">Ke Bank BNI</a>
									<a class="dropdown-item" href="<?PHP echo "cek_saldo.php?act=req&bank=bca&csrf=$csrf&nominal=1000000"; ?>">Ke Bank BCA</a>
									<a class="dropdown-item" href="<?PHP echo "cek_saldo.php?act=req&bank=mandiri&csrf=$csrf&nominal=1000000"; ?>">Ke Bank Mandiri</a>
								  </div>
								</div>
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
				url: "ajax/load_deposit.php",
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