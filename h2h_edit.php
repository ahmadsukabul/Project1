<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php"); //hanya level 1=admin
if(!isset($_GET['id'])){
	echo "need id!";
	exit;
}
$id = abs((int)$_GET['id']);
$data = $db->fetch("select * from h2h where id_h2h='$id'");
if(!isset($data['id_h2h'])){
	echo "H2H Tidak Di Temukan";
	exit;
}
$csrf = $app->csrf();
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Edit H2H <?PHP echo $id; ?> - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class='col-md-12 col-xs-12 col-lg-12'>
					<section class="card card-green mb-3">
						<header class="card-header">
							Edit H2H <?PHP echo $id; ?>
						</header>
						<div class="card-block">
							
							<form action='h2h.php' method='post'>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Nama H2H</label>
										<input value='<?PHP echo $data['nama_h2h']; ?>' name='nama' type="text" class="form-control" placeholder="barokah h2h" required>
									</fieldset>
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">Jabber H2H</label>
										<input value='<?PHP echo $data['jabber_h2h']; ?>' name='jabber' type="text" class="form-control" placeholder="h2h@jabb.im" required>
									</fieldset>
									
								</div>
								<div class="col-lg-4 col-md-4">
									<fieldset class="form-group">
										<label class="form-label">SEND USE</label>
										<input value='<?PHP echo $data['send_use']; ?>' name='send_use' type="text" class="form-control" placeholder="bukakios@jabbim or bukakios2@jabbim.cz or bukakios@jabberix.com" required>
									</fieldset>
									
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Pin H2H</label>
										<input value='<?PHP echo $data['pin_h2h']; ?>' name='pin' type="text" class="form-control" placeholder="1234" required>
									</fieldset>
								</div>
								<div class="col-lg-6 col-md-6">
									<fieldset class="form-group">
										<label class="form-label">Batas Alert Saldo Lemah</label>
										<input value='<?PHP echo $data['batas_saldo_lemah']; ?>' name='batas' type="number" class="form-control" placeholder="1000000" required>
									</fieldset>
								</div>
							</div>
							<fieldset class="form-group">
								<label class="form-label">Deskripsi Lainya</label>
								<textarea rows='8' class='form-control' name='deskripsi'><?PHP echo $data['deskripsi_h2h']; ?></textarea>
							</fieldset>
							<input type='hidden' name='id' value='<?PHP echo $id; ?>'/>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='edit'/>
							<button class='btn btn-success'>Simpan</button>
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