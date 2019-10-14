<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");

include 'grafik/lib_matching.php';

$conn = new Lib_matching();

?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
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
                <?php 
                            $date = date("Y-m-d h:m:s");

                            $alldata = $conn->tampil_data();
                            $minus = 0;
                            $notmatch = 0;
                            // $dataminus = array();
                            $datamatch = array();
                            foreach ($alldata as $hasil)
                            {
                                $a = $hasil['kd_produk'];
                                $b = $hasil['no_tujuan'];
                                $c = $hasil['tgl_transaksi'];
                                $d = $hasil['status'];

                                $id = $hasil['id'];
                                
                        
                                //cari data yang sesuai di tbl bk
                                $databk = $conn->cari_data_bk($a, $b);
                                if ($databk <= 0)
                                {
                                    echo "<br/>";
                                    echo $id." dan ".$a." dan ".$b." data tidak match<br/>";
                                    $notmatch++;

                                    //jika data tidak match insert to tbl_not_match
                                    // $conn->insert_not_match($c, $a, $d, $b);
                                }
                            }
                            // echo "notmatch".$notmatch;
                            
                            //jika notmatch besar dari 0
                            //tambah data ke total not match
                            // $conn->insert_total_not_match($date, $notmatch);
                        
                            //cari harga yang tidak sesuai dengan 
                            $datah2h = $conn->tampil_data();
                            $u = 0;
                            $totalminus = 0;
                        
                            // echo date('d-m-Y H:i:s');
                        
                            // select * from hockey_stats 
                            // where game_date between '2012-03-11 00:00:00' and '2012-05-11 23:59:00' 
                            // order by game_date desc;
                        
                            foreach ( $datah2h as $rows2 )
                            {
                                $a = $rows2['kd_produk'];
                                $b = $rows2['no_tujuan'];
                                $id = $rows2['id'];
                                $c = $rows2['harga_jual']."<br/>";
                        
                                $cari = $conn->banding_harga($a, $b, $c);
                                if ($cari != false)
                                {
                                    // $totalminus = $totalminus + $cari;
                                    // echo "<br/>".$u++." dengan kode ".$a." dan no tujuan ".$b." ada minus ".$cari;
                                   
                                }
                            }
                            // // echo "<br/> total minus".$totalminus;
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Process matching</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Panel subtitle</h6>

                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th>No</th>
							<th>Laporan</th>
						</tr>
						</thead>
						<tbody>
                           <?php 
                           $no = 1;
                                foreach ( $datah2h as $rows2 )
                                {
                                    $a = $rows2['kd_produk'];
                                    $b = $rows2['no_tujuan'];
                                    $d = $rows2['tgl_transaksi'];
                                    $e = $rows2['harga_jual'];
                                    $id = $rows2['id'];
                                    $c = $rows2['harga_jual']."<br/>";
                                    $cac = 0;
                                    $cari = $conn->banding_harga($a, $b, $c);
                                    $resultcari[] = $cari;
                                    // echo $cac = $cari;
                                    if ($cari != false)
                                    {   

                                        echo "<tr>";
                                        echo "<td>".$no."</td>";

                                        // echo $totalminus = 0 + $cari;
                                        echo "<td>dengan kode ".$a." dan no tujuan ".$b." ada minus ".$cari."</td>";
                                       echo "</tr>";
                                    $no++;

                                        //jika ada minus insert data ke tbl_minus_harga
                                        $kd_produk = $a;
                                        $tgl_transaksi = $d;
                                        $no_tujuan= $b;
                                        $harga_jual = $e;
                                        $minus= $cari;

                                        // $conn->insert_minus_harga($d, $a, $b, $e, $cari);

                                    }
                                }
                                $tmp = 0;
                                foreach ($resultcari as $das)
                                {
                                    $tmp = $tmp + $das;
                                }

                                if ($tmp != "")
                                {
                                    // $conn->insert_total_minus($date, $tmp);


                                }
                                // echo $tmp;
                            echo "<br/> total minus".$tmp;

                            ?>
                            
                        </tbody>
                        </table>

                        </div>
                    </div>
                </div>
				<span class="flash"></span>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
</body>
</html>
