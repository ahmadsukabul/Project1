<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_admin.php");
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
	<title>Tambah Tim Internal Baru - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content" >
	    <div class="container-fluid">
	        <div class="row">
				<div class='col-md-12'>
                    <?PHP require_once("_/_alert_message.php"); ?>
					<section class="card card-blue mb-3">
						<header class="card-header">
                         Tambah Tim Internal Baru 
						</header>
						<div class="card-block">
                        <form action='' method='post'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <fieldset class='form-group'>
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type='text' name='nama' class='form-control' required/>
                                    </fieldset>
                                </div>
                                <div class='col-md-6'>
                                    <fieldset class='form-group'>
                                        <label class="form-label">Email</label>
                                        <input type='text' name='email' class='form-control' required/>
                                    </fieldset>
                                </div>
                                
                                
                            </div>

                            <div class='row'>
                                <div class='col-md-6'>
                                    <fieldset class='form-group'>
                                        <label class="form-label">Password</label>
                                        <input type='password' name='password' class='form-control' required/>
                                    </fieldset>
                                </div>

                                <div class='col-md-6'>
                                    <fieldset class="form-group">
                                        <label class="form-label" for="akses_level">Pilih Akses Level (JENIS) </label>
                                        <select id='akses_level' name='akses_level' class='form-control'>
                                            <option value=1>Administrator</option>
                                            <option value=2>Customer Service</option>
                                            <option value=3>Manajemen</option>
                                            <option value=4>Keuangan</option>
                                            <option value=5>Enginer</option>
                                            <option value=6>Marketing</option>
                                        </select>
                                     </fieldset>	
                                </div>
                            </div>
                            <button class='btn btn-success'>Simpan<button>
                            <input type='hidden' name='act' value='add'/>
                            <input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
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