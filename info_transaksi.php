<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");

if(isset($_GET['id'])){
	$id = abs((int)$_GET['id']);
	$detail_transaksi = $db->fetch("select 
	t.h2h_id,t.uid,t.pembelianoperator_id,t.trx_id,t.product_name,product_code,t.nomor_tujuan,t.id_pel,t.price_client,t.selling_price_client,	t.sn,t.note,t.saldo_before_trx,t.saldo_after_trx,t.created_at,t.updated_at,t.status,o.product_name as op_name
	from transaksi t inner join p_operator o 
	on t.pembelianoperator_id=o.id
	where t.id='$id'
	");
	$h2h_id = $detail_transaksi['h2h_id'];
	$user_id = $detail_transaksi['uid'];
	$data_post = array(
		"key"=>$api_key,
		"uid"=>$user_id,
		"order_id"=>$id
	);
	$data_respon = $app->curl_post("$api_url/detail_transaksi_full.php",$data_post);
	$transaksi = json_decode($data_respon,true);
	if($transaksi['status']!=1){
		exit;
	}
	$detail_transaksi = $transaksi['data'];
	$trx_id = $detail_transaksi['trx_id'];
	$product_name = $detail_transaksi['product_name'];
	
	$product_code = $detail_transaksi['product_code'];
	$nomor_tujuan = $detail_transaksi['nomor_tujuan'];
	$id_pel = $detail_transaksi['id_pel'];
	$price_client = $detail_transaksi['price_client'];
	$selling_price_client = $detail_transaksi['selling_price_client'];
	$sn = $detail_transaksi['sn'];
	$note = $detail_transaksi['note'];
	$saldo_before_trx = $detail_transaksi['saldo_before_trx'];
	$saldo_after_trx = $detail_transaksi['saldo_after_trx'];
	$created_at = $detail_transaksi['created_at'];
	$updated_at = $detail_transaksi['updated_at'];
	$status = $detail_transaksi['status'];
	$op_name = $detail_transaksi['op_name'];
	$u_nama = $detail_transaksi['nama'];
	$u_nama_toko = $detail_transaksi['nama_toko'];
	$signature = $detail_transaksi['signature'];
	$pembelianoperator_id = $detail_transaksi['pembelianoperator_id'];
	//by produk kode we get h2h_id
	$data_produknya = $db->fetch("select * from p_pembelian_j2 where code='$product_code'");
	if($status==0){
		$statusnya = "<span class='label label-warning'>Sedang Di Proses</span>";
	}else if($status==1){
		$statusnya = "<span class='label label-success'>Sukses</span>";
	}else if($status==2){
		$statusnya = "<span class='label label-danger'>Gagal</span>";
	}else if($status==3){
		$statusnya = "<span class='label label-danger'>Gagal</span>";
	}else if($status==4){
		$statusnya = "<span class='label label-info'>Refund</span>";
	}
	$target = $nomor_tujuan;
	if($detail_transaksi['pembelianoperator_id']==18){
		//pln .. nomor jadi id_pel 
		if(!empty($detail_transaksi['sn'])){
			$sn_pecah = explode("/",$detail_transaksi['sn']);
			$nama_pel = $sn_pecah[1];
			$target = "$id_pel <b>$nama_pel</b>";
		}else{
			$target = $id_pel;
		}
	}
	if(empty($sn)){
		$sn = $note;
	}
	
	//jika status pending coba get status dari api
	/*if($status==0){
		$data_post = array(
			"key"=>$api_key,
			"trx_id"=>$trx_id
		);
		$data_respon = $app->curl_post("$api_url/cek_trx_id.php",$data_post);
	}*/
	if($status==1){
		//ini untuk dapatkan berapa lama proses nya
		$a_c = strtotime($created_at);
		$a_u = strtotime($updated_at);
		$lama_proses = $a_u - $a_c;
		$lama_menit = round($lama_proses/60);
		if($lama_proses<80){
			//ini termasuk cepat;
			$fakta_tipe = "success";
			$fakta_teks = "Tahukah kamu bahwa pembelian kamu di proses sangat cepat loh oleh bukakios, hanya dalam <b>$lama_proses detik</b>, pembelian kamu telah berhasil di proses :)
			<p><a href='go_lite_app.html' class='btn btn-warning btn-block btn-sm'><i class='font-icon font-icon-star'></i> Beri Rating</a>
			";
		}else if($lama_proses>80 and $lama_proses < 420){ //8 menit
			//agak lambat
			$fakta_tipe = "warning";
			$fakta_teks = "Kami mohon maaf ya, proses transaksi kamu kali ini sedikit lebih lambat, namun sudah berhasil kok :) , waktu proses transaksi <b>$lama_menit menit</b>";
		}else{
			//sangat lambat
			$fakta_tipe = "danger";
			$fakta_teks = "Kami mohon maaf yang sebesar-besarnya, proses transaksi kamu kali ini sangat lambat, kami akan berusaha meningkatkan layanan kami, waktu proses transaksi kamu <b>$lama_menit menit</b>";
		}
	}
	
	//action here
	if(isset($_REQUEST['act'])){
		$act = $_REQUEST['act'];
		require_once(ROOT."/_act/_info_transaksi.php");
	}
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
	<title>Detail Transaksi #<?PHP echo $id; ?> - <?PHP echo $c_name; ?></title>
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
							Order ID #<?PHP echo $id; ?>
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
											  <th colspan=3><center>Informasi Transaksi</center></th>
											</tr>
										 </thead>
										 <tbody>
											<tr class=''>
												<td>Order ID</td>
												<td>#<?PHP echo $id; ?></td>
											</tr>
											<tr class=''>
												<td>TRX ID</td>
												<td>#<?PHP echo $trx_id; ?></td>
											</tr>
											<tr class=''>
												<td>KODE PRODUK</td>
												<td><?PHP echo $product_code; ?></td>
											</tr>
											<tr class=''>
												<td>H2H ID</td>
												<td><?PHP echo $h2h_id; ?></td>
											</tr>
											<tr class=''>
												<td>Produk</td>
												<td><?PHP echo "<b>$op_name</b> - $product_name"; ?></td>
											</tr>
											<tr class=''>
												<td>Harga</td>
												<td><?PHP echo $app->idr($price_client); ?></td>
											</tr>
											<tr class=''>
												<td>Mutasi</td>
												<td><?PHP echo $app->idr($saldo_before_trx)." - ".$app->idr($price_client)." = <b>".$app->idr($saldo_after_trx)."</b>"; ?></td>
											</tr>
											<tr class=''>
												<td>Nomor Tujuan</td>
												<td><?PHP echo $target; ?></td>
											</tr>
											<tr class=''>
												<td>SN/Catatan</td>
												<td><?PHP echo $sn; ?></td>
											</tr>
											<tr class=''>
												<td>Status </td>
												<td><?PHP echo $statusnya; ?></td>
											</tr>
											
											<tr class=''>
												<td>Tanggal Pembelian</td>
												<td><?PHP echo date('d F Y - H:i', strtotime($created_at))." WIB"; // Hasil 15 February 1994$created_at; ?></td>
											</tr>
											
										 </tbody>
									</table>
									<?PHP if($status>0){require_once(ROOT."/_/additional_info_trx.php");} ?>
									<?PHP 
									if(isset($fakta_tipe)){
										echo "
										<div class='alert alert-fill alert-$fakta_tipe'>
										$fakta_teks
										</div>
										";
									}
									?>
									<hr>
									
									
									<!-- print -->
									<section class="card card-blue-fill">
												<header class="card-header">
													Mini Printer (Bluetooth)
													<button type="button" class="modal-close">
														<i class="font-icon-close-2"></i>
													</button>
												</header>
												<div class="card-block">
													<p class="card-text">
													Format struk ini hanya cocok untuk thermal printer (bluetooth printer) ukuran kertas <b>58mm - 60mm</b>
													<br>
													<?PHP 
													$bukakios_lite = false;
													if($bukakios_lite){
														$tombol_text = "Cetak Sekarang";
														$tombol_link = "print://https://member.bukakios.net/print-json/$signature/$id.json";
													}else{
														$tombol_text = "Lihat Struk";
														$tombol_link = "https://member.bukakios.net/pdf-mini/view/$signature/$id.pdf";
													}
													?>
													<a href='<?PHP echo $tombol_link; ?>' class='btn btn-success'><?PHP echo $tombol_text; ?></a>
													<?PHP if(!$bukakios_lite){ ?>
													<a href='<?PHP echo "https://member.bukakios.net/pdf-mini/download/$signature/$id.pdf"; ?>' class='btn btn-primary'>Download Struk (pdf)</a>
													<?PHP }else{ ?>
													<a href='<?PHP echo "open://https://member.bukakios.net/pdf-mini/download/$signature/$id.pdf"; ?>' class='btn btn-primary'>Download Struk (pdf)</a>
													<?PHP } ?>
													<a href='<?PHP echo "https://member.bukakios.net/print-json/$signature/$id.json"; ?>' class='btn btn-primary'>Struk Json</a>
													</p>
												</div>
											</section>
									
									<div class='row'>
										<div class='col-md-12'>
										<?PHP 
										$data_h2h = $db->fetch("select * from h2h where id_h2h='$h2h_id'");
										$mulai = $created_at;
										$sampai = "";
										$datetime = new DateTime($today);
										$datetime->modify('+1 day');
										$besok = $datetime->format('Y-m-d');
										$cari = "$product_code.$nomor_tujuan";
										$cari = str_replace(" ","",$cari);
										$data_post = array(
											"key"=>$jab_key,
											"page"=>1,
											"dari"=>$mulai,
											"sampai"=>$besok,
											"cari"=>str_replace(" ","",$product_code),
											"cari2"=>str_replace(" ","",$nomor_tujuan),
											"limit"=>10
										);
										$url_query = http_build_query($data_post);
										$datas = $app->grab_data("$jab_url/api_Km86xL/inbox2.php?$url_query");
										//echo "$jab_url/api_Km86xL/inbox.php?$url_query";
										$datanya = json_decode($datas,true);
										?>
										<h4>Untuk komplain di sini infonya!!</h4>
										<hr>
										<div class='alert alert-warning'>
										Gunakan ini untuk komplain, seperti sn salah, minta refund, transaksi pending lebih 3 menit, dll
										</div>
										Kontak Telegram CS H2H => <a target='_blank' href='https://t.me/<?PHP echo $data_h2h['telegram_h2h']; ?>'>@<?PHP echo $data_h2h['telegram_h2h']; ?></a>
										<p>
										Inbox Jabber Untuk Transaksi ini
										: <br>
										
										<table id='table-edit2' class="table table-hover table-bordered">
										  <thead> 
											<tr>
											  <th>No</th>
											  <th>From</th>
											  <th>Isi Pesan</th>
											  <th>Tanggal</th>
											</tr>
										  </thead>
										  <tbody>
										   <?PHP
											$no=1;
											$data_art = $datanya['data'];
											foreach ($data_art as $data){
										   ?>
										   <tr>
											  <td><?PHP echo $no; ?></td>
											  <td><?PHP echo $data['from']; ?></td>
											  <td><?PHP echo $data['message_inbox']; ?></td>
											  <td><?PHP echo $app->time_ago($data['created_at'])." | ".date('d F Y - H:i', strtotime($data['created_at']))." WIB"; ?></td>
											</tr>
										   <?PHP
											$no++;
											}
										   ?>
										  </tbody>
										</table>
										
										<hr>
										<h4>Rubah SN?</h4>
										<fieldset class="form-group">
											<form action='' method='post'>
											<label class="form-label" for="sn_baru">Masukan SN Baru</label>
											<input value='<?PHP echo $sn; ?>' id="sn_baru" name="sn" type="text" class="form-control" placeholder="" required="" aria-label="08xx">
											<button class='btn btn-success'>Simpan</button>
											<input type='hidden' name='act' value='update_sn'/>
											<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
											</form>
										</fieldset>
										<?PHP if($status==0){ ?>
										<h4>Buat Jadi Sukses?</h4>
										<fieldset class="form-group">
											<form action='' method='post'>
											<div class='alert alert-danger'>
												Jangan gunakan fitur ini sembarangan!!!
											</div>
											<button class='btn btn-success'>Jadikan Sukses</button>
											<input type='hidden' name='act' value='success'/>
											<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
											</form>
										</fieldset>
										<?PHP } ?>
										</div>
									</div>
									
								</div>
								
							</div>
						</div>
					</section>
				</div>
			</div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->
	<?PHP require_once("_/js.php"); ?>
	<script src="<?PHP echo "$c_url/js/lib/notie/notie.js"; ?>"></script>
	<script src="<?PHP echo "$c_url/js/me/copy.js"; ?>"></script>
</body>
</html>