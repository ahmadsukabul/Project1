<?php
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");


        $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
        $kemaren  = date('d/m/y', $tgl);
        echo $startkemarin = $kemaren." 00:00:00";
        echo $endkemarin = $kemaren." 23:59:00";

        //cari harga yang tidak sesuai dengan 
        $sql = "SELECT * from tbl_import_h2h where tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
        $datah2h = $db->fetch_multiple($sql);
        $u = 0;
        $totalminus = 0;

// echo date('d-m-Y H:i:s');

// select * from hockey_stats 
// where game_date between '2012-03-11 00:00:00' and '2012-05-11 23:59:00' 
// order by game_date desc;

        foreach ( $datah2h as $rows2 )
        {
            $kode = $rows2['kd_produk'];
            $no = $rows2['no_tujuan'];
            
            $id = $rows2['id'];
            $harga_jual = $rows2['harga_jual'];
            $tgl_transaksi = $rows2['tgl_transaksi'];
            // $tgl = 
            $c = $rows2['harga_jual'];
            
            //tgl kemarin
            $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
            $kemaren  = date('Y-m-d', $tgl);
            $startkemarin = $kemaren." 00:00:00";
            $endkemarin = $kemaren." 23:59:00";
            
            //   $sqlHarga = "SELECT * from transaksi where product_code='$kode' && nomor_tujuan='$no' && created_at between between '2019-09-17 00:00:00' and '2019-09-17 23:59:00'";
            $sqlHarga = "SELECT * from tbl_import_h2h2 where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

            $index = "harga_jual";

            $cari = $db->banding_harga($sqlHarga, $c, $index);
            if ($cari != false)
            {
                $totalminus = $totalminus + $cari;
                echo "<br/> dengan kode ".$kode." dan no tujuan ".$no." ada minus ".$cari;
                $insertH2hToBk = "INSERT INTO tbl_minus_harga (tgl_transaksi, kd_produk,  no_tujuan, harga_jual, minus, alur) values('$tgl_transaksi', '$kode', '$no', '$harga_jual', '$cari', '1')  ";
                $db->query($insertH2hToBk);
            }
        }

        echo "<br/> total minus".$totalminus;

        $alldata = $db->fetch_multiple($sql);
        $minus = 0;
        foreach ($alldata as $hasil)
        {
            $kode = $hasil['kd_produk'];
            $no = $hasil['no_tujuan'];
            $id = $hasil['id'];
            $tgl_transaksi = $rows2['tgl_transaksi'];
            $status = $rows2['status'];

            
            $sql = "SELECT * from tbl_import_h2h2 where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

            // $sql = "SELECT * from tbl_bk where kode_produk='$kode' && no_tujuan='$no' && tanggal between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            // cari data yang sesuai di tbl bk
            $databk = $db->num_rows($sql);
            if ($databk <= 0)
            {
                echo "<br/>";
                echo $id." dan ".$kode." dan ".$no." data tidak match<br/>";
               
                $insertH2hToBk = "INSERT INTO tbl_not_match (tgl_transaksi, kd_produk, status, no_tujuan, alur) values('$tgl_transaksi', '$kode', '$status', '$no', '1')  ";
                $db->query($insertH2hToBk);
            }
        }


        //dari bk ke h2h
        // echo "<br/><br/><br/>";
        // $sql = "SELECT * from tbl_import_h2h2 where tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
        // $datah2h = $db->fetch_multiple($sql);   
        // foreach ( $datah2h as $rows2 )
        // {
        //     $kode = $rows2['kd_produk'];
        //     $no = $rows2['no_tujuan'];
        //     $id = $rows2['id'];
        //     // $tgl = 
        //     $c = $rows2['harga_jual'];
        //     $tgl_transaksi = $rows2['tgl_transaksi'];
        //     $status = $rows2['status'];
        //     //tgl kemarin
        //     $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
        //     $kemaren  = date('Y-m-d', $tgl);
        //     $startkemarin = $kemaren." 00:00:00";
        //     $endkemarin = $kemaren." 23:59:00";
            
        //     //   $sqlHarga = "SELECT * from transaksi where product_code='$kode' && nomor_tujuan='$no' && created_at between between '2019-09-17 00:00:00' and '2019-09-17 23:59:00'";
        //         $sqlHarga = "SELECT * from tbl_import_h2h where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

        //         $index = "harga_jual";

        //     $cari = $db->banding_harga2($sqlHarga, $c, $index);
        //     if ($cari != false)
        //     {
        //         $totalminus = $totalminus + $cari;
        //         echo "<br/> dengan kode ".$kode." dan no tujuan ".$no." ada minus ".$cari;
        //         $insertH2hToBk = "INSERT INTO tbl_minus_harga (tgl_transaksi, kd_produk,  no_tujuan, harga_jual, minus, alur) values('$tgl_transaksi', '$kode', '$no', '$c', '$cari', '2')  ";
        //         $db->query($insertH2hToBk);
        //     }
        // }

        // echo "<br/> total minus".$totalminus;

        $alldata = $db->fetch_multiple($sql);
        $minus = 0;
        foreach ($alldata as $hasil)
        {
            $kode = $hasil['kd_produk'];
            $no = $hasil['no_tujuan'];
            $id = $hasil['id'];
            $tgl_transaksi = $rows2['tgl_transaksi'];
            $status = $rows2['status'];
            $sql = "SELECT * from tbl_import_h2h where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";

            // $sql = "SELECT * from tbl_bk where kode_produk='$kode' && no_tujuan='$no' && tanggal between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            // cari data yang sesuai di tbl bk
            $databk = $db->num_rows($sql);
            if ($databk <= 0)
            {
                echo "<br/>";
                echo $id." dan ".$kode." dan ".$no." data tidak match<br/>";
                $insertH2hToBk = "INSERT INTO tbl_not_match (tgl_transaksi, kd_produk, status, no_tujuan, alur) values('$tgl_transaksi', '$kode', '$status', '$no', '2')  ";
                $db->query($insertH2hToBk);
            }
        }

?>