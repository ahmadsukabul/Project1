<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_beli.php");
}else{
	$csrf = $app->csrf();
}
if($admin_user_id!=0){
	$data_user = $db->fetch("select nama,email,hp,saldo,id from users where id='$admin_user_id'");
}else{
	$msg_tipe="danger";
	$msg_title="Akun Belum Terkoneksi!!";
	$msg_content="Maaf!, sepertinya akun member kamu belum terkoneksi ke akun bukakios!!, silahkan kontak admin agar bisa melakukan pembelian melalui halaman admin ini :)";
	require_once("_/msg.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Beli & Bayar - <?PHP echo $c_name; ?></title>
	<link rel="stylesheet" href="css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="css/separate/vendor/select2.min.css">
	<?PHP require_once("_/css.php")?>
	<style>
	.img-produk{
		max-height:80px;
	}
	</style>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class='col-md-12 col-lg-12 col-sm-12'>
					<div class='box-typical box-typical-padding'>
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
							
							<div class='row'>
								
								<div class='col-md-5 col-lg-5'>
									<h4>Detail Akun Terhubung</h4>
									<section class="widget widget-tabs-compact">
										<div class="tab-content widget-tabs-content">
											<div class="tab-pane active" id="w-4-tab-1" role="tabpanel">
												<div class="user-card-row">
													<div class="tbl-row">
														<div class="tbl-cell tbl-cell-photo tbl-cell-photo-64">
															<a href="#">
																<img src="img/avatar-1-128.png" alt="">
															</a>
														</div>
														<div class="tbl-cell">
															<p class="user-card-row-name font-16"><a href="info_user.php?id=<?PHP echo $data_user['id']; ?>"><?PHP echo $data_user['nama']; ?> [U<?PHP echo $data_user['id']; ?>]</a></p>
															<p class="user-card-row-mail font-14"><a href="info_user.php?id=<?PHP echo $data_user['id']; ?>"><?PHP echo $data_user['email']; ?> - </a></p>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="w-4-tab-2" role="tabpanel">
												<center>Content 2</center>
											</div>
											<div class="tab-pane" id="w-4-tab-3" role="tabpanel">
												<center>Content 3</center>
											</div>
										</div>
										<div class="widget-tabs-nav colored">
											<ul class="tbl-row" role="tablist">
												<li class="nav-item">
													<a class="nav-link green active" data-toggle="tab" href="#w-4-tab-1" role="tab">
														<i class="font-icon font-icon-wallet"></i>
														<?PHP echo $app->idr($data_user['saldo']); ?>
													</a>
												</li>
												<li class="nav-item">
													<a class="nav-link orange" data-toggle="tab" href="#w-4-tab-2" role="tab">
														<i class="font-icon font-icon-notebook-lines"></i>
														0
													</a>
												</li>
											</ul>
										</div>
									</section>
								</div>
							</div>
							<h3>Mau Beli Apa Hari ini?</h3>
							<div class='row'>
								<div class='col-md-12 col-lg-12'>
									<section class="tabs-section">
										<div class="tabs-section-nav tabs-section-nav-icons">
											<div class="tbl">
												<ul class="nav" role="tablist">
													<li class="nav-item">
														<a class="nav-link active show" href="#tabs-1-tab-1" role="tab" data-toggle="tab" aria-selected="true">
															<span class="nav-link-in">
																<i class="fa fa-mobile-phone "></i>
																Pulsa
															</span>
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab" aria-selected="false">
															<span class="nav-link-in">
																<span class="fa fa-flash"></span>
																Token Listrik
															</span>
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab" aria-selected="false">
															<span class="nav-link-in">
																<i class="fa fa-edge"></i>
																Paket Data
															</span>
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" href="#tabs-1-tab-4" role="tab" data-toggle="tab" aria-selected="false">
															<span class="nav-link-in">
																<i class="fa fa-phone"></i>
																Paket Nelpon
															</span>
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" href="#tabs-1-tab-5" role="tab" data-toggle="tab" aria-selected="false">
															<span class="nav-link-in">
																<i class="fa fa-envelope-o"></i>
																Paket SMS
															</span>
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" href="#tabs-1-tab-6" role="tab" data-toggle="tab" aria-selected="false">
															<span class="nav-link-in">
																<i class="fa fa-gamepad"></i>
																Voucher Game
															</span>
														</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" href="#tabs-1-tab-7" role="tab" data-toggle="tab" aria-selected="false">
															<span class="nav-link-in">
																<i class="fa fa-motorcycle"></i>
																Ojek Online
															</span>
														</a>
													</li>
												</ul>
											</div>
										</div><!--.tabs-section-nav-->

										<div class="tab-content">
											<div role="tabpanel" class="tab-pane fade in active show" id="tabs-1-tab-1">
												<div class='row'>
												<div class='col-md-6'>
														<form action='' method='post'>
															<fieldset class="form-group">
																<label class="form-label" for="pulsa_nomor">Masukan Nomor</label>
																<input id='pulsa_nomor' name='pulsa_nomor' type="number" class="form-control" placeholder="08xx" required>
															</fieldset>
															<div class="row">
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="pulsa_operator">Pilih Operator </label>
																		<select id='pulsa_operator' name='pulsa_operator' class='form-control'>
																			<option value=0>Masukan Nomor dulu ...</option>
																			
																		</select>
																	</fieldset>
																</div>
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="pulsa_produk">Pilih Produk </label>
																		<select id='pulsa_produk' name='pulsa_produk' class='form-control'>
																			<option value=0>Masukan nomor dulu ...</option>
																		</select>
																	</fieldset>
																</div>
															</div>
															
															<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
															<input type='hidden' name='act' value='pulsa'/>
															<button id='beli_pulsa' class='btn btn-primary'>Beli</button>
														</form>
													</div>
													<div class='col-md-6' style='line-height:1.5'>
														<div style='margin-top:20px'>
														<center>PULSA ALL OPERATOR
															<br>*Pastikan Input No.Pengisian dengan benar<br/>
															<div id='logo' style='margin-top:30px'>                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>axis.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>smartfren.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>telkomsel.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>tri.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>indosat.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>xl.png">
															</div>																											</center>
														</div>
													</div>
												</div>
											</div><!--.tab-pane-->
											<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
												<form action='' method='post'>
													<div class='row'>
														<div class='col-md-6'>
															<fieldset class="form-group">
																<label class="form-label" for="token_nomor">Masukan Nomor PLN *</label>
																<input name='token_nomor' type="number" class="form-control" placeholder="31245122709" required>
																
															</fieldset>
															<fieldset class="form-group">
																<label class="form-label" for="token_produk">Pilih Nominal </label>
																<select id='token_produk' name='token_produk' class='form-control'>
																	<option value=0>Silahkan Pilih ...</option>
																	<?PHP 
																	$data_token_all = $db->fetch_multiple("select id,product_name,price,price_add,status from p_pembelian_j2 where pembeliankategori_id=4");
																	foreach($data_token_all as $data){
																		
																		$token_price = $app->idr($data['price']+$data['price_add']);
																		$token_name = $data['product_name'];
																		if($data['status']==1){
																			echo "<option value='$data[id]'>$token_name ($token_price)</option>";
																		}else{
																			echo "<option style='color:red' value='$data[id]' disabled>$token_name ($token_price) *Gangguan*</option>";
																		}
																		
																	}
																	?>
																</select>
															</fieldset>
															<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
															<input type='hidden' name='act' value='token'/>
															<button id='beli_token' class='btn btn-primary'>Beli</button>
														</div>
														
														<div class='col-md-6'>
															<div style='margin-top:20px'>
																<center>
																	TOKEN LISTRIK<p>
																	*Pastikan Input No. Meter/ID. Pelanggan dengan benar
																	<img src='https://i.pinimg.com/originals/93/78/00/93780002d0b28e8f0f423d355bd9ce64.jpg' height='150px'/>
																</center>
															</div>
														</div>
													</div>
												</form>
											</div><!--.tab-pane-->
											<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">
												<div class='row'>
												<div class='col-md-6'>
														<form action='' method='post'>
															<fieldset class="form-group">
																<label class="form-label" for="paket_nomor">Masukan Nomor</label>
																<input id='paket_nomor' name='paket_nomor' type="number" class="form-control" placeholder="08xx" required>
															</fieldset>
															<div class="row">
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="paket_operator">Pilih Operator</label>
																		<select id='paket_operator' name='paket_operator' class='form-control'>
																			<option value=0>Masukan Nomor dulu ...</option>
																			
																		</select>
																	</fieldset>
																</div>
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="paket_produk">Pilih Produk </label>
																		<select id='paket_produk' name='paket_produk' class='form-control'>
																			<option value=0>Masukan nomor dulu ...</option>
																		</select>
																	</fieldset>
																</div>
															</div>
															
															<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
															<input type='hidden' name='act' value='paket'/>
															<button id='beli_paket' class='btn btn-primary'>Beli</button>
														</form>
													</div>
													<div class='col-md-6' style='line-height:1.5'>
														<div style='margin-top:20px'>
														<center>Paket Data ALL OPERATOR
															<br>*Pastikan Input No.Pengisian dengan benar<br/>
															
																
															<div id='logo' style='margin-top:30px'>                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>axis.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>smartfren.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>telkomsel.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>tri.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>indosat.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>xl.png">
																<img style='height:70px' class="img-produk" src="https://s3-ap-southeast-1.amazonaws.com/asset1.gotomalls.com/uploads/retailers/logo/LXXBWNt5ILCfexHw-394-bolt-1435139847_1.png">
															</div>																											</center>
														</div>
													</div>
												</div>
											</div><!--.tab-pane-->
											<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-4">
												<div class='row'>
												<div class='col-md-6'>
														<form action='' method='post'>
															<fieldset class="form-group">
																<label class="form-label" for="nelpon_nomor">Masukan Nomor</label>
																<input id='nelpon_nomor' name='nelpon_nomor' type="number" class="form-control" placeholder="08xx" required>
															</fieldset>
															<div class="row">
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="nelpon_operator">Pilih Operator </label>
																		<select id='nelpon_operator' name='nelpon_operator' class='form-control'>
																			<option value=0>Masukan Nomor dulu ...</option>
																			
																		</select>
																	</fieldset>
																</div>
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="nelpon_produk">Pilih Produk </label>
																		<select id='nelpon_produk' name='nelpon_produk' class='form-control'>
																			<option value=0>Masukan nomor dulu ...</option>
																		</select>
																	</fieldset>
																</div>
															</div>
															
															<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
															<input type='hidden' name='act' value='nelpon'/>
															<button id='beli_nelpon' class='btn btn-primary'>Beli</button>
														</form>
													</div>
													<div class='col-md-6' style='line-height:1.5'>
														<div style='margin-top:20px'>
														<center>Paket Nelpon
															<br>*Pastikan Input No.Pengisian dengan benar<br/>
															
																
															<div id='logo' style='margin-top:30px'>
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>telkomsel.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>tri.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>indosat.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>xl.png">
															</div>																											</center>
														</div>
													</div>
												</div>
											</div><!--.tab-pane-->
											
											<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-5">
												<div class='row'>
												<div class='col-md-6'>
														<form action='' method='post'>
															<fieldset class="form-group">
																<label class="form-label" for="sms_nomor">Masukan Nomor</label>
																<input id='sms_nomor' name='sms_nomor' type="number" class="form-control" placeholder="08xx" required>
															</fieldset>
															<div class="row">
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="sms_operator">Pilih Operator </label>
																		<select id='sms_operator' name='sms_operator' class='form-control'>
																			<option value=0>Masukan Nomor dulu ...</option>
																			
																		</select>
																	</fieldset>
																</div>
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="sms_produk">Pilih Produk </label>
																		<select id='sms_produk' name='sms_produk' class='form-control'>
																			<option value=0>Masukan nomor dulu ...</option>
																		</select>
																	</fieldset>
																</div>
															</div>
															
															<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
															<input type='hidden' name='act' value='sms'/>
															<button id='beli_sms' class='btn btn-primary'>Beli</button>
														</form>
													</div>
													<div class='col-md-6' style='line-height:1.5'>
														<div style='margin-top:20px'>
														<center>Paket SMS
															<br>*Pastikan Input No.Pengisian dengan benar<br/>
															
																
															<div id='logo' style='margin-top:30px'>
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>telkomsel.png">
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>indosat.png">
																
															</div>																											</center>
														</div>
													</div>
												</div>
											</div>
											
											<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-6">
												<div class='row'>
												<div class='col-md-6'>
														<form action='' method='post'>
															<fieldset class="form-group">
																<label class="form-label" for="game_nomor">Masukan Nomor</label>
																<input id='game_nomor' name='game_nomor' type="number" class="form-control" placeholder="08xx" required>
															</fieldset>
															<div class="row">
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="game_operator">Pilih Operator </label>
																		<select id='game_operator' name='game_operator' class="select2 select2-photo">
																			<option data-photo='https://cdn.iconscout.com/icon/free/png-256/play-game-675401.png' value=0>Silahkan Pilih ...</option>
																			<option data-photo='https://cdn.dribbble.com/users/406895/screenshots/1285787/googleplay.png' value=106>Voucher Google Play ID</option>
																			<option data-photo='https://cdn.dribbble.com/users/406895/screenshots/1285787/googleplay.png' value=7>Voucher Google Play US</option>
																			<option data-photo='https://images.apple.com/sg/itunes/corporatesales/images/itunes-gifts-for-business-hero.jpg' value=16>iTunes Gift Card</option>
																			<?PHP
																			
																			$data_game_all = $db->fetch_multiple("select id,product_name from p_operator WHERE `pembeliankategori_id` = 3");
																			foreach($data_game_all as $game){
																				echo "<option data-photo='http://www.blog.pickaboo.com/wp-content/uploads/2017/12/Xbox.png' value='$game[id]'>$game[product_name]</option>";
																			}
																			?>
																		</select>
																		
																		
																	</fieldset>
																</div>
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="game_produk">Pilih Produk </label>
																		<select id='game_produk' name='game_produk' class='form-control'>
																			<option value=0>Pilih Operator Game dulu ...</option>
																		</select>
																		
																	</fieldset>
																</div>
															</div>
															
															<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
															<input type='hidden' name='act' value='game'/>
															<button id='beli_game' class='btn btn-primary'>Beli</button>
														</form>
													</div>
													<div class='col-md-6' style='line-height:1.5'>
														<div style='margin-top:20px'>
														<center>Voucher Game
															<br>*Pastikan Input No.Pengisian dengan benar<br/>
															
																
															<div id='logo' style='margin-top:30px'>
																<img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>asiasoft.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>garena.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>gemscool.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>steam.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>digicash.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>matchmove.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>iahgames.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>zynga.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>spin.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>google-play.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>itunes.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>wavegame.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>megaxus.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>lyto.png">
                                                        <img class="img-produk" src="<?PHP echo "$assets_url/img/produk/"; ?>cabal.png">
															</div>																											</center>
														</div>
													</div>
												</div>
											</div>
											
											<div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-7">
												<div class='row'>
												<div class='col-md-6'>
														<form action='' method='post'>
															<fieldset class="form-group">
																<label class="form-label" for="ojek_nomor">Masukan Nomor *</label>
																<input id='ojek_nomor' name='ojek_nomor' type="number" class="form-control" placeholder="08xx" required>
															</fieldset>
															<div class="row">
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="ojek_operator">Pilih Operator </label>
																		<select id='ojek_operator' name='ojek_operator' class="form-control">
																			<option value=0>Silahkan Pilih ...</option>
																			<option value=6>GOJEK CUSTOMER</option>
																			<option value=105>GOJEK DRIVER</option>
																			<option value=8>GRAB CUSTOMER</option>
																		</select>
																		
																		
																	</fieldset>
																</div>
																<div class="col-lg-6 col-md-6">
																	<fieldset class="form-group">
																		<label class="form-label" for="ojek_produk">Pilih Produk </label>
																		<select id='ojek_produk' name='ojek_produk' class='form-control'>
																			<option value=0>Pilih Operator Ojek dulu ...</option>
																		</select>
																		
																	</fieldset>
																</div>
															</div>
															
															<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
															<input type='hidden' name='act' value='ojek'/>
															<button id='beli_ojek' class='btn btn-primary'>Beli</button>
														</form>
													</div>
													<div class='col-md-6' style='line-height:1.5'>
														<div style='margin-top:20px'>
														<center>Saldo Ojek Online
															<br>*Pastikan Input No.Pengisian dengan benar<br/>
															
																
															<div id='logo' style='margin-top:30px'>
																<img class="img-produk" style='height:100px' src="https://i1.wp.com/yangcanggih.com/wp-content/uploads/2017/07/GoJek.jpg?resize=960%2C492&ssl=1">
																<img class="img-produk"  style='height:100px' src="https://vectorlogo4u.com/wp-content/uploads/2018/09/grqab-vector-logo-720x340.png">
					
															</div>																											</center>
														</div>
													</div>
												</div>
											</div>
											
										</div><!--.tab-content-->
									</section>
								</div>
								
							</div>
					</div>
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	<script type='text/javascript' src='js/me/beli.js'></script>
	<script type='text/javascript' src='js/me/paket.js'></script>
	<script type='text/javascript' src='js/me/nelpon.js'></script>
	<script type='text/javascript' src='js/me/sms.js'></script>
	<script type='text/javascript' src='js/me/game.js'></script>
	<script type='text/javascript' src='js/me/ojek.js'></script>
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

	</script>
	<script src="js/lib/bootstrap-notify/bootstrap-notify.min.js"></script>
	
	<?PHP
	if(isset($_GET['s'],$_SERVER['HTTP_REFERER'])){
	?>
	<script>
		$.notify({
            icon: 'font-icon font-icon-check-circle',
            title: '<strong>Berhasil!</strong>',
            message: '<?PHP echo $_SESSION['success_msg']; ?>'
        },{
            type: 'success'
        });
		
	</script>
	<?PHP
	}
	?>
	
	<?PHP
	if(isset($_GET['e'],$_SERVER['HTTP_REFERER'])){
	?>
	<script>
		
		$.notify({
            icon: 'font-icon font-icon-warning',
            title: '<strong>Ada Masalah!</strong>',
            message: '<?PHP echo $_SESSION['error_msg']; ?>'
        },{
            type: 'danger'
        });
	</script>
	<?PHP
	}
	?>
	
</body>
</html>