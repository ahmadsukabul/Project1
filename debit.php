<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_debit.php");
}else{
	$csrf = $app->csrf();
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Daftar Debit Manual - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
    <link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
	<link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class='col-md-12 col-xs-12 col-lg-12'>
					<?PHP 
                    require_once("_/_alert_message.php");
                    ?>
					<section class="card card-green mb-3">
						<header class="card-header">
							Masukan Data Debit Baru
						</header>
						<div class="card-block">
							<form action='' method='post'>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Nominal Debit Rp</label>
										<input id='nominal' name='nominal' type="text" class="form-control" placeholder="200000" required>
									</fieldset>
									
								</div>
                                <div class='col-md-4'>
                                     <fieldset class="form-group">
										<label class="form-label">Bank Debit</label>
										<select name='bank' class='form-control'>
                                            <option>BANK BRI</option>
                                            <option>BANK BNI</option>
                                            <option>BANK BCA</option>
                                            <option>BANK MANDIRI</option>
                                            <option>BANK BNI SYARIAH</option>
                                        </select>
									</fieldset>
                                </div>
                                <div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Tanggal Debit</label>
										<input name='tanggal' type="text" class="flatpickr form-control" placeholder="2019-07-21" value='<?PHP echo date("Y-m-d"); ?>' required>
									</fieldset>
								</div>
							</div>
                            <fieldset class="form-group">
								<label class="form-label">Keterangan Debit</label>
								<textarea name='keterangan' class='form-control' rows='2'></textarea>
							</fieldset>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='add'/>
							<button class='btn btn-danger'>Tambahkan</button>
							</form>
						</div>
					</section>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Semua Daftar Debit
						</header>
						<div class="card-block">
							<span class="flash"></span>
							<div id="pageData"></div>
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
				url: "ajax/load_debit.php",
				data: dataString,
				cache: false,
				success: function(result){
					$(".flash").hide();
					$("#pageData").html(result);
				}
			});
		}
	</script>
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
    <script> 
		var rupiah = document.getElementById("nominal");
		rupiah.addEventListener("keyup", function(e) {
		  // tambahkan 'Rp.' pada saat form di ketik
		  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		  rupiah.value = formatRupiah(this.value, "Rp. ");
		});

		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix) {
		  var number_string = angka.replace(/[^,\d]/g, "").toString(),
			split = number_string.split(","),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		  // tambahkan titik jika yang di input sudah menjadi angka ribuan
		  if (ribuan) {
			separator = sisa ? "." : "";
			rupiah += separator + ribuan.join(".");
		  }

		  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
		  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
		}
		
		
		var nominal =  $("#nominal");
		var btn_topup =  $("#btn_topup");
		function btn_topup_click(){
			if(nominal.val()!=""){
				btn_topup.attr('disabled', 'disabled');
				btn_topup.html("<i class='fa fa-spinner'></i> Memproses...");
				$("form").submit();
			}
		}

	</script>
</body>
</html>