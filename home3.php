<?PHP
// session_start();
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

// echo "cookie : ".$_COOKIE['role'];;
// echo "<br/>session : ".$_SESSION['role'];;
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
    
            <div class="row">
                <div id="pageData" class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12">
                    <section class="tabs-section">
                        <div class="tabs-section-nav tabs-section-nav-data">
                        <div class="tbl">
                            <ul class="nav" role="tablist">
                            <li class="nav-item" style="width:50%">
                                <a class="nav-link active show" data-toggle="tab" href="#tabs-3-tab-1" role="tab" aria-selected="true" style="margin-top:-5px;">
                                    <span class="nav-link-in">Transaksi</span>
                                    <span class="percent color-green"><i class="fa fa-shopping-cart"></i></span> <span class="title"></span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3-tab-2" role="tab" aria-selected="true" style="margin-top:-5px;">
                                    <span class="nav-link-in">Profit</span>
                                    <span class="percent color-green"><i class="fa fa-dollar"></i></span> <span class="title"></span></span>
                                </a>
                            </li>
                            </ul>
                        </div>
                        </div><!--.tabs-section-nav-->
                        <div class="tab-content">
                        <div class="tab-pane fade in active show" id="tabs-3-tab-1" role="tabpanel">
                            <section class="tabs-section-simple">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link  active show aTransaksiTahun" data-toggle="tab" href="#tabs-simple-tab-1" role="tab" aria-selected="false">Years</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link aTransaksiBulan" data-toggle="tab" href="#tabs-simple-tab-2" role="tab" aria-selected="false">Months</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active show" id="tabs-simple-tab-1" role="tabpanel">
                                        <!-- <h1> adad</h1> -->
                                        <form id="formTransaksi">
                                        <input type="hidden" id="role" value="1">
                                        <div class="row rowYearMatching" style="margin-left:5px;">
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih tahun</label>
                                                    <select name="tahunTransaksi" id="tahunTransaksi" class="form-control">
                                                        <option value="2019">2019</option>
                                                        <option value="2018">2018</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih bulan</label>
                                                    <select name="bulanTransaksi" disabled="" id="bulanTransaksi" class="form-control">
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                            </form>

                                                    <button style="margin-top:28px;" type="submit" class="btn btn-inline btn-primary-outline btnTransaksi">Draw grafik</button>
                                                    <a style="margin-top:28px;" class="btn btn-inline btn-primary-outline btnHideTransaksi">Hide grafik</a>
                                                    
                                                </fieldset>
                                            </div>

                                        </div>

                                        <!-- <div id="graphT" style="width:100%; height: 400px; margin: 0 auto; display:none"> -->
                                        <div>
                                        <div id="graph1" style="width:100%; height: 400px; margin: 0 auto; display:none">

                                        </div>
                                        <div>
                                            <div id="graphT" style="width:100%; height: 400px; margin: 0 auto; display:none">
                                        </div>


                                        <!-- grafik -->
                                        <!-- grafik -->
                                        
                                    </div><!--.tab-pane-->
                                    <div class="tab-pane fade" id="tabs-simple-tab-2" role="tabpanel">
                                      
                                    </div><!--.tab-pane-->
                                    <div class="tab-pane fade " id="tabs-simple-tab-3" role="tabpanel">
                                      
                                    </div><!--.tab-pane-->
                                </div><!--.tab-content-->
                            </section><!--.tabs-section-simple-->
                        </div><!--.tab-pane-->
                        <div class="tab-pane fade" id="tabs-3-tab-2" role="tabpanel">
                        <section class="tabs-section-simple">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link  active show aProfitTahun" data-toggle="tab" href="#tabs-simple-tab-1" role="tab" aria-selected="false">Years</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link aProfitBulan" data-toggle="tab" href="#tabs-simple-tab-2" role="tab" aria-selected="false">Months</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active show" id="tabs-simple-tab-1" role="tabpanel">
                                        <!-- <h1> adad</h1> -->
                                        <form id="formProfit">
                                        <input type="hidden" id="roleProfit" value="1">
                                        <div class="row rowYearSelisih" style="margin-left:5px;">
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih tahun</label>
                                                    <select id="tahunProfit" class="form-control">
                                                        <option value="2019">2019</option>
                                                        <option value="2018">2018</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih bulan</label>
                                                    <select  disabled="" id="bulanProfit" class="form-control">
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <button style="margin-top:28px;" type="submit" class="btn btn-inline btn-primary-outline btnProfit">Draw grafik</button>
                                                    <a style="margin-top:28px;" class="btn btn-inline btn-primary-outline btnHideProfit">Hide grafik</a>

                                                </fieldset>
                                            </div>
                                            </form>
                                        </div>
                                            <div id="graph2" style="width:100%; height: 400px; margin: 0 auto; display:none">

                                        </div>
                                        <div>
                                            <div id="graph3" style="width:100%; height: 400px; margin: 0 auto; display:none">
                                        </div>
                                        
                                    </div><!--.tab-pane-->
                                    <div class="tab-pane fade" id="tabs-simple-tab-2" role="tabpanel">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="tabs-simple-tab-3" role="tabpanel">
                                        <!-- <h1>ada</h1> -->
                                    </div>
                                </div><!--.tab-content-->
                            </section><!--.tabs-section-simple-->
                        </div><!--.tab-pane-->
                        <div class="tab-pane fade" id="tabs-3-tab-3" role="tabpanel">
                                <div class="container-fluid">
                                    <div class="box-typical box-typical-padding">
                                        <div class="row">
                                            
                                            <div class="col-xl-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="box-typical-upload box-typical-upload-in">
                                                            <form id="uploadImage" action="grafik_matching_minus.php" method="post">
                                                                <div class="drop-zone">
                                                                    <!--
                                                                    при перетаскиваении добавляем класс .dragover
                                                                    <div class="drop-zone dragover">
                                                                    -->
                                                                    <i class="font-icon font-icon-cloud-upload-2"></i>
                                                                    <div class="drop-zone-caption">
                                                                        <span class="btn btn-rounded btn-file">
                                                                            <span>Choose file</span>
                                                                            <input type="file" name="uploadFile" id="uploadFile">
                                                                        </span>
                                                                    </div>
                                                                </div><!--.drop-zone-->
                                                                <input type="submit" id="uploadSubmit" value="Upload" class="btn btn-primary" style="margin-bottom:20px;"/>


                                                            </form>
                                                            <h6 class="uploading-list-title" style="display:none">Uploading..</h6>
                                                            <ul class="uploading-list" style="display:none">
                                                                <li class="uploading-list-item">
                                                                    <div class="uploading-list-item-wrapper">
                                                                        <div class="uploading-list-item-name">
                                                                            <i class="font-icon font-icon-cam-photo"></i>
                                                                            <!-- <i class="fas fa-camera"></i> -->
                                                                            <span id="namaFile">photo.png</span>
                                                                        </div>
                                                                        <!-- <div class="uploading-list-item-size">7,5 mb</div> -->
                                                                        <button type="button" class="uploading-list-item-close">
                                                                            <i class="font-icon-close-2"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <span class="progress-bar" style="width: 25%;"></span>
                                                                    </div>
                                                                    <div class="uploading-list-item-progress"></div>
                                                                    <div class="loading-h2h" style="margin-top:20px;">
                                                                        <h6>Matching H2H to Transaksi <span><img width="10px" src="http://localhost/2019/bukakios/admin.bukakios.net/img/25.gif" alt=""></span></h6>
                                                                        
                                                                    </div>
                                                                    <div class="loading-bk" style="margin-top:20px;">
                                                                        <h6>Matching Transaksi to H2H <span><img width="10px" src="http://localhost/2019/bukakios/admin.bukakios.net/img/25.gif" alt=""></span></h6>
                                                                        
                                                                    </div>
                                                                    
                                                                </li>
                                                               
                                                            </ul>
                                                            <div id="targetLayer" style="display:none;"></div>

                                                        </div>
                                                    </div><!--.col-->
                                                </div><!--.row-->
                                            </div>
                                        </div><!--.row-->
                                    </div>

                                </div>
                        </div><!--.tab-pane-->
                      
                        </div><!--.tab-content-->
                    </section><!--.tabs-section-->
                    </div><!--.col-lg-6-->
                </div>
               </div>
            </div>

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
		var chart = Highcharts.chart('graph2', {
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
		var chart = Highcharts.chart('graph3', {
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
		var chart = Highcharts.chart('graph1', {
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
		
        var chart = Highcharts.chart('graphT', {
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
        // reload2();

        $('.btnHideProfit').on('click', function ()
        {
            $('#graph2').fadeOut();
            $('#graph3').fadeOut();

        });

        $('.btnHideTransaksi').on('click', function ()
        {
            $('#graph1').fadeOut();
            $('#graphT').fadeOut();

        });

         //cahnge roleProfit value tahun
         $(document).on('click', '.aProfitTahun', function()
        {
            $('#role').val("1");
            $("#tahunProfit").prop('disabled', false);
            $("#bulanProfit").prop('disabled', true);
        });

        //cahnge role value bulan
        $(document).on('click', '.aProfitBulan', function()
        {
            // alert();
            $("#tahunProfit").prop('disabled', false);
            $("#bulanProfit").prop('disabled', false);
            $('#role').val("2");
        });

        //cahnge role value tahun
        $(document).on('click', '.aTransaksiTahun', function()
        {
            $('#role').val("1");
            $("#tahunTransaksi").prop('disabled', false);
            $("#bulanTransaksi").prop('disabled', true);
        });

        //cahnge role value bulan
        $(document).on('click', '.aTransaksiBulan', function()
        {
            // alert();
            $("#tahunTransaksi").prop('disabled', false);
            $("#bulanTransaksi").prop('disabled', false);
            $('#role').val("2");
        });

        //form ajax post transaksi
        $(document).on('submit', '#formTransaksi', function(e)
        {
            e.preventDefault();
            var role = $('#role').val();
            var tahun = $('#tahunTransaksi').val();
            var bulan = $('#bulanTransaksi').val();
            // alert(role);
            // $('.btnTransaksi').prop('disabled', true)
            $('.btnTransaksi').prop('disabled', true);
            $('.btnTransaksi').html("Loading..");
            //years
            if (role == 1)
            {
                ajax_transaksi_tahun(tahun);
            }
            //months
            else if (role == 2)
            {
                ajax_transaksi_bulan(tahun, bulan);
            }
        });

        //form ajax post profit
        $(document).on('submit', '#formProfit', function(e)
        {
            e.preventDefault();
            var role = $('#role').val();
            var tahun = $('#tahunProfit').val();
            var bulan = $('#bulanProfit').val();
            // alert(role);
            // $('.btnTransaksi').prop('disabled', true)
            $('.btnProfit').prop('disabled', true);
            $('.btnProfit').html("Loading..");
            //years
            if (role == 1)
            {
                ajax_profit_tahun(tahun);
            }
            //months
            else if (role == 2)
            {
                ajax_profit_bulan(tahun, bulan);
            }
        });

        //chart profit
        function ajax_profit_bulan(tahun, month)
        {
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
                    $('#graph2').fadeIn();
                    $('#graph3').fadeIn();
                    $('.btnProfit').prop('disabled', false);
                    $('.btnProfit').html("Draw grafik")
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
        }

        function ajax_profit_tahun(tahun)
        {

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
                    $('#graph2').fadeIn();
                    $('#graph3').fadeIn();

                    // console.log(data);
                    // alert(data);
                    $('.btnProfit').prop('disabled', false);
                    $('.btnProfit').html("Draw grafik");
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

                        // $('.showProfit').html(totala);
                        // $('.showRugi').html(totalg);
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
        
        }
        //chart profit



        //chart transaksi
        function ajax_transaksi_bulan(tahun, month)
        {

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
                    $('.btnTransaksi').prop('disabled', false);
                    $('.btnTransaksi').html("Draw grafik");

                    $('#graph1').fadeIn();
                    $('#graphT').fadeIn();
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


                        // $('.showTransaksiSukses').html(totala);
                        // $('.showTransaksiGagal').html(totalg);
                        

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
        }

        function ajax_transaksi_tahun(tahun)
        {
            // $(document).on('submit', '#filterByYear', function(e) {
                // e.preventDefault();
                // alert( this.value );
                // var tahun = $('#year').val();
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
                        $('#graph1').fadeIn();
                        $('#graphT').fadeIn();
                        $('.btnTransaksi').prop('disabled', false);
                        $('.btnTransaksi').html("Draw grafik");

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


                            // $('.showTransaksiSukses').html(totala);
                            // $('.showTransaksiGagal').html(totalg);

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

                // $('.highcharts-subtitle').on('click', function()
                // {
                //     var val = this.html();
                //     alert(val);
                // });

                // changePagination(1, "search", id);
            // });
        }
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