<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_approvel_send.php");
}else{
	$csrf = $app->csrf();
}
if(isset($_GET['id'])){
    $id_topup = abs((int)$_GET['id']);
}else{
    exit;
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Approve Topup - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class='col-md-12 col-xs-12 col-lg-12'>
					<?PHP 
                    require_once("_/_alert_message.php");
                    ?>
					<section class="card card-green mb-3">
						<header class="card-header">
							Approve Topup #<?PHP echo $id_topup; ?>
						</header>
						<div class="card-block">
							<form action='' method='post'>
                            <a style='margin-bottom:10px' href='https://assets.bukakios.net/img2/?key=d62c9b77be0ca0789e549e47dd56a637' target='_blank' class='btn btn-primary'>Upload Gambar...</a>
							<div class='alert alert-primary'>
                                Sekarang untuk approve topup manual wajib melalui prosedur ini... mohon di isi data di bawah ini.
                            </div>
                            <fieldset>
                                <label class="form-label">Gambar Bukti Transfer, jika gambar lebih dari 1 pisahkan dengan tanda <b>;</b> *</label>
								<input required name='bukti' class='form-control' type='text' placeholder='https://assets.bukakios.net/img2/uploads/2019/07/201-kbb1.jpg'/>
                            </fieldset>
                            <fieldset class="form-group" style='margin-top:10px'>
								<label class="form-label">Keterangan Topup (Mohon di jelaskan , sejelas-jelasnya)</label>
								<textarea name='keterangan' class='form-control' rows='3'></textarea>
							</fieldset>
                            <input type='hidden' name='id_topup' value='<?PHP echo $id_topup; ?>'/>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='add'/>
							<button class='btn btn-success'>Kirim Pengajuan</button>
							</form>
						</div>
					</section>
					
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
</body>
</html>