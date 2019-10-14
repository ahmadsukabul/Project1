<?php 
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
include 'grafik/SimpleXLSX.php';


// if (isset( $_FILES['csv']['name']))
// {
    $nama = $_FILES['csv']['name'];
    $namaSementara = $_FILES['csv']['tmp_name'];
    // $dir = "/grafik/";
    // move_uploaded_file($namaSementara, 'grafik/'.$nama);
    // move_uploaded_file($namaSementara, $dir);

    $xlsx = new SimpleXLSX('History Transaksi (2019-10-03).xlsx');
    // $xlsx = new SimpleXLSX( 'countries_and_population.xlsx' );
    // try {
    //    $conn = new PDO( "mysql:host=localhost;dbname=buka_kios", "root", "");
    //    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // }
    // catch(PDOException $e)
    // {
    //     echo $sql . "<br>" . $e->getMessage();
    // }
    $stmt = $conn->prepare( "INSERT INTO tbl_bk(tmp_tgl_transaksi, tmp_kd_produk, tmp_no_tujuan, tmp_no_hp, tmp_harga_jual, tmp_status, tmp_tgl_status, tmp_saldo_awal, tmp_saldo_akhir, tmp_sn) VALUES (?,?,?,?,?,?,?,?,?,?)");
    // $stmt = $conn->prepare( "INSERT INTO tbl_transaksi (id_transaksi, user_id, h2h, kode_produk, no_tujuan, harga,  profit, tanggal) VALUES (?,?,?,?,?,?,?,?)");
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



// }


?>