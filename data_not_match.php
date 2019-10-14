<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("grafik/lib_db.php");
require_once("grafik/lib_matching.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");

$db = new second_db();
$conn = new Lib_matching();
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
    <link rel="stylesheet" href="css/separate/vendor/bootstrap-daterangepicker.min.css">
    <link rel="stylesheet" href="css/lib/clockpicker/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/lib/prism/prism.css">
    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/lib/datatables-net/datatables.min.css">
    <link rel="stylesheet" href="css/separate/vendor/datatables-net.min.css">
	<title>Jabber Outbox - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>

	
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div id="pageData" class="col-lg-12 col-md-12">
					<section class="tabs-section">
						<div class="tabs-section-nav tabs-section-nav-inline">
							<ul class="nav" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
										Data not match
									</a>
								</li>
								
							</ul>
						</div><!--.tabs-section-nav-->

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active show" id="tabs-4-tab-1">
							<form id="formDateRange" method="post" action="data_not_match.php">
								<div class="row">
									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label" for="exampleInput">Start</label>
											<input class="form-control flatpickr flatpickr-input start" name="start" data-enable-time="true" data-enable-seconds="true" readonly="readonly" data-date-format="d/m/Y">
											<!-- <input class="form-control flatpickr flatpickr-input" name="start" readonly="readonly" data-date-format="d/m/Y"> -->
											
										</fieldset>

									</div>
									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label" for="exampleInput">End</label>
											<!-- <input class="form-control flatpickr flatpickr-input end" name="end" data-enable-time="true" data-enable-seconds="true" readonly="readonly"> -->
											<input class="form-control flatpickr flatpickr-input" name="end" readonly="readonly" data-date-format="d/m/Y">
											
										</fieldset>

									</div>
									<div class="col-md-4">
									
										<fieldset class="form-group">
											<label class="form-label" for="exampleInput">H2H import</label>
											<input class="form-control flatpickr flatpickr-input" name="h2h" readonly="readonly" data-date-format="d/m/Y">
											
										</fieldset>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-4">
										<button class="btn btn-primary"  style="margin-bottom:10px;" id="btnSubmitDateRange">Submit</button>
									</div>
										</form>
								</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="card text-white bg-danger mb-3" style="width: 18rem; background-color:#00a8ff; color:white">
									<div class="card-body">
									<h5 class="card-title" style="font-size:16px;">Total not match</h5>
										<div class="chart-txt-top">
											<p><span class="number">0</span></p>
											<p class="caption"></p>
										</div>
									</div>
								</div>
								</div>
							</div>
							
							</div><!--.tab-pane-->
							
							

						</div><!--.tab-content-->
					</section><!--.tabs-section-->

				

				</div>
				<span class="flash"></span>
	        </div>

			<div id="pageData">
				<div class="row">
					<div class="col-lg-12">
					<section class="tabs-section">
						<div class="tabs-section-nav tabs-section-nav-inline">
							<ul class="nav" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
										Data filter not match
									</a>
								</li>
								
							</ul>
						</div><!--.tabs-section-nav-->

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active show" id="tabs-4-tab-1">
							<table id="example" class="display" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Tanggal transaksi</th>
										<th>Kode produk</th>
										<th>Status</th>
										<th>No tujuan</th>
									</tr>
								</thead>
								<tbody>
									<?php  
			
										if (isset($_POST['start']) && isset($_POST['end']) && isset($_POST['h2h'])  )
										{
											echo $start= $_POST['start'];
											echo $end = $_POST['end'];

											// echo $date = date('d/m/Y h:m:s');
											echo $h2h = $_POST['h2h'];

											$alldata = $conn->fetch_h2h($h2h);
											// $minus = 0;
											$notmatch = 0;
											// // $dataminus = array();
											// $datamatch = array();
											foreach ($alldata as $hasil)
											{
												$a = $hasil['kd_produk'];
												$b = $hasil['no_tujuan'];
												$c = $hasil['tgl_transaksi'];
												$d = $hasil['status'];

												$id = $hasil['id'];
												
										
												//cari data yang sesuai di tbl bk
												$databk = $conn->banding_bk_h2h($a, $b, $start, $end);
												if ($databk <= 0)
												{
													echo "<br/>";
													echo $id." dan ".$a." dan ".$b." data tidak match<br/>";
													$notmatch++;

													//jika data tidak match insert to tbl_not_match
													// $conn->insert_not_match($c, $a, $d, $b);
												}
											}
										}
										else{
											$datafilter = "";
										}
										
									?>
								</tbody>
							</table>
							</div>

						</div><!--.tab-content-->
					</section><!--.tabs-section-->
					</div>
				</div>
			</div>

			<div id="pageData">
				<div class="row">
					<div class="col-lg-12">
					<section class="tabs-section">
						<div class="tabs-section-nav tabs-section-nav-inline">
							<ul class="nav" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
										Data not match
									</a>
								</li>
								
							</ul>
						</div><!--.tabs-section-nav-->

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active show" id="tabs-4-tab-1">
							<table id="examples" class="display" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Tanggal transaksi</th>
										<th>Kode produk</th>
										<th>Status</th>
										<th>No tujuan</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no = 1;
										$data = $db->fetch("SELECT * FROM tbl_not_match");	
										foreach($data as $row) : 
									?>
									<tr>
										<td><?= $no++?></td>
										<td><?= $row['tgl_transaksi'] ?></td>
										<td><?= $row['kd_produk'] ?></td>
										<td><?= $row['status'] ?></td>
										<td><?= $row['no_tujuan'] ?></td>
									</tr>
									<?php endforeach;	 ?>
								</tbody>
							</table>
							</div>

						</div><!--.tab-content-->
					</section><!--.tabs-section-->
					</div>
				</div>
			</div>


	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	<script src="js/lib/jquery/jquery-3.2.1.min.js"></script>

	<script src="js/lib/popper/popper.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>
		
		<script src="js/lib/datatables-net/datatables.min.js"></script>
	<script type="text/javascript" src="js/lib/moment/moment-with-locales.min.js"></script>
	<script type="text/javascript" src="js/lib/flatpickr/flatpickr.min.js"></script>
	<script src="js/lib/clockpicker/bootstrap-clockpicker.min.js"></script>
	<script src="js/lib/clockpicker/bootstrap-clockpicker-init.js"></script>
	<script src="js/lib/daterangepicker/daterangepicker.js"></script>
	<script src="js/lib/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="js/lib/prism/prism.js"></script>
	<script>
		$(function() {
            $('#example').DataTable();
            $('#examples').DataTable();
			function cb(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
			cb(moment().subtract(29, 'days'), moment());

			$('#daterange').daterangepicker({
				"timePicker": true,
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				"linkedCalendars": false,
				"autoUpdateInput": false,
				"alwaysShowCalendars": true,
				"showWeekNumbers": true,
				"showDropdowns": true,
				"showISOWeekNumbers": true
			});

			$('#daterange2').daterangepicker();

			$('#daterange3').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true
			});

			$('#daterange').on('show.daterangepicker', function(ev, picker) {
				/*$('.daterangepicker select').selectpicker({
					size: 10
				});*/
			});

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
