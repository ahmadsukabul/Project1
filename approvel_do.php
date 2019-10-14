<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_GET['id'])){
	$id = abs((int)$_GET['id']); //ini id status ar..... 
	$data_ar = $db->fetch("select 
    ar.id_ar,ar.topup_id,ar.admin_request,ar.admin_approve,ar.created_at,ar.status_ar,a.name as nama_request,ad.name as nama_approve,ar.image_ar,ar.info_ar
    from approvel_request ar
    inner join admin a on ar.admin_request=a.id 
    left join admin ad on ar.admin_approve=ad.id where ar.id_ar='$id'");
    $topup_id = $data_ar['topup_id'];
    $data_topup = $db->fetch("select 
    t.topup_metode,t.nominal_topup,t.kode_unik,t.fee,t.total_transfer,t.uid,tm.nama_kategori,tm.nama_metode,u.nama,u.nama_toko,t.status,t.created_at
    from topup t 
    inner join users u on t.uid=u.id 
    inner join topup_metode tm on t.topup_metode=tm.id
    where t.id='$topup_id'
    ");
    if(!isset($data_ar['id_ar'])){
        echo "Topup ini belum ada di request kan!";
        exit;
    }
    $hash_topup = md5("$topup_id:$data_topup[uid]:$data_topup[topup_metode]:$data_topup[created_at]");
    //status translate 
    if($data_ar['status_ar']==0){
        $status_ar = "<span class='label label-warning'>Pending</span>";
    }else if($data_ar['status_ar']==1){
        $status_ar = "<span class='label label-success'>Approve</span>";
    }else{
        $status_ar = "<span class='label label-danger'>Deny</span>";
    }
    if($data_topup['status']==0){
		$status_topup = "<span class='label label-warning'>Menunggu Pembayaran</span>";
	}else if($data_topup['status']==1){
        $status_topup = "<span class='label label-success'>Sukses</span>";
        if($data_ar['status_ar']==0){
            //karna topup sudah masuk ke user maka buat status request juga jadi 1
            $db->query("update approvel_request set status_ar=1 where id_ar='$id'");
        }
	}else{
		$status_topup = "<span class='label label-danger'>Dibatalkan</span>";
	}
}else{
	exit;
}
if(isset($_REQUEST['act'])){
	require_once("_act/_approvel_do.php");
}else{
	$csrf = $app->csrf();
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Info Approvel #<?PHP echo $id; ?> - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
	<link rel='stylesheet' type='text/css' href='<?PHP echo "$assets_url/css/box.css"; ?>'/>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
			<div class='row'>
				<div class='col-md-12'>
					<section class="card mb-3">
						<header class="card-header card-header-xxl">
							Form Approvel #<?PHP echo $id; ?>
						</header>
						<div class="card-block">
							<div class='row'>
								<div class='col-md-12'>
                                    <?PHP require_once("_/_alert_message.php"); ?>
									<table class='table table-bordered table-hover' style='margin-bottom:20px'>
										<thead>
											<tr>
											  <th colspan=3><center>Informasi Approvel</center></th>
											</tr>
										 </thead>
										 <tbody>
											<tr class=''>
												<td>Topup ID</td>
												<td><a href='detail_topup.php?id=<?PHP echo $topup_id; ?>' target='_blank'>#<?PHP echo $topup_id; ?></a></td>
											</tr>
											<tr class=''>
												<td>Admin Request</td>
												<td><?PHP echo $data_ar['nama_request']; ?></td>
											</tr>
											<tr class=''>
												<td>Admin Approve</td>
												<td><?PHP echo $data_ar['nama_approve']; ?></td>
											</tr>
											<tr class=''>
												<td>User Topup</td>
												<td><?PHP echo "<a href='info_user.php?id=$data_topup[uid]' target='_blank'>$data_topup[nama]  ($data_topup[nama_toko])</a>"; ?></td>
											</tr>
											<tr class=''>
												<td>Nominal Topup Masuk ke akun</td>
												<td><?PHP echo $app->idr($data_topup['nominal_topup']+$data_topup['kode_unik']); ?></td>
											</tr>
                                            <tr class=''>
												<td>Jumlah Yang Harus Di Transfer</td>
												<td><?PHP echo $app->idr($data_topup['total_transfer']); ?></td>
											</tr>
											<tr class=''>
												<td>Metode Topup</td>
												<td><?PHP echo "$data_topup[nama_kategori] - $data_topup[nama_metode]"; ?></td>
											</tr>
											<tr class=''>
												<td>Tanggal Topup</td>
												<td><?PHP echo date('d F Y - H:i', strtotime($data_topup['created_at']))." WIB"; ?></td>
											</tr>
                                            <tr class=''>
												<td>Tanggal Request</td>
												<td><?PHP echo date('d F Y - H:i', strtotime($data_ar['created_at']))." WIB"; ?></td>
											</tr>
                                            <tr class=''>
												<td>Status Topup</td>
												<td><?PHP echo $status_topup; ?></td>
											</tr>
                                            <tr class=''>
												<td>Status Rquest</td>
												<td><?PHP echo $status_ar; ?></td>
											</tr>
										 </tbody>
									</table>
									<hr>
									<h5>Info Dari Admin Request</h5>
                                    <div class='box' style='cursor:default;padding:20px;padding-bottom:10px'>
                                    <p class="lead">
                                        <?PHP echo $data_ar['info_ar']; ?>
                                    </p>
                                    </div>
                                    <?PHP 
                                    //image bukti
                                    $buktis = $data_ar['image_ar'];
                                    if($app->contains($buktis,";")){
                                        //multi image
                                        $bukti = explode(";",$buktis);
                                        foreach($bukti as $img){
                                            echo "<img src='$img' style='max-width:100%'/> <p>";
                                        }
                                    }else{
                                        echo "<img src='$buktis' style='max-width:100%'/>";
                                    }
                                    ?>
                                    <hr>
									<h5>Aksi</h5>
                                    <?PHP if($data_ar['status_ar']==0){ ?>
                                    <a href='<?PHP echo "approvel_do.php?csrf=$csrf&id=$id&act=approve"; ?>' class='btn btn-success'>Terima</a>
                                    <a href='<?PHP echo "approvel_do.php?csrf=$csrf&id=$id&act=deny"; ?>' class='btn btn-danger'>Tolak</a>
                                    <?PHP } ?>
								</div>
								
							</div>
						</div>
					</section>
				</div>
			</div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->
	<?PHP require_once("_/js.php"); ?>
</body>
</html>