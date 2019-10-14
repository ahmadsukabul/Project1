<?php 
// menghubungkan dengan koneksi
// include 'koneksi.php';
// menghubungkan dengan library excel reader
// include "excel_reader2.php";
include 'file_csv/SimpleXLSX.php';


// $db = new koneksi();
?>

<?php

    $xlsx = new SimpleXLSX('file_csv/32522History Transaksi (2019-10-09)Dari H2h.xlsx');
    // $xlsx = new SimpleXLSX( 'countries_and_population.xlsx' );
    try {
       $conn = new PDO( "mysql:host=localhost;dbname=bukakios", "root", "");
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $stmt = $conn->prepare( "INSERT INTO tbl_import_h2h2(tgl_transaksi, kd_produk, no_tujuan, no_hp, harga_jual, status, tgl_status, saldo_awal, saldo_akhir, sn) VALUES (?,?,?,?,?,?,?,?,?,?)");
    // $stmt = $conn->prepare( "INSERT INTO transaksi2 (user_id, h2h, kode_produk, no_tujuan, modal,  profit, tanggal) VALUES (?,?,?,?,?,?,?)");
    $stmt->bindParam( 1, $data1);
    $stmt->bindParam( 2, $data2);
    $stmt->bindParam( 3, $data3);
    $stmt->bindParam( 4, $data4);
    $stmt->bindParam( 5, $data5);
    $stmt->bindParam( 6, $data6);
    $stmt->bindParam( 7, $data7);
    $stmt->bindParam( 8, $data8);
    $stmt->bindParam( 9, $data9);
    $stmt->bindParam( 10, $data10);
    foreach ($xlsx->rows() as $fields)
    {
        $data1 = $fields[0];
        $data2 = $fields[1];
        $data3 = $fields[2];
        $data4 = $fields[3];
        $data5 = $fields[4];
        $data6 = $fields[5];
        $data7 = $fields[6];
        $data8 = $fields[7];
        $data9 = $fields[8];
        $data10 = $fields[9];
        $stmt->execute();
    }

    
    //filter berdasarkan baris
    // $totals = mysql_query("SELECT * FROM tbl_tmp_h2");
    // if($totals === false){
    //     throw new Exception(mysql_error($koneksi));
    // }

    // $alldata = $db->tampil_data();
    // $minus = 0;
    // foreach ($alldata as $hasil)
    // {
    //     $a = $hasil['kd_produk'];
    //     $b = $hasil['no_tujuan'];
    //     $id = $hasil['id'];
        

    //     //cari data yang sesuai di tbl bk
    //     $databk = $db->cari_data_bk($a, $b);
    //     if ($databk <= 0)
    //     {
    //         echo "<br/>";
    //         echo $id." dan ".$a." dan ".$b." data tidak match<br/>";
    //     }
    // }

    // //cari harga yang tidak sesuai dengan 
    // $datah2h = $db->tampil_data();
    // $u = 0;
    // $totalminus = 0;

    // // echo date('d-m-Y H:i:s');

    // // select * from hockey_stats 
    // // where game_date between '2012-03-11 00:00:00' and '2012-05-11 23:59:00' 
    // // order by game_date desc;

    // foreach ( $datah2h as $rows2 )
    // {
    //     $a = $rows2['kd_produk'];
    //     $b = $rows2['no_tujuan'];
    //     $id = $rows2['id'];
    //     $c = $rows2['harga_jual']."<br/>";

    //     $cari = $db->banding_harga($a, $b, $c);
    //     if ($cari != false)
    //     {
    //         $totalminus = $totalminus + $cari;
    //         echo "<br/>".$u++." dengan kode ".$a." dan no tujuan ".$b." ada minus ".$cari;
    //     }
    // }
    // echo "<br/> total minus".$totalminus;


?>



<?php 
    // if (isset($_POST['kd']))
    // {
    //     $kd = $_POST['kd'];

    //     $totalh2h = mysql_query("SELECT * FROM tbl_tmp_h2h where tmp_kd_produk = '$kd'");
    //     $num_rows = mysql_num_rows($totalh2h);

    // }

?>