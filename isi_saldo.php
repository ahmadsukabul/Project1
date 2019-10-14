<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_POST['act'])){
	require_once("_act/_isi_saldo.php");
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
	<title>Isi Saldo H2H - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
				<div class='col-md-12'>
					<?PHP require_once("_/_alert_message.php"); ?>
					<section class="card card-blue mb-3">
						<header class="card-header">
							Isi Saldo Ke H2H
						</header>
						<div class="card-block">
							<form action='' method='post'>
								<fieldset class="form-group">
									<label class="form-label">Pilih H2H </label>
									<select class='form-control' name='to'>
										<?PHP 
										$h2h_list = $db->fetch_multiple("select id_h2h,jabber_h2h,nama_h2h from h2h order by id_h2h ASC");
                                        $no = 1;
                                        foreach($h2h_list as $h2h){
                                            echo "<option value='$h2h[id_h2h]'>$no. $h2h[nama_h2h] | $h2h[jabber_h2h]</option>";
                                            $no++;
										}
										?>
									</select>
								</fieldset>
								<fieldset class="form-group">
									<label class="form-label">Jumlah Deposit</label>
									<input type='number' name='jumlah' required class='form-control'/>
								</fieldset>
								<input type='hidden' name='act' value='send'/>
								<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
								<button class='btn btn-success'>Kirim</button>
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