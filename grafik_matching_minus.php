<?PHP
// start();
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
include 'koneksi.php';

$sql = "SELECT total_minus FROM buka_kios.tbl_total_minus_not_match where tanggal_matching between '2019-10-01 00:00:00'  and '2019-10-05 23:59:00'";
$data = $db->fetch_json($sql);




// echo $data =  json_encode($data);
// echo var_dump($data);
// $data = str_replace("")
// echo var_dump($data); 
// echo json_encode($data); 
// foreach ($data as $row)
// {
//     echo $row."<br/>";
// }

// $arrays = [[1, 2], [3, 4], [5, 6]];
 
// foreach ($arrays as $list) {
//     $c = $a + $b;
//     echo($c . ', '); // 3, 7, 11, 
// }

?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Jabber Outbox - <?PHP echo $c_name; ?></title>

    <!-- //timepicker -->
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
    <link rel="stylesheet" href="css/lib/bootstrap-sweetalert/sweetalert.css">
    <link rel="stylesheet" href="css/separate/vendor/sweet-alert-animations.min.css">


    <!-- grafik -->
	<!-- <script src="js/lib/jquery/jquery-3.2.1.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script> 

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> -->
    
    <script src="js/plugins.js"></script>
    <script src="js/lib/notie/notie.js"></script>
    <script src="js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
    
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
    <?PHP require_once("_/sidebar.php"); ?>
    <?php
    include 'file_csv/SimpleXLSX.php';
    
    try {
        $conn = new PDO( "mysql:host=localhost;dbname=bukakios_h2h", "root", "");
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     }
     catch(PDOException $e)
     {
         echo $sql . "<br>" . $e->getMessage();
     }

  

    //upload.php

        if(!empty($_FILES))
        {
            if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
            {
                sleep(1);
                $source_path = $_FILES['uploadFile']['tmp_name'];
                $nama_file = rand().$_FILES['uploadFile']['name'];
                $target_path = 'file_csv/'.$nama_file;


                //insert data to table
                $nama = $nama_file;
                $file = date('Y-m-d h:m:s');

                //insert file to import_h2h



                // $s = 0;
                if(move_uploaded_file($source_path, $target_path))
                {
                    $sql = "INSERT INTO tbl_import_file_h2h (nama_file, created_at) values ('$nama', '$file')";  
                    $row = mysql_query($koneksi, $sql);

                    //import excel to tbl_import_h2h
                    // $stmt = $conn->prepare( "INSERT INTO tbl_import_h2h(tgl_transaksi, kd_produk, no_tujuan, no_hp, harga_jual, status, tgl_status, saldo_awal, saldo_akhir, sn) VALUES (?,?,?,?,?,?,?,?,?,?)");
                    // $xlsx = new SimpleXLSX("file_csv/".$nama_file);

                    // $stmt = $conn->prepare("INSERT INTO `tbl_import_h2h` (`id`, `tgl_transaksi`, `kd_produk`, `no_tujuan`, `no_hp`, `harga_jual`, `status`, `tgl_status`, `saldo_awal`, `saldo_akhir`, `sn`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    // $stmt = $conn->prepare( "INSERT INTO tbl_transaksi (id_transaksi, user_id, h2h, kode_produk, no_tujuan, harga,  profit, tanggal) VALUES (?,?,?,?,?,?,?,?)");
                    // $stmt->execute();

                    // $stmt->bindParam( 1, $data1);
                    // $stmt->bindParam( 2, $data2);
                    // $stmt->bindParam( 3, $data3);
                    // $stmt->bindParam( 4, $data4);
                    // $stmt->bindParam( 5, $data5);
                    // $stmt->bindParam( 6, $data6);
                    // $stmt->bindParam( 7, $data7);
                    // $stmt->bindParam( 8, $data8);
                    // $stmt->bindParam( 9, $data9);
                    // $stmt->bindParam( 10, $data10);
                    // foreach ($xlsx->rows() as $fields)
                    // {
                    //     $data1 = $fields[0];
                    //     $data2 = $fields[1];
                    //     $data3 = $fields[2];
                    //     $data4 = $fields[3];
                    //     $data5 = $fields[4];
                    //     $data6 = $fields[5];
                    //     $data7 = $fields[6];
                    //     $data8 = $fields[7];
                    //     $data9 = $fields[8];
                    //     $data10 = $fields[9];
                    //     $stmt->execute();
                    // }
                }

                //proses analisa
                

                // $alldata = $db->tampil_data();
                //bandingkan h2h dan bk
                //cari data tidak match
                
            //     $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
            //     $kemaren  = date('d/m/y', $tgl);
            //     $startkemarin = $kemaren." 00:00:00";
            //     $endkemarin = $kemaren." 23:59:00";

            //     //cari harga yang tidak sesuai dengan 
            //     $sql = "SELECT * from tbl_import_h2h where tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            //     $datah2h = $db->fetch_multiple($sql);
            //     $u = 0;
            //     $totalminus = 0;

            //     // echo date('d-m-Y H:i:s');

            //     // select * from hockey_stats 
            //     // where game_date between '2012-03-11 00:00:00' and '2012-05-11 23:59:00' 
            //     // order by game_date desc;

            //     foreach ( $datah2h as $rows2 )
            //     {
            //         $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
            //         $kemaren  = date('Y-m-d', $tgl);

            //         $kode = $rows2['kd_produk'];
            //         $no = $rows2['no_tujuan'];
                    
            //         $id = $rows2['id'];
            //         $harga_jual = $rows2['harga_jual'];
            //         $tgl_transaksi = substr($rows2['tgl_transaksi'],  11);
            //         $tgl_transaksi = $kemaren." ".$tgl_transaksi;
            //         // $tgl = 
            //         $c = $rows2['harga_jual'];
                    
            //         //tgl kemarin
            //         // $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
            //         // $kemaren  = date('Y-m-d', $tgl);
            //         // $startkemarin = $kemaren." 00:00:00";
            //         // $endkemarin = $kemaren." 23:59:00";
                    
            //         //   $sqlHarga = "SELECT * from transaksi where product_code='$kode' && nomor_tujuan='$no' && created_at between between '2019-09-17 00:00:00' and '2019-09-17 23:59:00'";
            //         $sqlHarga = "SELECT * from tbl_import_h2h2 where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

            //         $index = "harga_jual";

            //         $cari = $db->banding_harga($sqlHarga, $c, $index);
            //         if ($cari != false)
            //         {
            //             $totalminus = $totalminus + $cari;
            //            // echo "<br/> dengan kode ".$kode." dan no tujuan ".$no." ada minus ".$cari;
            //             $insertH2hToBk = "INSERT INTO tbl_minus_harga (tgl_transaksi, kd_produk,  no_tujuan, harga_jual, minus, alur) values('$tgl_transaksi', '$kode', '$no', '$harga_jual', '$cari', '1')  ";
            //             $db->query($insertH2hToBk);
            //         }
            //     }

            //    // echo "<br/> total minus".$totalminus;

            //     $alldata = $db->fetch_multiple($sql);
            //     $minus = 0;
            //     foreach ($alldata as $hasil)
            //     {
            //         $kode = $hasil['kd_produk'];
            //         $no = $hasil['no_tujuan'];
            //         $id = $hasil['id'];
            //         $tgl_transaksi = substr($rows2['tgl_transaksi'],  11);
            //         $tgl_transaksi = $kemaren." ".$tgl_transaksi;
            //         $status = $rows2['status'];

                    
            //         $sql = "SELECT * from tbl_import_h2h2 where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

            //         // $sql = "SELECT * from tbl_bk where kode_produk='$kode' && no_tujuan='$no' && tanggal between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            //         // cari data yang sesuai di tbl bk
            //         $databk = $db->num_rows($sql);
            //         if ($databk <= 0)
            //         {
            //            // echo "<br/>";
            //             //echo $id." dan ".$kode." dan ".$no." data tidak match<br/>";
                    
            //             $insertH2hToBk = "INSERT INTO tbl_not_match (tgl_transaksi, kd_produk, status, no_tujuan, alur) values('$tgl_transaksi', '$kode', '$status', '$no', '1')  ";
            //             $db->query($insertH2hToBk);
            //         }
            //     }


            //     //dari bk ke h2h
            //     // echo "<br/><br/><br/>";
            //     $sql = "SELECT * from tbl_import_h2h2 where tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            //     // $datah2h = $db->fetch_multiple($sql);   
            //     // foreach ( $datah2h as $rows2 )
            //     // {
            //     //     $kode = $rows2['kd_produk'];
            //     //     $no = $rows2['no_tujuan'];
            //     //     $id = $rows2['id'];
            //     //     // $tgl = 
            //     //     $c = $rows2['harga_jual'];
            //     //     $tgl_transaksi = $rows2['tgl_transaksi'];
            //     //     $status = $rows2['status'];
            //     //     //tgl kemarin
            //     //     $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
            //     //     $kemaren  = date('Y-m-d', $tgl);
            //     //     $startkemarin = $kemaren." 00:00:00";
            //     //     $endkemarin = $kemaren." 23:59:00";
                    
            //     //     //   $sqlHarga = "SELECT * from transaksi where product_code='$kode' && nomor_tujuan='$no' && created_at between between '2019-09-17 00:00:00' and '2019-09-17 23:59:00'";
            //     //         $sqlHarga = "SELECT * from tbl_import_h2h where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

            //     //         $index = "harga_jual";

            //     //     $cari = $db->banding_harga2($sqlHarga, $c, $index);
            //     //     if ($cari != false)
            //     //     {
            //     //         $totalminus = $totalminus + $cari;
            //     //         echo "<br/> dengan kode ".$kode." dan no tujuan ".$no." ada minus ".$cari;
            //     //         $insertH2hToBk = "INSERT INTO tbl_minus_harga (tgl_transaksi, kd_produk,  no_tujuan, harga_jual, minus, alur) values('$tgl_transaksi', '$kode', '$no', '$c', '$cari', '2')  ";
            //     //         $db->query($insertH2hToBk);
            //     //     }
            //     // }

            //     // echo "<br/> total minus".$totalminus;

            //     $alldata = $db->fetch_multiple($sql);
            //     $minus = 0;
            //     foreach ($alldata as $hasil)
            //     {
            //         $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
            //         $kemaren  = date('Y-m-d', $tgl);

            //         $kode = $hasil['kd_produk'];
            //         $no = $hasil['no_tujuan'];
            //         $id = $hasil['id'];
            //         $tgl_transaksi = substr($rows2['tgl_transaksi'],  11);
            //         $tgl_transaksi = $kemaren." ".$tgl_transaksi;

            //         $status = $rows2['status'];
            //         $sql = "SELECT * from tbl_import_h2h where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

            //         // $sql = "SELECT * from tbl_bk where kode_produk='$kode' && no_tujuan='$no' && tanggal between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            //         // cari data yang sesuai di tbl bk
            //         $databk = $db->num_rows($sql);
            //         if ($databk <= 0)
            //         {
            //            // echo "<br/>";
            //             //echo $id." dan ".$kode." dan ".$no." data tidak match<br/>";
            //             $insertH2hToBk = "INSERT INTO tbl_not_match (tgl_transaksi, kd_produk, status, no_tujuan, alur) values('$tgl_transaksi', '$kode', '$status', '$no', '2')  ";
            //             $db->query($insertH2hToBk);
            //         }
            //     }

            }


        }

    ?>

	
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
                            <li class="nav-item">
                                <a class="nav-link active show" data-toggle="tab" href="#tabs-3-tab-1" role="tab" aria-selected="true" style="margin-top:-5px;">
                                    <span class="nav-link-in">Matching</span>
                                    <span class="percent color-green">20</span> <span class="title"></span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3-tab-2" role="tab" aria-selected="true" style="margin-top:-5px;">
                                    <span class="nav-link-in">Selisih</span>
                                    <span class="percent color-green">20</span> <span class="title"></span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3-tab-3" role="tab" aria-selected="true" style="margin-top:-5px;">
                                    <span class="nav-link-in">Upload</span>
                                    <span class="percent color-green">h2h</span> <span class="title"></span></span>
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
                                    <a class="nav-link  active show aMatchingYears" data-toggle="tab" href="#tabs-simple-tab-1" role="tab" aria-selected="false">Years</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link aMatchingMonths" data-toggle="tab" href="#tabs-simple-tab-2" role="tab" aria-selected="false">Months</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link aMatchingDays" data-toggle="tab" href="#tabs-simple-tab-3" role="tab" aria-selected="false">Days</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active show" id="tabs-simple-tab-1" role="tabpanel">
                                        <!-- <h1> adad</h1> -->
                                        <form id="formMatching">
                                        <input type="hidden" id="role" value="1">
                                        <div class="row rowYearMatching" style="margin-left:5px;">
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih tahun</label>
                                                    <select name="tahunMatching" id="tahunMatching" class="form-control">
                                                        <option value="2019">2019</option>
                                                        <option value="2018">2018</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih bulan</label>
                                                    <select name="bulanMatching" disabled="" id="bulanMatching" class="form-control">
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
                                                    <button style="margin-top:28px;" type="submit" class="btn btn-inline btn-primary-outline">Draw grafik</button>
                                                </fieldset>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- grafik -->
                                        <div id="graph" style="width:100%; height: 400px; margin: 0 auto; display:none">
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
                                    <a class="nav-link  active show aSelisihYears" data-toggle="tab" href="#tabs-simple-tab-1" role="tab" aria-selected="false">Years</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link aSelisihMonths" data-toggle="tab" href="#tabs-simple-tab-2" role="tab" aria-selected="false">Months</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link aSelisihDays" data-toggle="tab" href="#tabs-simple-tab-3" role="tab" aria-selected="false">Days</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active show" id="tabs-simple-tab-1" role="tabpanel">
                                        <!-- <h1> adad</h1> -->
                                        <form id="formSelisih">
                                        <input type="hidden" id="roleSelisih" value="1">
                                        <div class="row rowYearSelisih" style="margin-left:5px;">
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih tahun</label>
                                                    <select id="tahunSelisih" class="form-control">
                                                        <option value="2019">2019</option>
                                                        <option value="2018">2018</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-lg-4">
                                                <fieldset class="form-group">
                                                    <label class="form-label" for="exampleInput">Pilih bulan</label>
                                                    <select  disabled="" id="bulanSelisih" class="form-control">
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
                                                    <button style="margin-top:28px;" type="submit" class="btn btn-inline btn-primary-outline">Draw grafik</button>
                                                </fieldset>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- grafik -->
                                        <div id="graph2" style="width:100%; height: 400px; margin: 0 auto; display:none">
                                        <!-- grafik -->
                                        
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
                                                            <form id="uploadImage" action="matching.php" method="post">
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

	        <div class="row">
	            <div id="pageData" class="col-lg-12 col-md-12">
                <!-- <button class="btn btn-primary">as</button> -->
               
                        
                     </div>  
                </div>
				<span class="flash"></span>
	        </div>

	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP //require_once("_/js.php"); ?>

<script>
function reload2(data, cat, text, textX)
{
    // alert(data);
    var chart = Highcharts.chart('graph2', {
    legend: {
        enabled: false
    },
		chart: {
        zoomType: 'xy'
    },
    title: {
        text: text
    },
    subtitle: {
        // text: 'Source: WorldClimate.com'
    },
    xAxis: [{
        categories: cat,
        // ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni']
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: textX,
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || // theme
            'rgba(255,255,255,0.25)'
    },
    series: [{
        name: 'Total',
        type: 'column',
        data: data,
        tooltip: {
            valueSuffix: ' '
        }

    }]
});
    $('.highcharts-legend-item').hide();
    $('.highcharts-legend-box').hide();
}

function reload(data, cat, text, textX)
{
    // alert(data);
    var chart = Highcharts.chart('graph', {
    legend: {
        enabled: false
    },
		chart: {
        zoomType: 'xy'
    },
    title: {
        text: text
    },
    subtitle: {
        // text: 'Source: WorldClimate.com'
    },
    xAxis: [{
        categories: cat,
        // ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni']
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: textX,
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || // theme
            'rgba(255,255,255,0.25)'
    },
    series: [{
        name: 'Total',
        type: 'column',
        data: data,
        tooltip: {
            valueSuffix: ' '
        }

    }]
});
    $('.highcharts-legend-item').hide();
    $('.highcharts-legend-box').hide();
}

function ajax_reload_graph2(url, sql, text, textX, role, roleSql, tahun, bulan)
{
 
    $.ajax({  
        url:url,  
        method:'POST',  
        data:{sql:sql, role:roleSql, tahun:tahun, bulan:bulan},  
        dataType: 'json',
        // contentType:false,  
        // new FormData(this)
        // processData:false,  
        success:function(data)  
        {  
            // alert(data.data1);
            console.log(data.status);
            if (data.status == "null")
            {
                var obj1 = [0];
                var obj2 = ['Not found'];
                var text = "Data not found";
                if (role == 1)
                {
                    $('#graph').fadeIn();
                    reload(obj1, obj2, text);
                    
                }else {
                    $('#graph2').fadeIn();
                    reload2(obj1, obj2, text);
                }
            }else {            
        
                $('#graph').fadeIn();
                var obj1 = JSON.parse(data.data1);
                var obj2 = JSON.parse(data.data2);
                console.log(obj2);

                function total(arr) {   
                    if(!Array.isArray(arr)) return;
                    let sum=0;
                    arr.forEach(each => {
                        sum+=each;
                    });
                    return sum;
                };
                if (role == 1)
                {
                    $('#graph').fadeIn();
                    reload(obj1, obj2, text, textX);
                    
                }else {
                    $('#graph2').fadeIn();
                    reload2(obj1, obj2, text, textX);
                }

                // reload2(data, gagal, text, totals, totalg, cat, profit, supercat)
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            alert(xhr.responseText);
            // Your error handling logic here..
        }
    });
}

function ajax_reload_graph(url, sql, cari,  cat, text, textX, role, roleSql, tahun, bulan)
{
//  alert(roleSql);
    $.ajax({  
        url:url,  
        method:'POST',  
        data:{sql:sql, cari:cari, role:roleSql, tahun:tahun},  
        dataType: 'json',
        // contentType:false,  
        // new FormData(this)
        // processData:false,  
        success:function(data)  
        {  
            console.log(data.data1);
            // alert(data.data1);
            if (data.status == "null")
            {
                var obj1 = [0];
                var obj2 = ['Not found'];
                var text = "Data not found";
                if (role == 1)
                {
                    $('#graph').fadeIn();
                    reload(obj1, obj2, text);
                    
                }else {
                    $('#graph2').fadeIn();
                    reload2(obj1, obj2, text);
                }
            }else {            
        
                var obj = JSON.parse(data.data1);

                function total(arr) {
                    if(!Array.isArray(arr)) return;
                    let sum=0;
                    arr.forEach(each => {
                        sum+=each;
                    });
                    return sum;
                };

                if (role == 1)
                {
                    $('#graph').fadeIn();
                    reload(obj, cat, text, textX);
                }
                else{
                    $('#graph2').fadeIn();
                    reload2(obj, cat, text, textX);
                }
                // reload2(data, gagal, text, totals, totalg, cat, profit, supercat)
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            alert(xhr.responseText);
            // Your error handling logic here..
        }
    });
}


$(document).ready(function()
{
    reload();
    reload2();
    $(document).on('submit', '#formMatching', function(e)
    {
        e.preventDefault();
        var tahun = $('#tahunMatching').val();
        var bulan = $('#bulanMatching').val();
        var role = $('#role').val();
        
        if (role == '1')
        {
            var sql = "";
            var url = "<?php echo $c_url ?>/grafik/load_grafik_matching_minus.php";
            var cari = "jumlah_bulanan";
            var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni' ,'Juli', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
            var text = "Grafik Not Match Per Tahun";
            var textX = 'Total tidak match';
            var role = 1;
            var roleSql = 1;
            ajax_reload_graph(url, sql, cari, cat, text, textX, role, roleSql, tahun, bulan);
        }
        else if (role == 2)
        {
            var sql = "";
            var url = "<?php echo $c_url ?>/grafik/load_grafik_matching_minus2.php";
            var cari = "jumlah_bulanan";
            var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni' ,'Juli', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
            var text = "Grafik Not Match Per Bulan";
            var textX = 'Total tidak match';
            var role = 1;
            var roleSql = 2;
            ajax_reload_graph2(url, sql, text, textX, role, roleSql, tahun, bulan);
        }
        else if (role == 3)
        {
            var sql = "1";
            var url = "<?php echo $c_url ?>/grafik/load_grafik_matching_minus2.php";
            var cari = "jumlah_bulanan";
            var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni' ,'Juli', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
            var text = "Grafik Not Match Per Hari";
            var textX = 'Total tidak match';
            var role = 1;
            var roleSql = 3;
            ajax_reload_graph2(url, sql, text, textX, role, roleSql,tahun, bulan);
        }

    });

    $(document).on('submit', '#formSelisih', function(e)
    {
        // alert('s');
        e.preventDefault();
        var tahun = $('#tahunSelisih').val();
        var bulan = $('#bulanSelisih').val();
        // alert(tahun);
        var role = $('#roleSelisih').val();
        
        if (role == '1')
        {
            var sql = "";
            var url = "<?php echo $c_url ?>/grafik/load_grafik_matching_minus.php";
            var cari = "jumlah_bulanan";
            var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni' ,'Juli', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
            var text = "Grafik Selisih Per Tahun";
            var textX = 'Total selisih';
            var role = 2;
            var roleSql = 2;
            ajax_reload_graph(url, sql, cari, cat, text, textX, role, roleSql, tahun, bulan);
        }
        else if (role == 2)
        {
            var sql = "";
            var url = "<?php echo $c_url ?>/grafik/load_grafik_matching_minus3.php";
            var cari = "jumlah_bulanan";
            var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni' ,'Juli', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
            var text = "Grafik Selisih Per Bulan";
            var textX = 'Total selisih';
            var role = 2;
            var roleSql = 2;
            ajax_reload_graph2(url, sql, text, textX, role, roleSql, tahun, bulan);
        }
        else if (role == 3)
        {
            var sql = "";
            var url = "<?php echo $c_url ?>/grafik/load_grafik_matching_minus3.php";
            var cari = "jumlah_bulanan";
            var cat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni' ,'Juli', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
            var text = "Grafik Selisih Per Bulan";
            var textX = 'Total selisih';
            var role = 2;
            var roleSql = 3;
            ajax_reload_graph2(url, sql, text, textX, role, roleSql, tahun, bulan);
        }

    });

    $('.aSelisihYears').on('click', function()
    {
        $("#bulanSelisih").prop('disabled', true);
        $("#tahunSelisih").prop('disabled', false);

        $('#roleSelisih').val("1");
        var role = $('#roleSelisih').val();
        console.log(role);

    });

    $('.aSelisihMonths').on('click', function()
    {
        $("#bulanSelisih").prop('disabled', false);
        $("#tahunSelisih").prop('disabled', false);
        $('#roleSelisih').val("2");
        var role = $('#roleSelisih').val();
        // alert(role);
        console.log(role);
    });

    $('.aSelisihDays').on('click', function()
    {
        $("#bulanSelisih").prop('disabled', true);
        $("#tahunSelisih").prop('disabled', true);
        $('#roleSelisih').val("3");
        var role = $('#roleSelisih').val();
        // alert(role);
        console.log(role);
    });

    $('.aMatchingYears').on('click', function()
    {
        $("#tahunMatching").prop('disabled', false);
        $("#bulanMatching").prop('disabled', true);
        $('#role').val("1");
        var role = $('#role').val();
        console.log(role);

    });

    $('.aMatchingMonths').on('click', function()
    {
        $("#bulanMatching").prop('disabled', false);
        $("#tahunMatching").prop('disabled', false);
        $('#role').val("2");
        var role = $('#role').val();
        // alert(role);
        console.log(role);
    });

    $('.aMatchingDays').on('click', function()
    {
        $("#bulanMatching").prop('disabled', true);
        $("#tahunMatching").prop('disabled', true);
        $('#role').val("3");
        var role = $('#role').val();
        // alert(role);
        console.log(role);
    });

    //upload file
    $('#uploadImage').submit(function(event){
        var nama = $('#uploadFile').val().split(/(\\|\/)/g).pop();
        // alert(nama);
        var extension = $('#uploadFile').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['xlsx']) == -1)
            {
                alert("Invalid Excel File");
                $('#uploadFile').val('');
                return false;
            }
        } 
        if($('#uploadFile').val())
        {
            event.preventDefault();
            $('#uploading-list-title').show();
            // $('#targetLayer').hide();
                $(this).ajaxSubmit({
                    target: '#targetLayer',
                    // dataType:'json',
                    beforeSubmit:function(){
                        // $('.progress-bar').width('50%');
                        $('#namaFile').html(nama);
                        $('.uploading-list').show();
                    },
                    uploadProgress: function(event, position, total, percentageComplete)
                    {
                        swal({
                            title: "Importing and analyzing",
                            text: "Data sedang diproses, mohon halaman ini jangan di reload atau pun di close!!!"
                        });
                        $('.progress-bar').animate({
                            width: percentageComplete + '%'
                            }, {
                            duration: 1000
                            });
                        },
                        
                        success:function(data){
                            // alert(data);
                            // if (data == "sukses")
                            // {
                                $('#uploading-list-title').hide();
                                $('.uploading-list').hide();
                            

                                // e.preventDefault();
                                swal({
                                    title: "Good job!",
                                    text: "You clicked the button!",
                                    type: "success",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Close"
                                });
                            //     location.reaload();
                            // }
                            // else{
                            //     alert("Something wrong, contact administrator!");
                            // }
                        
                            
                        },
                    resetForm: true
            });
        }
        return false;
    });
    
    reload();
    $(document).on('submit', '#formDateRange', function(e)
    {
        e.preventDefault();
        let start = $('.start').val();
        let end = $('.end').val();
        // alert(end);
        $.ajax({  
            url:"http://localhost/2019/bukakios/admin.bukakios.net/grafik/load_minus.php",  
            method:'POST',  
            data:{start:start, end:end},  
            dataType: 'json',
            // contentType:false,  
            // new FormData(this)
            // processData:false,  
            success:function(data)  
            {  
                if (data.status == "null")
               {
                    var das = [0];
                    var obj23 = ['null'];    
                    var textx = "Data not found";
                        $('.number').html("0");

                    reload(das, obj23, textx);
               }else {            
        
                // console.log(d);
                // var d = JSON.parse(data.data1);
                // console.log(d);
                var obj = JSON.parse(data.data1);
                var obj2 = JSON.parse(data.data2);
                // var daa = [200,300,400,500];
                var daa = obj;
                console.log(obj);
                
                console.log(total(obj));
                var totala = total(obj);
                $('.number').html(totala);
                //sum total minus
                function total(arr) {
                    if(!Array.isArray(arr)) return;
                    let sum=0;
                    arr.forEach(each => {
                        sum+=each;
                    });
                    return sum;
                };
                // alert(daa);
                    console.log(data.data1);
                    // console.log(data.data2);
                    // alert(data.data2);
                var text = "Graph minus";

                reload(daa, obj2, text);
               }
            },
            error: function (jqXHR, exception) {
                console.log(jqXHR);
                // Your error handling logic here..
            }
        });


    });

    $(document).on('submit', '#formNotMatch', function(e)
    {
        e.preventDefault();
        let start = $('.startMatch').val();
        let end = $('.endMatch').val();
        // alert(end);
        $.ajax({  
            url:"<?php echo $c_url ?>/grafik/load_not_match.php",  
            method:'POST',  
            data:{start:start, end:end},  
            dataType: 'json',
            // contentType:false,  
            // new FormData(this)
            // processData:false,  
            success:function(data)  
            {  
               console.log(data.status);
            //    alert(data.status);           
               if (data.status == "null")
               {
                    var das = [0];
                    var obj23 = ['null'];    
                    var textx = "Data not found";
                $('.numberMatch').html("0");

                    reload(das, obj23, textx);
               }else {     
                // console.log(d);
                // var d = JSON.parse(data.data1);
                // console.log(d);
                var obj = JSON.parse(data.data1);
                var obj2 = JSON.parse(data.data2);
                // var daa = [200,300,400,500];
                var daa = obj;
                
                console.log(total(obj));
                var totals = total(obj);
                $('.numberMatch').html(totals);
                //sum total minus
                function total(arr) {
                    if(!Array.isArray(arr)) return;
                    let sum=0;
                    arr.forEach(each => {
                        sum+=each;
                    });
                    return sum;
                };
                // alert(daa);
                    console.log(data.data1);
                    // console.log(data.data2);
                    // alert(data.data2);
                var text = "Graph not match";
                reload(daa, obj2, text);
               }
            },
            error: function (jqXHR, exception) {
                console.log(jqXHR);
                // Your error handling logic here..
            }


        });


    });
});
$(function() {
    $('.flatpickr').flatpickr();


});





</script>
    <!-- <script src="js/lib/jquery/jquery-3.2.1.min.js"></script> -->
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

<script src="js/app.js"></script>
</body>
</html>
