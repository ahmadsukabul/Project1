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
	<title>Inbox jabber - <?PHP echo $c_name; ?></title>
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
							Semua Inbox
						</header>
						<div class="card-block">
							<div id='top-action' style='margin-bottom:20px'>
								<div class='row'>
									<div class='col-md-4'>
										<fieldset>
											<label>Mulai Dari</label>
											<input id='mulai' class="flatpickr form-control" name="mulai" type="text" placeholder="Pilih tanggal.."/>
										</fieldset>
									</div>
									<div class='col-md-4'>
										<fieldset>
											<label>Sampai Dengan</label>
											<input id='sampai' class="flatpickr form-control" name='sampai' type="text" placeholder="Pilih tanggal.."/>
										</fieldset>
									</div>
									<div class='col-md-3'>
										<fieldset>
											<label>Keyword</label>
											<input id='cari' class="form-control" name='cari' type="text" placeholder="Keyword.."/>
										</fieldset>
									</div>
									<div class='col-md-1'>
										.
										<button onclick='cari()' class='btn btn-primary btn-md btn-block'><i class='fa fa-search'></i></button>
									</div>
								</div>
							</div>
							<hr>
							<div id="pageData"></div>
							<span class="flash"></span>
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
		
		changePagination('1');    
		});
		function cari(){
			changePagination(1);
		}
		function changePagination(page){
			var mulai = $("#mulai").val();
			var sampai = $("#sampai").val();
			var cari = $("#cari").val();
			$(".flash").show();
			$(".flash").fadeIn(400).html
			('Loading...');
			var dataString = 'page='+ page;
			dataString = dataString + '&mulai='+mulai+'&sampai='+sampai+'&cari='+cari;
			$.ajax({
				type: "POST",
				url: "ajax/load_jab_inbox.php",
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