<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php"); //$today 2019-08-20 
require_once("_/_session.php");
$yesterday = date('Y-m-d',strtotime("-1 days"));
$jumlah_daftar_hari_ini = $db->num_rows("select id from users where tanggal_daftar like '%$today%'"); //angka 40
$jumlah_daftar_kemarin = $db->num_rows("select id from users where tanggal_daftar like '%$yesterday%'");
$jumlah_daftar_hari_ini = 150;
$jumlah_daftar_kemarin = 100;
if($jumlah_daftar_hari_ini>$jumlah_daftar_kemarin){
	$daftar_indikasi = "up";
	$hari_ini_persen = ($jumlah_daftar_hari_ini-$jumlah_daftar_kemarin)/$jumlah_daftar_hari_ini*100;
	/*
	(jumlah kemarin - hari ini) * jumlah kemarin / 100
	kemarin : 120
	hari ini : 90 -10%
	
	*/
}else{
	$daftar_indikasi = "down";
	$hari_ini_persen = ($jumlah_daftar_kemarin-$jumlah_daftar_hari_ini)/$jumlah_daftar_kemarin*100;
}
$hari_ini_persen = round($hari_ini_persen,0);
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Dashboard - <?PHP echo $c_name; ?></title>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/series-label.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<?PHP require_once("_/css.php")?>

	<style>
		#graphTransaksi {
			/* min-width: 310px; */
			/* max-width: 800px; */
			height: 500px;
			/* margin: 0 auto */
		}
		.hideGrafikTransaksi {
			margin-top:10px; 
		}
		.hideGrafikTransaksi:hover {
			padding:10px;
			/* margin-bottom:20px; */
		}
		#qT:hover {
			font-size:15px;
		}

		.upHover:hover {
			margin-bottom:10px;
		}

	</style>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	
	    <div class="container-fluid">

			<div class="row" >
				<div class="col-lg-12" style="background-color:#d8e2e7; border-radius:5px; height:80px; position:fixed; overflow-x: hidden;  z-index: 1000; overflow-y: auto; margin-top:-28px;">
					<ul style="margin-top:10px;">
						<li style="display:inline"> <a href="#pageGraphTransaksi" class="badge badge-primary bhideGrafikTransaksi" style="margin-top:10px;">#Grafik Transaksi</a></li>
						<li style="display:inline;" class="upHover"><a href="#pageGraphProfit" class="badge " style="background:#a36dec; color:white;  margin-bottom:20px;">#Grafik Profit</a></li>
					</ul>
				</div>
			</div>


	        <div class="row" style="margin-top:100px;" id="pageGraphTransaksi">
	            <div class="col-xl-12">
	                <div class="row">
	                    <div class="col-sm-4">
	                        <article class="statistic-box green">
	                            <div>
	                                <div class="number showTransaksiSukses">0</div>
	                                <div class="caption"><div>Transaksi sukses</div></div>
	                                <!-- <div class="percent">
	                                    <div class="arrow">  </div>
	                                    <p></p>
	                                </div> -->
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                    <div class="col-sm-4">
	                        <article class="statistic-box red">
	                            <div>
	                                <div class="number showTransaksiGagal">0</div>
	                                <div class="caption"><div>Transaksi gagal</div></div>
	                            
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                    
	                </div><!--.row-->
			
				

	            </div><!--.col-->
	       
		   </div><!--.row-->
		   <div class="row" >
                <div id="pageData" class="col-lg-12 col-md-12">
                <section class="tabs-section">
				
				<div class="tabs-section-nav tabs-section-nav-inline">
					
					<ul class="nav" role="tablist">
						<h3 style="margin-top:20px; margin-bottom:px; font-weight:bold; color:#007bff;">Grafik Transaksi</h3>

						<li class="nav-item">
							<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
								Filter by year
							</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-2" role="tab" data-toggle="tab">
								Filter by year and month
							</a>
						</li>
                        
					</ul>
				</div><!--.tabs-section-nav-->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active show" id="tabs-4-tab-1">
						<form id="filterByYear">
							<div class="form-row align-items-center">
								<div class="col-lg-4 col-sm-4">
									<label class="sr-only" for="inlineFormInput">Name</label>
									<select name="" id="year" class="form-control">
										<option> -- pilih tahun --</option>
										<option value="2019">2019</option>
									</select>
								</div>
								<div class="col-lg-4">
									<button class="btn btn-primary">Submit</button>
								</div>
								</form>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<a class="badge badge-info hideGrafikTransaksi" style="color:#fff">Hide grafik transaksi<span id="qT">?</span> </a>
								</div>
							</div>
                    
                    </div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-2">
						<form id="filterByYearMonth">
							<div class="form-row align-items-center">
								<div class="col-lg-4 col-sm-4">
									<label class="sr-only" for="inlineFormInput">Name</label>
									<select name="" id="year2" class="form-control">
										<option> -- pilih tahun --</option>
										<option value="2019">2019</option>
									</select>
								</div>
								<div class="col-lg-4 col-sm-4">
									<label class="sr-only" for="inlineFormInput">Name</label>
									<select name="" id="month2" class="form-control">
										<option> -- pilih bulan --</option>
										<option value="01">1</option>
										<option value="02">2</option>
										<option value="03">3</option>
										<option value="04">4</option>
										<option value="05">5</option>
										<option value="06">6</option>
										<option value="07">7</option>
										<option value="08">8</option>
										<option value="09">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="12">20</option>
									</select>
								</div>
								<div class="col-lg-4">
									<button class="btn btn-primary">Submit</button>
								</div>
							
							</div>
							<div class="row">
								<div class="col-lg-12">
								<a class="badge badge-info hideGrafikTransaksi" style="color:#fff">Hide grafik transaksi<span id="qT">?</span> </a>

								</div>
							</div>
						</form>
					</div>

                
                    

				</div><!--.tab-content-->
			</section><!--.tabs-section-->
               </div>
            </div>
		   <div class="row">
		   		<div class="col-xl-12">
					<div id="graphTransaksi"></div>
	            </div><!--.col-->
				<div class="col-xl-12">
					<div id="graphTransaksi2"></div>
	            </div><!--.col-->
		   </div>
	        
	    </div><!--.container-fluid-->

		<!-- grafik user terdaftar -->
		<div class="container-fluid" style="margin-top:30px;" id="pageGraphProfit">
	        <div class="row">
	            <div class="col-xl-12">
	                <div class="row">
	                    <div class="col-sm-4">
	                        <article class="statistic-box green">
	                            <div>
	                                <div class="number showProfit">0</div>
	                                <div class="caption"><div>Untung</div></div>
	                                
	                            </div>
	                        </article>
	                    </div><!--.col-->
	                    <div class="col-sm-4">
	                        <article class="statistic-box yellow">
	                            <div>
	                                <div class="number showRugi">0</div>
	                                <div class="caption"><div>Rugi</div></div>
	                                
	                            </div>
	                        </article>
	                    </div><!--.col-->

	                   
	                </div><!--.row-->
			
				

	            </div><!--.col-->
	       
		   </div><!--.row-->

		   <div class="row">
                <div id="pageData" class="col-lg-12 col-md-12">
                <section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-inline">
					<ul class="nav" role="tablist">
						<h3 style="margin-top:20px; font-weight:bold; color:#a36dec">Grafik Profit</h3>

						<li class="nav-item">
							<a class="nav-link active" href="#tabs-4-tabProfit-1" role="tab" data-toggle="tab">
								Filter by year
							</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link" href="#tabs-4-tabProfit-2" role="tab" data-toggle="tab">
								Filter by year and month
							</a>
						</li>
                        
					</ul>
				</div><!--.tabs-section-nav-->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active show" id="tabs-4-tabProfit-1">
						<form id="filterProfitByYear">
							<div class="form-row align-items-center">
								<div class="col-lg-4 col-sm-4">
									<label class="sr-only" for="inlineFormInput">Name</label>
									<select name="" id="yearProfit1" class="form-control">
										<option> -- pilih tahun --</option>
										<option value="2019">2019</option>
									</select>
								</div>
								<div class="col-lg-4">
									<button class="btn btn-primary">Submit</button>
								</div>
							
							</div>
							<div class="row">
								<div class="col-lg-12">
									<a class="badge badge-info hideGrafikProfit" style="color:#fff">Hide grafik profit<span id="qT">?</span> </a>
								</div>
							</div>
						</form>
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <div class="card text-white bg-danger mb-3" style="width: 18rem; background-color:#00a8ff; color:white; margin-top:20px;">
                            <div class="card-body">
                            <h5 class="card-title" style="font-size:16px;">Total minus</h5>
                                <div class="chart-txt-top">
                                    <p><span class="number">0</span> IDR</p>
                                    <p class="caption"></p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                     -->
                    </div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tabProfit-2">
						<form id="filterProfitByYearMonth">
							<div class="form-row align-items-center">
								<div class="col-lg-4 col-sm-4">
									<label class="sr-only" for="inlineFormInput">Name</label>
									<select name="" id="yearProfit2" class="form-control">
										<option> -- pilih tahun --</option>
										<option value="2019">2019</option>
									</select>
								</div>
								<div class="col-lg-4 col-sm-4">
									<label class="sr-only" for="inlineFormInput">Name</label>
									<select name="" id="monthProfit2" class="form-control">
										<option> -- pilih bulan --</option>
										<option value="01">1</option>
										<option value="02">2</option>
										<option value="03">3</option>
										<option value="04">4</option>
										<option value="05">5</option>
										<option value="06">6</option>
										<option value="07">7</option>
										<option value="08">8</option>
										<option value="09">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="12">20</option>
									</select>
								</div>
								<div class="col-lg-4">
									<button class="btn btn-primary">Submit</button>
								</div>
							
							</div>
							<div class="row">
								<div class="col-lg-12">
									<a class="badge badge-info hideGrafikProfit" style="color:#fff">Hide grafik profit<span id="qT">?</span> </a>
								</div>
							</div>
							
						</form>
						
					</div>

                
                    

				</div><!--.tab-content-->
			</section><!--.tabs-section-->
               </div>
            </div>
		   <div class="row">
		   		<div class="col-xl-12">
					<div id="graphProfit"></div>
					
	            </div><!--.col-->
				<div class="col-lg-12">
					<div id="graphProfit2"></div>
				</div>
		   </div>
	        
	    </div><!--.container-fluid-->
		<!-- grafik user terdaftar -->


	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	<!-- <script src="js/lib/jquery/jquery-3.2.1.min.js"></script> -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script>
	function rubah(angka){
		var reverse = angka.toString().split('').reverse().join(''),
		ribuan = reverse.match(/\d{1,3}/g);
		ribuan = ribuan.join('.').split('').reverse().join('');
		return ribuan;
	}

	function reload2(data, gagal, text, totals, totalg, cat, profit, cat2, text2)
	{
		var chart = Highcharts.chart('graphProfit', {
			chart: {
				type: 'line'
			},
			title: {
				text: text
			},
			subtitle: {
				text: 'Hide: transaksi'
			},
			xAxis: {
				categories: cat
			},
			yAxis: {
				title: {
					text: 'Total '+profit
				}
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
			series: [{
				name: 'Total Profit : '+totals,
				data:data
			}],
		});
		var chart = Highcharts.chart('graphProfit2', {
			chart: {
				type: 'line'
			},
			title: {
				text: text2
			},
			subtitle: {
				text: 'Sumber: transaksi'
			},
			xAxis: {
				categories: cat2
			},
			yAxis: {
				title: {
					text: 'Total '+profit
				}
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
			series: [
			{
				name: 'Total Rugi : '+totalg,
				data:gagal
			}],
		});
	}

	// reload(daa, daaa, text, totala, totalg, cat, cat2);
	function reload(data, gagal, text, totals, totalg, cat, cat2, text2)
	{
		var chart = Highcharts.chart('graphTransaksi', {
			chart: {
				type: 'line'
			},
			title: {
				text: text
			},
			subtitle: {
				text: 'Hide: transaksi'
			},
			xAxis: {
				categories: cat
			},
			yAxis: {
				title: {
					text: 'Total data'
				}
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
			series: [{
				name: 'Total Transaksi Sukses : '+totals,
				data:data
			}],
		});
		var chart = Highcharts.chart('graphTransaksi2', {
			chart: {
				type: 'line'
			},
			title: {
				text: text2
			},
			subtitle: {
				text: 'Hide: transaksi'
			},
			xAxis: {
				categories: cat2
			},
			yAxis: {
				title: {
					text: 'Total data'
				}
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
			series: [			{
				name: 'Total Transaksi Gagal : '+totalg,
				data: gagal
			}],
		});
	}

		$(document).ready(function() {
			reload();
			reload2();

			
			$('#graphTransaksi').hide();
			$('#graphTransaksi2').hide();
			$('#graphProfit').hide();
			$('#graphProfit2').hide();

			//hide graph
			$('.hideGrafikTransaksi').on('click', function()
			{
				$('#graphTransaksi').fadeOut();
				$('#graphTransaksi2').fadeOut();
			});

			//hide profit
			$('.hideGrafikProfit').on('click', function()
			{
				$('#graphProfit').fadeOut();
				$('#graphProfit2').fadeOut();
			});

			//chart profit
			$(document).on('submit', '#filterProfitByYearMonth', function(e) {
				e.preventDefault();
				// alert( this.value );
				var tahun = $('#yearProfit2').val();
				var month = $('#monthProfit2').val();
				// alert(tahun);
				// alert(month);

				if (tahun == "-- pilih tahun --" || month == "-- pilih bulan --")
				{
					alert("Mohon isi kedua field!");
					// $('#year2').focus();
					return;
				}
				// alert(month);

				$.ajax({  
					url:"<?PHP echo $c_url; ?>/grafik/load_grafik_home4.php",  
					method:'POST',  
					data:{tahun:tahun , month:month},  
					dataType: 'json',
					// contentType:false,  
					// new FormData(this)
					// processData:false,  
					success:function(data)  
					{  
						$('#graphProfit').fadeIn();
						$('#graphProfit2').fadeIn();
						// console.log(data);
						// alert(data.status);
						if (data.status == "null")
						{
								var das = [0];
								var obj23 = ['null'];    
								var textx = "Data not found";
								// $('.number').html("0");
								var total = 0;
								var totalg = 0;
								$('.showProfit').html(0);
								$('.showRugi').html(0);
								reload(das, obj23, textx, total, totalg);
						}else {            
					
							// console.log(d);
							// var d = JSON.parse(data.data1);
							console.log(data.data4);
							var obj = JSON.parse(data.data1);
							var obj2 = JSON.parse(data.data2);
							var obj3 = JSON.parse(data.data3);
							var obj4 = JSON.parse(data.data4);
							// var daa = [200,300,400,500];
							// alert(data.data2);
							var daa = obj;
							var daaa = obj2;
							var obj3 = obj3;
							var obj4 = obj4;
							console.log(obj3);

							console.log(obj4);
							// console.log(total(obj));

							//hitung total sukses
							var totala = total(obj);
							var totala = rubah(totala);
							var totala = totala+" IDR";

							//hitung total gagal
							var totalg = total(obj2);
							var totalg = rubah(totalg);
							var totalg = totalg+" IDR";	

							$('.showProfit').html(totala);
							$('.showRugi').html(totalg);

							// console.log(totala);
							// $('.number').html(totala);
							// sum total minus
							function total(arr) {
								if(!Array.isArray(arr)) return;
								let sum=0;
								arr.forEach(each => {
									sum+=each;
								});
								return sum;
							};


							// alert(daa);
								// console.log(data.data1);
								// console.log(data.data2);
								// alert(data.data2);
							var text = "Graph untung per bulan dalam satu tahun";
							var text2 = "Graph rugi per bulan dalam satu tahun";
							var profit = "Profit";
							var cat = obj3;
							var cat2 = obj4;
							// var cat = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
							reload2(daa, daaa, text, totala, totalg, cat, profit, cat2, text2);
							// reload2(data, gagal, text, totals, totalg, cat, profit, supercat)
						}
					},
					error: function (jqXHR, exception) {
						console.log(jqXHR);
						// Your error handling logic here..
					}
				});

				// changePagination(1, "search", id);
			});

			$(document).on('submit', '#filterProfitByYear', function(e) {
				e.preventDefault();
				// alert( this.value );
				var tahun = $('#yearProfit1').val();
				// alert(tahun);

				if (tahun == "-- pilih tahun --")
				{
					alert('Mohon isi field!');
					return;
				}

				$.ajax({  
					url:"<?PHP echo $c_url; ?>/grafik/load_grafik_home3.php",  
					method:'POST',  
					data:{tahun:tahun},  
					dataType: 'json',
					// contentType:false,  
					// new FormData(this)
					// processData:false,  
					success:function(data)  
					{  
						$('#graphProfit').fadeIn();
						$('#graphProfit2').fadeIn();

						// console.log(data);
						// alert(data);
						if (data.status == "null")
						{
								var das = [0];
								var obj23 = ['null'];    
								var textx = "Data not found";
								// $('.number').html("0");
								var total = 0;
								var totalg = 0;
								$('.showProfit').html(0);
								$('.showRugi').html(0);

								reload(das, obj23, textx, total, totalg);
						}else {            
					
							// console.log(d);
							// var d = JSON.parse(data.data1);
							// console.log(d);
							var obj = JSON.parse(data.data1);
							var obj2 = JSON.parse(data.data2);
							var obj3 = JSON.parse(data.data3);
							var obj4= JSON.parse(data.data4);
							// var daa = [200,300,400,500];
							// alert(data.data2);
							var daa = obj;
							var daaa = obj2;
							// console.log(daaa);
							// console.log(total(obj));

							//hitung total sukses
							var totala = total(obj);
							var totala = rubah(totala);
							var totala = totala+" IDR";

							//hitung total gagal
							var totalg = total(obj2);
							var totalg = rubah(totalg);
							var totalg = totalg+" IDR";

							$('.showProfit').html(totala);
							$('.showRugi').html(totalg);
							// console.log(totala);
							// $('.number').html(totala);
							// sum total minus
							function total(arr) {
								if(!Array.isArray(arr)) return;
								let sum=0;
								arr.forEach(each => {
									sum+=each;
								});
								return sum;
							};


							// alert(daa);
								// console.log(data.data1);
								// console.log(data.data2);
								// alert(data.data2);
							var text = "Graph untung per tahun";
							var text2 = "Graph rugi per tahun";
							var profit = "Profit";

							// var cat = obj3;
							// var cat2 = obj4;
							var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
							var cat2 = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

							reload2(daa, daaa, text, totala, totalg, cat, profit, cat2, text2);
						}
					},
					error: function (jqXHR, exception) {
						console.log(jqXHR);
						// Your error handling logic here..
					}
				});

				$('.highcharts-subtitle').on('click', function()
				{
					var val = this.html();
					alert(val);
				});

				// changePagination(1, "search", id);
			});
			//chart profit



			//chart transaksi
			$(document).on('submit', '#filterByYearMonth', function(e) {
				e.preventDefault();
				// alert( this.value );
				var tahun = $('#year2').val();
				var month = $('#month2').val();
				// alert();

				if (tahun == "-- pilih tahun --" || month == "-- pilih bulan --")
				{
					alert("Mohon isi kedua field!");
					// $('#year2').focus();
					return;
				}
				// alert(month);

				$.ajax({  
					url:"<?PHP echo $c_url; ?>/grafik/load_grafik_home2.php",  
					method:'POST',  
					data:{tahun:tahun , month:month},  
					dataType: 'json',
					// contentType:false,  
					// new FormData(this)
					// processData:false,  
					success:function(data)  
					{  
						$('#graphTransaksi').fadeIn();
						$('#graphTransaksi2').fadeIn();
						// console.log(data);
						// alert(data.status);
						if (data.status == "null")
						{
								var das = [0];
								var obj23 = ['null'];    
								var textx = "Data not found";
								// $('.number').html("0");
								var total = 0;
								var totalg = 0;
								$('.showTransaksiSukses').html(0);
								$('.showTransaksiGagal').html(0);

								reload(das, obj23, textx, total, totalg);
						}else {            
					
							// console.log(d);
							// var d = JSON.parse(data.data1);
							// console.log(d);
							var obj = JSON.parse(data.data1);
							var obj2 = JSON.parse(data.data2);
							var obj3 = JSON.parse(data.data3);
							var obj4 = JSON.parse(data.data4);
							
							// var daa = [200,300,400,500];
							// alert(data.data2);
							var daa = obj;
							var daaa = obj2;
							console.log(daa);
							// console.log(total(obj));

							//hitung total sukses
							var totala = total(obj);
							var totala = rubah(totala);
							var totala = totala;

							//hitung total gagal
							var totalg = total(obj2);
							var totalg = rubah(totalg);
							var totalg = totalg;


							$('.showTransaksiSukses').html(totala);
							$('.showTransaksiGagal').html(totalg);
							

							// console.log(totala);
							// $('.number').html(totala);
							// sum total minus
							function total(arr) {
								if(!Array.isArray(arr)) return;
								let sum=0;
								arr.forEach(each => {
									sum+=each;
								});
								return sum;
							};


							// alert(daa);
								// console.log(data.data1);
								// console.log(data.data2);
								// alert(data.data2);
							var text = "Graph transaksi sukses per bulan dalam satu tahun";
							var text2 = "Graph transaksi gagal per bulan dalam satu tahun";
							// var cat = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
							var cat = obj3;
							var cat2 = obj4;
							reload(daa, daaa, text, totala, totalg, cat, cat2, text2);
						}
					},
					error: function (jqXHR, exception) {
						console.log(jqXHR);
						// Your error handling logic here..
					}
				});

				// changePagination(1, "search", id);
			});

			$(document).on('submit', '#filterByYear', function(e) {
				e.preventDefault();
				// alert( this.value );
				var tahun = $('#year').val();
				// alert(tahun);

				if (tahun == "-- pilih tahun --")
				{
					alert('Mohon isi field!');
					return;
				}

				$.ajax({  
					url:"<?PHP echo $c_url; ?>/grafik/load_grafik_home.php",  
					method:'POST',  
					data:{tahun:tahun},  
					dataType: 'json',
					// contentType:false,  
					// new FormData(this)
					// processData:false,  
					success:function(data)  
					{  
						$('#graphTransaksi').fadeIn();
						$('#graphTransaksi2').fadeIn();

						// console.log(data);
						// alert(data);
						if (data.status == "null")
						{
								var das = [0];
								var obj23 = ['null'];    
								var textx = "Data not found";
								// $('.number').html("0");
								var total = 0;
								var totalg = 0;
								$('.showTransaksiSukses').html(0);
								$('.showTransaksiGagal').html(0);

								reload(das, obj23, textx, total, totalg);
						}else {            
					
							// console.log(d);
							// var d = JSON.parse(data.data1);
							// console.log(d);
							var obj = JSON.parse(data.data1);
							var obj2 = JSON.parse(data.data2);
							var obj3 = JSON.parse(data.data3);
							var obj4 = JSON.parse(data.data4);
							// var daa = [200,300,400,500];
							// alert(data.data2);
							var daa = obj;
							var daaa = obj2;
							// console.log(daaa);
							// console.log(total(obj));

							//hitung total sukses
							var totala = total(obj);
							var totala = rubah(totala);
							var totala = totala;

							//hitung total gagal
							var totalg = total(obj2);
							var totalg = rubah(totalg);
							var totalg = totalg;


							$('.showTransaksiSukses').html(totala);
							$('.showTransaksiGagal').html(totalg);

							// console.log(totala);
							// $('.number').html(totala);
							// sum total minus
							function total(arr) {
								if(!Array.isArray(arr)) return;
								let sum=0;
								arr.forEach(each => {
									sum+=each;
								});
								return sum;
							};


							// alert(daa);
								// console.log(data.data1);
								// console.log(data.data2);
								// alert(data.data2);
							var text = "Graph transaksi sukses per tahun";
							var text2 = "Graph transaksi gagal per tahun";
							var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
							var cat = cat;
							var cat2 = cat;
							reload(daa, daaa, text, totala, totalg, cat, cat2, text2);
						}
					},
					error: function (jqXHR, exception) {
						console.log(jqXHR);
						// Your error handling logic here..
					}
				});

				$('.highcharts-subtitle').on('click', function()
				{
					var val = this.html();
					alert(val);
				});

				// changePagination(1, "search", id);
			});
			//chart transaksi


            $('.panel').each(function () {
                try {
                    $(this).lobiPanel({
                        sortable: true
                    }).on('dragged.lobiPanel', function(ev, lobiPanel){
                        $('.dahsboard-column').matchHeight();
                    });
                } catch (err) {}
            });

			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var dataTable = new google.visualization.DataTable();
				dataTable.addColumn('string', 'Day');
				dataTable.addColumn('number', 'Values');
				// A column for custom tooltip content
				dataTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
				dataTable.addRows([
					['MON',  130, ' '],
					['TUE',  130, '130'],
					['WED',  180, '180'],
					['THU',  175, '175'],
					['FRI',  200, '200'],
					['SAT',  170, '170'],
					['SUN',  250, '250'],
					['MON',  220, '220'],
					['TUE',  220, ' ']
				]);

				var options = {
					height: 314,
					legend: 'none',
					areaOpacity: 0.18,
					axisTitlesPosition: 'out',
					hAxis: {
						title: '',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						textPosition: 'out'
					},
					vAxis: {
						minValue: 0,
						textPosition: 'out',
						textStyle: {
							color: '#fff',
							fontName: 'Proxima Nova',
							fontSize: 11,
							bold: true,
							italic: false
						},
						baselineColor: '#16b4fc',
						ticks: [0,25,50,75,100,125,150,175,200,225,250,275,300,325,350],
						gridlines: {
							color: '#1ba0fc',
							count: 15
						}
					},
					lineWidth: 2,
					colors: ['#fff'],
					curveType: 'function',
					pointSize: 5,
					pointShapeType: 'circle',
					pointFillColor: '#f00',
					backgroundColor: {
						fill: '#008ffb',
						strokeWidth: 0,
					},
					chartArea:{
						left:0,
						top:0,
						width:'100%',
						height:'100%'
					},
					fontSize: 11,
					fontName: 'Proxima Nova',
					tooltip: {
						trigger: 'selection',
						isHtml: true
					}
				};

				var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
				chart.draw(dataTable, options);
			}
			$(window).resize(function(){
				drawChart();
				setTimeout(function(){
				}, 1000);
			});
		});
	</script>
	
</body>
</html>