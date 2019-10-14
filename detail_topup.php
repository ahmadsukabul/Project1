<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_detail_topup.php");
}
if(isset($_GET['id'])){
	$topup_id = abs((int)$_GET['id']);
	$detail_topup = $db->fetch("select 
	t.uid,t.topup_metode,t.topup_metode_kategori,t.nominal_topup,t.kode_unik,t.fee,t.total_transfer,t.nomor_rekening,t.created_at,t.expired_at,t.status,m.nama_kategori,m.nama_metode,m.gambar_metode,m.nomor_rekening,m.nama_rekening
	from topup t inner join topup_metode m 
	on t.topup_metode=m.id
	where t.id='$topup_id'
	");
	if(!isset($detail_topup['uid'])){
		exit;
	}
	$data_user = $db->fetch("select nama,nama_toko from users where id='$detail_topup[uid]'");
	$total_transfer_rp = $app->idr($detail_topup['total_transfer']);
	$topup_metode_kategori = $detail_topup['topup_metode_kategori'];
	$nama_kategori = $detail_topup['nama_kategori'];
	$uid = $detail_topup['uid'];
	$nama_metode = $detail_topup['nama_metode'];
	$topup_metode = $detail_topup['topup_metode'];
	$nominal_topup = $detail_topup['nominal_topup'];
	$kode_unik = $detail_topup['kode_unik'];
	$fee = $detail_topup['fee'];
	$total_transfer = $detail_topup['total_transfer'];
	$nomor_rekening = $detail_topup['nomor_rekening'];
	$created_at = $detail_topup['created_at'];
	$expired_at = $detail_topup['expired_at'];
	$status = $detail_topup['status'];
	$gambar_metode = $detail_topup['gambar_metode'];
	$nomor_rekening = $detail_topup['nomor_rekening'];
	$nama_rekening = $detail_topup['nama_rekening'];
	$terima_bersih = $total_transfer+$fee;
	if($topup_metode_kategori!=1){
		$terima_bersih = $total_transfer-$fee;
	}
	$hash_topup = md5("$topup_id:$uid:$topup_metode:$created_at");
	if($status==0){
		$statusnya = "<span class='label label-warning'>Menunggu Pembayaran</span>";
	}else if($status==1){
		$statusnya = "<span class='label label-success'>Sukses</span>";
	}else{
		$statusnya = "<span class='label label-danger'>Dibatalkan</span>";
	}
	$data_post = array(
		"key"=>$api_key,
		"id"=>$topup_id
	);
	$data_info = $app->curl_post("$api_url/get_topup_detail.php",$data_post);
	$data_info_array = json_decode($data_info,true);
}else{
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
	<title>Detail Topup #<?PHP echo $topup_id; ?> - <?PHP echo $c_name; ?></title>
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
							Topup #<?PHP echo $topup_id; ?>
						</header>
						<div class="card-block">
							<div class='row'>
								<div class='col-md-4'>
									<table class='table table-bordered table-hover' style='margin-bottom:20px'>
										<thead>
											<tr>
											  <th colspan=3><center>Informasi Topup</center></th>
											</tr>
										 </thead>
										 <tbody>
											<tr class=''>
												<td>ID Topup</td>
												<td>#<?PHP echo $topup_id; ?></td>
											</tr>
											<tr class=''>
												<td>User </td>
												<td><a href='info_user.php?id=<?PHP echo $detail_topup['uid']; ?>'><?PHP echo $data_user['nama']." ( $data_user[nama_toko] )"; ?></a></td>
											</tr>
											<tr class=''>
												<td>Status </td>
												<td><?PHP echo $statusnya; ?></td>
											</tr>
											<tr class=''>
												<td>Metode Pembayaran </td>
												<td><?PHP echo $nama_kategori; ?></td>
											</tr>
											<tr class=''>
												<td>Bank/Merchant </td>
												<td><?PHP echo $nama_metode; ?></td>
											</tr>
											<tr class=''>
												<td>Nominal Topup</td>
												<td><?PHP echo $app->idr($nominal_topup); ?></td>
											</tr>
											<tr class=''>
												<td>Kode unik</td>
												<td><?PHP echo $app->idr($kode_unik); ?></td>
											</tr>
											<tr class=''>
												<td>Biaya Admin</td>
												<td><?PHP echo $app->idr($fee); ?></td>
											</tr>
											<tr class=''>
												<td style='cursor:help;' title='ini adalah nominal saldo topup yang akan masuk ke akun kamu'>Nominal Saldo masuk</td>
												<td><?PHP echo $app->idr($terima_bersih); ?></td>
											</tr>
											<tr class=''>
												<td>Di buat</td>
												<td><?PHP echo $created_at; ?></td>
											</tr>
											<tr class=''>
												<td>Kadaluarsa</td>
												<td><?PHP echo $expired_at; ?></td>
											</tr>
										 </tbody>
									</table>
									<a href='detail_topup.php?act=approve&id=<?PHP echo $topup_id; ?>&hash=<?PHP echo $hash_topup; ?>' class='btn btn-success'>Terima Topup ini</a>
									<a href='detail_topup.php?act=deny&id=<?PHP echo $topup_id; ?>&hash=<?PHP echo $hash_topup; ?>' class='btn btn-danger'>Batalkan Topup ini</a>
								</div>
								<div class='col-md-8'>
									<h4>Info JSON</h4>
									<textarea rows='10' class='form-control'><?PHP echo $data_info; ?></textarea>
									<?PHP if($status==0){ //hanya muncul klu status pembayaran pending :) ?> 
									<div class='' style='cursor:default'>
										<center><h4>Cara Melakukan Pembayaran</h4></center>
										<?PHP if($topup_metode_kategori==1){ //cara pembayara melalui transfer bank ?>
										<div id='cara-bayar-id-1'>
											<div id='carabayar' class='text-center'>
												*Silahkan Transfer ke rekening di bawah ini
												<div class='col-md-6 col-xs-9 mx-auto'>
													<div class='card' style='padding:20px;padding-bottom:0px'>
														<center><h3 style='color:green'><?PHP echo $total_transfer_rp; ?></h3>
													</div>
												</div>
											</div>
											<div id='info-bank'>
												<div class='col-md-6 col-xs-12 mx-auto'>
													<div class='box' style='padding:20px;cursor:default'>
														<center><img src='<?PHP echo $gambar_metode; ?>' width='120px'/></center>
														<p style='margin-top:10px'>Bank : <b><?PHP echo $nama_metode; ?></b><br>
														Nomor Rekening : <b><?PHP echo $nomor_rekening; ?></b><br>
														Atas Nama : <b><?PHP echo $nama_rekening; ?></b><br>
													</div>
												</div>
											</div>
											<div class='alert alert-info'>
											*Mohon transfer sesuai jumlah yang tertera (tidak lebih atau kurang). 
											tiga angka unik di gunakan untuk membantu kami mendeteksi bahwa kamu yang mentransfer. 
											tenang saja, saldo kamu tetap tertambah sejumlah yang ditransfer, 
											termasuk tiga angka unik <?PHP echo $total_transfer_rp; ?>
											</div>
											<div class='alert alert-warning'>
											
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>INFO BANK OFFLINE : </strong> 
												Deposit dapat dilakukan 24 jam otomatis selama bank terkait tidak maintenance (offline). Namun layanan internet banking dari Bank BCA, BNI, Mandiri dan BRI, pada jam-jam tertentu pasti Offline / Maintenance setiap harinya. Tidak ada jadwal yang resmi dari bank kapan akan melakukan maintenance, Namun rata-rata Bank Offline antara jam 21:00 - 00:00 WIB. Sehingga transfer deposit yang dilakukan pada saat bank offline akan diproses otomatis setelah bank kembali normal.
											</div>
											*Apabila Saldo tidak masuk dalam waktu 30 menit setelah transfer, harap hubungi tim kami :)
										</div>
										<?PHP }else if($topup_metode==9){ //melalui gopay ?>
										
										<div id='carabayar' class='text-center'>
												<div class='col-md-6 col-xs-9 mx-auto'>
													<div class='card' style='padding:20px;padding-bottom:0px'>
														<center><h3 style='color:green'><?PHP echo $total_transfer_rp; ?></h3>
													</div>
												</div>
												*Silahkan Klik tombol di bawah ini untuk melakukan pembayaran<p>
												<a class='btn btn-success btn-block' href='<?PHP echo "$api_url/midtrans/gopay.php?topup_id=$topup_id&hash=$hash_topup"?>'>
												Bayar Pake GOPAY
												</a>
										</div>
										
										<?PHP }else if($topup_metode==13){ //melalui va lainya transfer atm otomatis ?>
										
										<div id='carabayar' class='text-center'>
												<div class='col-md-6 col-xs-9 mx-auto'>
													<div class='card' style='padding:20px;padding-bottom:0px'>
														<center><h3 style='color:green'><?PHP echo $total_transfer_rp; ?></h3>
													</div>
												</div>
												*Silahkan Klik tombol di bawah ini untuk melakukan pembayaran<p>
												<a class='btn btn-success btn-block' href='<?PHP echo "$api_url/midtrans/other-va.php?topup_id=$topup_id&hash=$hash_topup"?>'>
												Lanjut Ke Pembayaran
												</a>
										</div>
										
										<?PHP }else if($topup_metode==6){ //melalui bank bni va ?>
										
										<div id='carabayar' class='text-center'>
												<div class='col-md-6 col-xs-9 mx-auto'>
													<div class='card' style='padding:20px;padding-bottom:0px'>
														<center><h3 style='color:green'><?PHP echo $total_transfer_rp; ?></h3>
													</div>
												</div>
												*Silahkan Klik tombol di bawah ini untuk melakukan pembayaran<p>
												<a class='btn btn-success btn-block' href='<?PHP echo "$api_url/midtrans/bni-va.php?topup_id=$topup_id&hash=$hash_topup"?>'>
												Lanjut Ke Pembayaran
												</a>
										</div>
										
										<?PHP } ?>
										
										<div id='batalkan' class='card' style='padding:20px;margin-top:20px'>
											<center><h4>Pembatalan Topup</h4></center>
											<a href='topup_list.html?act=cancel&id=<?PHP echo $topup_id; ?>&csrf=<?PHP echo $csrf; ?>' class='btn btn-danger'>Batalkan Topup</a>
											<p>*<b>Harap Baca</b> : Jika kamu ingin membatalkan topup, pastikan kamu belum ada melakukan transfer, karna apabila kamu sudah transfer tapi tagihan
											nya kamu batalkan, otomatis uang yg kamu transfer hangus :)
										</div>
									</div>
									
									
									<?PHP }//batas pembayaran yang pending ?>
									
									
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->
	<?PHP require_once("_/js.php"); ?>
	
</body>
</html>