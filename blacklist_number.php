<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
if(isset($_REQUEST['act'])){
	require_once("_act/_blacklist_number.php");
}else{
	$csrf = $app->csrf();
}
$total = $db->num_rows("select id from blacklist_number");
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Daftar Nomor DI Blokir - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div class='col-md-12 col-xs-12 col-lg-12'>
					<?PHP require_once("_/_alert_message.php"); ?>
					<section class="card card-red mb-3">
						<header class="card-header">
							Masukan Nomor Ke BlackList
						</header>
						<div class="card-block">
							<form action='' method='post'>
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<fieldset class="form-group">
										<label class="form-label">Nomor HP/Rekening</label>
										<input name='nomor' type="text" class="form-control" placeholder="0859xxxx" required>
									</fieldset>
								</div>
							</div>
							<input type='hidden' name='csrf' value='<?PHP echo $csrf; ?>'/>
							<input type='hidden' name='act' value='add'/>
							<button class='btn btn-success'>Tambahkan</button>
							</form>
							<hr>
							
						</div>
					</section>
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Semua Daftar BlackList
						</header>
						<div class="card-block">
                            Total BlackList : <?PHP echo $total; ?><p>
							<div id='top-action' style='margin-bottom:20px'>
								<span class="input-group"  style='width:30%'>
									<input class="form-control" required type="text" name="keyword" id="search_cat" placeholder='Enter keyword...' onkeyup='changePagination(1, "search", this.value)'>
									<span class="input-group-btn">
									<button class="btn btn-default"><i class='fa fa-search'></i></button>
									</span>
								</span>
							</div>
							<div id="pageData"></div>
							<span class="flash"></span>
						</div>
					</section>
				</div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	<script>
	$(document).ready(function(){
		changePagination('1', 'all', '');    
		});
		function changePagination(page, action, q){
			$(".flash").show();
			$(".flash").fadeIn(400).html
			('Loading...');
			var dataString = 'page='+ page;
			dataString = dataString + '&action='+action+'&q='+q;
			$.ajax({
				type: "POST",
				url: "ajax/load_blacklist_number.php",
				data: dataString,
				cache: false,
				success: function(result){
					$(".flash").hide();
					$("#pageData").html(result);
				}
			});
		}
	</script>
</body>
</html>