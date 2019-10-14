<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_GET['id'])){
	$id = abs((int)$_GET['id']);
	$data_user = $db->fetch("select * from users where id='$id'");
	$tipe = "<span class='label label-warning'>Personal</span>";
	if($data_user['is_jualan']){
		$tipe = "<span class='label label-primary'>Pedagang</span>";
	}
	$aktif = $app->time_ago($data_user['terakhir_aktif']);
	$daftar = $app->time_ago($data_user['tanggal_daftar']);
	$status = "";
	if($data_user['verif_email']==1){
		$status = "$status <span class='label label-success'>Email <i class='fa fa-check'></i></span>";
	}else{
		$status = "$status <span class='label label-danger'>Email <i class='fa fa-close'></i></span>";
	}
	if($data_user['verif_hp']==1){
		$status = "$status <span class='label label-success'>HP <i class='fa fa-check'></i></span>";
	}else{
		$status = "$status <span class='label label-danger'>HP <i class='fa fa-close'></i></span>";
	}
	if($data_user['verif_user']==1){
		$status = "$status <span class='label label-success'>UNLOCK <i class='fa fa-check'></i></span>";
	}else{
		$status = "$status <span class='label label-danger'>UNLOCK <i class='fa fa-close'></i></span>";
	}
}else{
	exit;
}
if(isset($_REQUEST['act'])){
	require_once("_act/_info_user.php");
}else{
	$csrf = $app->csrf();
}

//stats 
$jumlah_trx_berhasil = $db->num_rows("select id from transaksi where uid='$id' and status='1'");
$jumlah_trx_gagal = $db->num_rows("select id from transaksi where uid='$id' and status!='1'");

$jumlah_trx_berhasil_rp = $db->fetch("select sum(price_client) from transaksi where uid='$id' and status='1'");
$jumlah_trx_gagal_rp = $db->fetch("select sum(price_client) from transaksi where uid='$id' and status!='1'");

$jumlah_topup = $db->num_rows("select id from topup where uid='$id' and status='1'");
$jumlah_topup_rp = $db->fetch("select sum(total_transfer) from topup where uid='$id' and status='1'");
$jumlah_topup_fee_rp = $db->fetch("select sum(fee) from topup where uid='$id' and status='1'");
$jumlah_topup_rp_real = $jumlah_topup_rp[0]-$jumlah_topup_fee_rp[0];

$jumlah_refund_rp = $db->fetch("select sum(jumlah_refund) from refund where uid='$id'");
$jumlah_refund = $db->num_rows("select id from refund where uid='$id'");


$status_blokir = "<span class='label label-success'>Tidak TerBlokir</span>";
if($data_user['blocked']==1){
	$status_blokir = "<span class='label label-danger'>TerBlokir</span>";
}
$data_verif = $db->fetch("select id,url_ktp,url_selfi from verify_id where uid='$id'");
$ada_ktp = false;
if(isset($data_verif['id'])){
	$ada_ktp = true;
	$d_url_ktp = $data_verif['url_ktp'];
	$d_url_selfi = $data_verif['url_selfi'];
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Info User #<?PHP echo $id; ?> - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
	<link rel='stylesheet' type='text/css' href='<?PHP echo "$assets_url/css/box.css"; ?>'/>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
			<div class='row'>
				<div class='col-md-12'>
					<section class="card mb-3">
						<header class="card-header card-header-xxl">
							Data User #<?PHP echo $id; ?>
						</header>
						<div class="card-block">
							<div class='row'>
								<div class='col-md-12'>
								
										<?PHP if(isset($_GET['e'])){
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
										if(isset($_GET['s'])){
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
										
									<table class='table table-bordered table-hover' style='margin-bottom:20px'>
										<thead>
											<tr>
											  <th colspan=3><center>Informasi User</center></th>
											</tr>
										 </thead>
										 <tbody>
											<tr class=''>
												<td>User ID</td>
												<td>#<?PHP echo $id; ?></td>
											</tr>
											<tr class=''>
												<td>Nama</td>
												<td><?PHP echo "$data_user[nama]"; ?></td>
											</tr>
											<tr class=''>
												<td>Nama Toko</td>
												<td><?PHP echo "$data_user[nama_toko]"; ?></td>
											</tr>
											<tr class=''>
												<td>Email/HP</td>
												<td><?PHP echo "$data_user[email] / $data_user[hp]"; ?></td>
											</tr>
											<tr class=''>
												<td>Saldo</td>
												<td><?PHP echo $app->idr($data_user['saldo']); ?></td>
											</tr>
											<tr class=''>
												<td>Tipe Akun</td>
												<td><?PHP echo $tipe; ?></td>
											</tr>
											<tr class=''>
												<td>Terakhir Aktif</td>
												<td><?PHP echo $aktif." | ".date('d F Y - H:i', strtotime($data_user['terakhir_aktif']))." WIB"; ?></td>
											</tr>
											<tr class=''>
												<td>Tanggal Daftar </td>
												<td><?PHP echo $daftar." | ".date('d F Y - H:i', strtotime($data_user['tanggal_daftar']))." WIB"; ?></td>
											</tr>
											<tr class=''>
												<td>Verify</td>
												<td><?PHP echo $status; ?></td>
											</tr>
											<tr class=''>
												<td>Status Blokir</td>
												<td><?PHP echo $status_blokir; ?></td>
											</tr>
										 </tbody>
									</table>
									<hr>
									<h3>Aksi Lainya</h3>
									<a href='<?PHP echo "info_user.php?act=reset&id=$id&csrf=$csrf"; ?>' class='btn btn-danger'>Reset Password User</a>
									<a href='<?PHP echo "info_user.php?act=clearcache&id=$id&csrf=$csrf"; ?>' class='btn btn-success'>Bersihkan Cache</a>
									<a href='<?PHP echo "info_user.php?act=blocked&id=$id&csrf=$csrf"; ?>' class='btn btn-danger'>Blokir User</a>
									<a href='<?PHP echo "info_user.php?act=unblocked&id=$id&csrf=$csrf"; ?>' class='btn btn-warning'>UnBlock User</a>
									
									<?PHP 
									//apakah sudah kirim ktp? 
									if($ada_ktp){
									?>
									<div class="btn-group">
										<a class="btn btn-inline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Lihat KTP
										</a>
										<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
											<a target='_blank' class="dropdown-item" href="<?PHP echo $d_url_ktp; ?>">Foto KTP</a>
											<a target='_blank' class="dropdown-item" href="<?PHP echo $d_url_selfi; ?>">Foto Selfi KTP</a>
										</div>
									</div>
									<?PHP } ?>
									<hr>
									<h4>Info Lainya</h4>
									<span style='color:green'>Total Topup Berhasil : <?PHP echo $app->idr($jumlah_topup_rp_real); ?> ( <?PHP echo $jumlah_topup; ?> )</span><br>
									<span style='color:red'>Total Transaksi Berhasil : <?PHP echo $app->idr($jumlah_trx_berhasil_rp[0]); ?> ( <?PHP echo $jumlah_trx_berhasil; ?> )</span><br>
									<span>Total Transaksi Gagal : <?PHP echo $app->idr($jumlah_trx_gagal_rp[0]); ?> ( <?PHP echo $jumlah_trx_gagal; ?> )</span><br>
									<span>Refund Stats : <?PHP echo $app->idr($jumlah_refund_rp[0]); ?> ( <?PHP echo $jumlah_refund; ?> )</span><br>
									<p>
									<?PHP
									$gap_saldo = $jumlah_topup_rp_real-$jumlah_trx_berhasil_rp[0];
									if($gap_saldo<0){
										$color_gap = "red";
									}else{
										$color_gap = "green";
									}
									?>
									GAP saldo => <b style='color:<?PHP echo $color_gap; ?>'><?PHP echo $app->idr($gap_saldo); ?></b>
									<hr>
									<h3>Transaksi</h3>
									<div id='top-action' style='margin-bottom:20px'>
										<span class="input-group"  style='width:30%'>
											<input class="form-control" required type="text" name="keyword" id="search_cat" placeholder='Cari Transaksi...' onkeyup='changePagination(1, "search", this.value)'>
											<span class="input-group-btn">
											<button class="btn btn-default"><i class='fa fa-search'></i></button>
											</span>
										</span>
									</div>
									<div id="pageData"></div>
									<span class="flash"></span>
									<h3>Topup</h3>
									<div id="pageData2"></div>
									<span class="flash2"></span>
								</div>
								
							</div>
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
				url: "ajax/load_transaksi.php?uid=<?PHP echo $id; ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$(".flash").hide();
					$("#pageData").html(result);
				}
			});
		}
	</script>
	<script>
	$(document).ready(function(){
		changePagination2('1', 'all', '');    
		});
		function changePagination2(page, action, q){
			$(".flash2").show();
			$(".flash2").fadeIn(400).html
			('Loading...');
			var dataString = 'page='+ page;
			dataString = dataString + '&action='+action+'&q='+q;
			$.ajax({
				type: "POST",
				url: "ajax/load_topup.php?uid=<?PHP echo $id; ?>",
				data: dataString,
				cache: false,
				success: function(result){
					$(".flash2").hide();
					$("#pageData2").html(result);
				}
			});
		}
	</script>
</body>
</html>