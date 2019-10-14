<?php 
$auto_connect = 1; //auto connect database;
require_once("config.php");
include 'file_csv/SimpleXLSX.php';
// include 'koneksi.php';
// include 'grafik/lib_matching.php';
// include 'grafik/lib_db.php';



// $db2 = new Lib_matching();
// $db2 = new Second_db();


try {
    $conn = new PDO( "mysql:host=localhost;dbname=bukakios_h2h", "root", "");
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $db2 = new lib_matching();
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

// matching_h2h_bk($db2);
// cari_selisih($db2);

// break;
  

    //upload.php
    function cari_selisih($db2)
    {
        // $db2 = new Second_db();
        $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
        $kemaren  = date('d/m/Y', $tgl);
        $kemaren2  = date('Y-m-d', $tgl);
        $startkemarin = $kemaren." 00:00:00";
        $endkemarin = $kemaren." 23:59:00";
        $sql = "SELECT * FROM tbl_import_h2h where tgl_transaksi between '$startkemarin' and '$endkemarin'";
        $alldata = $db2->fetch_multiple($sql);

        foreach ($alldata as $rows2)
        {
            $kode = $rows2['kd_produk'];
            $no = $rows2['no_tujuan'];
            $id = $rows2['id'];
            $harga_jual = $rows2['harga_jual'];
            $tgl_transaksi = substr($rows2['tgl_transaksi'],  11);
            $start = $kemaren2." "."00:00:00";
            $end = $kemaren2." "."23:59:00";
            $tgl = $kemaren2." ".$tgl_transaksi;

   
            // //   $sqlHarga = "SELECT * from transaksi where product_code='$kode' && nomor_tujuan='$no' && created_at between between '2019-09-17 00:00:00' and '2019-09-17 23:59:00'";
            $sqlHarga = "SELECT * from tbl_import_bk where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '$start' and '$end'";
            $dataharga = $db2->banding_harga($sqlHarga, $harga_jual);
            // echo var_dump($dataharga);
            if ($dataharga != false)
            {
                // echo "<br/> dengan kode ".$kode." dan no tujuan ".$no." ada minus ".$dataharga;
                $insert = "INSERT INTO tbl_minus_harga (tgl_transaksi, kd_produk,  no_tujuan, harga_jual, minus, alur) values('$tgl', '$kode', '$no', '$harga_jual', '$dataharga', '1')  ";
		        $db2->query($insert);

                
            }
            
        }
    }

    //matching h2h to bk
    function matching_h2h_bk($db2)
    {
        // $db2 = new Second_db();
        $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
        $kemaren  = date('d/m/Y', $tgl);
        $kemaren2  = date('Y-m-d', $tgl);
        $startkemarin = $kemaren." 00:00:00";
        $endkemarin = $kemaren." 23:59:00";
        $sql = "SELECT * FROM tbl_import_h2h where tgl_transaksi between '$startkemarin' and '$endkemarin'";
        $alldata = $db2->fetch_multiple($sql);

        foreach ($alldata as $hasil)
        {
            $kode = $hasil['kd_produk'];
            $no = $hasil['no_tujuan'];
            $id = $hasil['id'];
            $tgl_transaksi = substr($hasil['tgl_transaksi'],  11);
            $tgl_transaksi = $kemaren2." ".$tgl_transaksi;
            // $tgl_transaksi = $kemaren2." ".$tgl_transaksi;
            $startkemarin = $kemaren2." 00:00:00";
            $endkemarin = $kemaren2." 23:59:00";
            $status = $hasil['status'];

            
            $sql = "SELECT * from tbl_import_bk where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '$startkemarin' and '$endkemarin'";

            // $sql = "SELECT * from tbl_bk where kode_produk='$kode' && no_tujuan='$no' && tanggal between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            // cari data yang sesuai di tbl bk
            $databk = $db2->num_rows($sql);
            if ($databk <= 0)
            {
                // echo "<br/>";
                // $id." dan ".$kode." dan ".$no." data tidak match<br/>";
            
                $insertH2hToBk = "INSERT INTO tbl_not_match (tgl_transaksi, kd_produk, status, no_tujuan, alur) values('$tgl_transaksi', '$kode', '$status', '$no', '1')  ";
                $db2->query($insertH2hToBk);
            }
        }
    }

    //matching bk to h2h
    function matching_bk_h2h($db2)
    {
        // $db2 = new Second_db();
        $tgl =  mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
        $kemaren  = date('d/m/Y', $tgl);
        $kemaren2  = date('Y-m-d', $tgl);
        $startkemarin = $kemaren2." 00:00:00";
        $endkemarin = $kemaren2." 23:59:00";
        $sql = "SELECT * FROM tbl_import_bk where tgl_transaksi between '$startkemarin' and '$endkemarin'";
        $alldata = $db2->fetch_multiple($sql);
        // echo var_dump($alldata);
        foreach ($alldata as $hasil)
        {
            $kode = $hasil['kd_produk'];
            $no = $hasil['no_tujuan'];
            $id = $hasil['id'];
            $tgl_transaksi = substr($hasil['tgl_transaksi'],  11);
            $tgl_transaksi = $kemaren2." ".$tgl_transaksi;
            // $tgl_transaksi = $kemaren2." ".$tgl_transaksi;
            $startkemarin = $kemaren." 00:00:00";
            $endkemarin = $kemaren." 23:59:00";
            $status = $hasil['status'];

            
            $sql = "SELECT * from tbl_import_h2h where kd_produk='$kode' && no_tujuan='$no' &&  tgl_transaksi between '$startkemarin' and '$endkemarin'";
            

            // $sql = "SELECT * from tbl_bk where kode_produk='$kode' && no_tujuan='$no' && tanggal between '17/09/2019 00:00:00' and '17/09/2019 22:59:00'";
            // cari data yang sesuai di tbl bk
            $databk = $db2->num_rows($sql);
            if ($databk <= 0)
            {
                // echo "<br/>";
                // $id." dan ".$kode." dan ".$no." data tidak match<br/>";
            
                $insertH2hToBk = "INSERT INTO tbl_not_match (tgl_transaksi, kd_produk, status, no_tujuan, alur) values('$tgl_transaksi', '$kode', '$status', '$no', '2')  ";
                $db2->query($insertH2hToBk);
            }
        }
    }

    if(!empty($_FILES))
    {
        if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
        {
            sleep(1);
            $source_path = $_FILES['uploadFile']['tmp_name'];
            $nama_file = rand().$_FILES['uploadFile']['name'];
            $target_path = 'file_csv/'.$nama_file;


            // insert data to table
            $nama = $nama_file;
            $file = date('Y-m-d h:m:s');

            //insert file to import_h2h

            // echo "ada";

            // $s = 0;
            if(move_uploaded_file($source_path, $target_path))
            {
                $sql = "INSERT INTO tbl_import_file_h2h (nama_file, created_at) values ('$nama', '$file')";  
                // $row = mysqli_query($koneksi, $sql);

                //import excel to tbl_import_h2h
                // $stmt = $conn->prepare( "INSERT INTO tbl_import_h2h(tgl_transaksi, kd_produk, no_tujuan, no_hp, harga_jual, status, tgl_status, saldo_awal, saldo_akhir, sn) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $xlsx = new SimpleXLSX("file_csv/".$nama_file);

                $stmt = $conn->prepare("INSERT INTO `tbl_import_h2h` (`id`, `tgl_transaksi`, `kd_produk`, `no_tujuan`, `no_hp`, `harga_jual`, `status`, `tgl_status`, `saldo_awal`, `saldo_akhir`, `sn`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                // $stmt = $conn->prepare( "INSERT INTO tbl_transaksi (id_transaksi, user_id, h2h, kode_produk, no_tujuan, harga,  profit, tanggal) VALUES (?,?,?,?,?,?,?,?)");
                // $stmt->execute();

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
                    // $stmt->execute();
                }

                // cari_selisih($db2);
                // matching_h2h_bk($db2);
                // matching_bk_h2h($db2);
                // echo "sukses";x
                // $out = array();
                // $out['status'] = "sukses";
                // echo json_encode($out);
            }                

        }

    }