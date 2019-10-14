<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php"); //hanya level 1=admin

//set filter
if(isset($_POST['p_kategori'])){
	$_SESSION['p_kategori'] = $_POST['p_kategori'];
	$_SESSION['p_operator'] = $_POST['p_operator'];
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Produk Detail (Harga) - <?PHP echo $c_name; ?></title>
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
							Set Filternya
						</header>
						<div class="card-block">
							<form action='' method='post'>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label" for="p_kategori">Pilih Produk Utama</label>
										<select required id='p_kategori' name='p_kategori' class='form-control'>
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
										<label class="form-label" for="tipe_produk">Pilih Operator</label>
										<select required id='p_operator' name='p_operator' class='form-control'>
											
										</select>
									</fieldset>
								</div>
							</div>
							<button class='btn btn-primary'>Set Filter</button>
							</form>
							
						</div>
					</section>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Detail Produk (Bisa multi dan reward poin)
						</header>
						<div class="card-block">
							<?PHP
							if(isset($_SESSION['p_kategori'],$_SESSION['p_operator'])){
								$p_kategori = $_SESSION['p_kategori'];
								$p_operator = $_SESSION['p_operator'];
								?>
								
								
								<table id="table-edit" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="1">ID</th>
											<th width="1">Kode</th>
											<th>Nama Produk</th>
											<th>Harga Jual</th>
											<th>Keuntungan</th>
											<th title='bisa multi transaksi di hari yang sama'>Bisa Multi?</th>
											<th title='jumlah poin yang di dapatkan saat membeli produk ini'>Reward Poin</th>
										</tr>
									</thead>
									<tbody>
								
								<?PHP
								$semua_data = $db->fetch_multiple("select * from p_pembelian_j2 where pembelianoperator_id='$p_operator' order by price ASC");
								foreach($semua_data as $data){
									if($data['status']==1){
										$status = "<span class='label label-success'>Tersedia</span>";
									}else{
										$status = "<span class='label label-danger'>Gangguan</span>";
									}
									$harga_modal = $data['price'];
									$ambil_untung = $data['price_add'];
									$price_sell = $data['price_sell'];
									$harga_jual = $harga_modal+$ambil_untung;
								?>
								
								<tr>
									<td><?PHP echo $data['id']; ?></td>
									<td><?PHP echo $data['code']; ?></td>
									<td><?PHP echo $data['product_name']; ?></td>
									<td><?PHP echo $app->idr($harga_jual); ?></td>
									<td><?PHP echo $data['price_add']; ?></td>
									<td><?PHP echo $data['bisa_multi']; ?></td>
									<td><?PHP echo $data['reward_poin']; ?></td>
								</tr>
							
							
								<?PHP
								}
							}else{
								echo "harap pilih filter dulu :)";
							}
							?>
						</div>
					</section>
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	
	<script src="js/lib/peity/jquery.peity.min.js"></script>
	<script src="js/lib/table-edit/jquery.tabledit.min.js"></script>
	<script>
		$(document).ready(function($) {
		  var list_target_id = 'p_operator'; //first select list ID
		  var list_select_id = 'p_kategori'; //second select list ID
		  var initial_target_html = '<option value="0">Pilih Produk kategori dulu...</option>'; //Initial prompt for target select
		 
		  $('#'+list_target_id).html(initial_target_html); //Give the target select the prompt option
		 
		  $('#'+list_select_id).change(function(e) {
			//Grab the chosen value on first select list change
			var selectvalue = $(this).val();
		 
			//Display 'loading' status in the target select list
			$('#'+list_target_id).html('<option value="">Loading...</option>');
		 
			if (selectvalue == "") {
				//Display initial prompt in target select if blank value selected
			   $('#'+list_target_id).html(initial_target_html);
			} else {
			  //Make AJAX request, using the selected value as the GET
			  $.ajax({url: 'ajax/load_option_operator.php?p_kategori='+selectvalue,
					 success: function(output) {
						//alert(output);
						$('#'+list_target_id).html(output);
					},
				  error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + " "+ thrownError);
				  }});
				}
			});
		});
		
		$('#table-edit').Tabledit({
				url: 'ajax/update_harga_produk3.php',
				columns: {
					identifier: [0, 'id'],
					editable: [[5, 'bisa_multi'], [6, 'reward_poin']]
				}
			});
	</script>
</body>
</html>