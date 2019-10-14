<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
$total = $db->num_rows("select id from transaksi");
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Semua Transaksi - <?PHP echo $c_name; ?></title>
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
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Semua Transaksi
						</header>
						<div class="card-block">
							Total Transaksi : <?PHP echo $total; ?><p>
							<div id='top-action' style='margin-bottom:20px'>
								<span class="input-group"  style='width:30%'>
									<input class="form-control" required type="text" name="keyword" id="search_cat" placeholder='Enter keyword...' '>
									<span class="input-group-btn">
									<button class="btn btn-default"><i class='fa fa-search'></i></button>
									</span>
								</span>
							</div>

                            <div class="row" style="margin-left:-15px;">
                            <div class="col-lg-3 col-md-3">
									<fieldset class="form-group">
										<label class="form-label">Pilih Provinsi</label>
										<select id='provinsi' name='provinsi' class="select2 form-control">
											<option>--Pilih Provinsi--</option>
											<?PHP
											$data_provinsi = file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi");
											$data_provinsi = json_decode($data_provinsi,true);

											//ambil data dari sql
											// foreach
											//masukkand data ke arary

											// dattmp[];
											if(!$data_provinsi['error']){
												foreach($data_provinsi['semuaprovinsi'] as $provinsi){
													//data disimpan ke array juga
													echo "<option value='$provinsi[id]'>$provinsi[nama]</option>";	
													
												}

												//looping ke dua array
												//pake for 
												// 
											}
											?>
										</select>
									</fieldset>
								</div>
                            </div>
                            <!-- <span class="flashUp"></span> -->
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
        // onkeyup='changePagination(1, "search", this.value)
        $('#search_cat').focus(function()
        {
            $('#provinsi').attr('disabled', 'disabled');
        });

        $("#search_cat").change( function() {
        // your code
            var id = this.value;
            // alert(id);
            changePagination(1, "search", id);
        });
        $('#search_cat').blur(function()
        {
            $('#provinsi').removeAttr('disabled');
        });

        $('#provinsi').focus(function()
        {
            $('#search_cat').attr('disabled', 'disabled');
        });
        
        $('#provinsi').on('change', function() {
            // alert( this.value );
            var id = this.value;
            // alert(id);
            changePagination(1, "search", id);
        });

        $('#provinsi').blur(function()
        {
            $('#search_cat').removeAttr('disabled');
        });
        
        
        

		changePagination('1', 'all', '');    
	});
		function changePagination(page, action, q){
            // $(".flashUp").show();
			// $(".flashUp").fadeIn(400).html('Loading...');
			$(".flash").show();
			$(".flash").fadeIn(400).html
			('Loading...');
			var dataString = 'page='+ page;
			dataString = dataString + '&action='+action+'&q='+q;
			$.ajax({
				type: "POST",
				url: "ajax/load_user_aktif.php",
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