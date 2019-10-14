<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
if(isset($_REQUEST['act'])){
    $act = $_REQUEST['act'];
    if($act=='show_all'){
        $_SESSION['show_approvel_topup'] = 'all';
    }else{
        $_SESSION['show_approvel_topup'] = 'pending';
    }
}
$show_approvel_topup = 'pending'; //hanya tampilin yang pending saja
if(isset($_SESSION['show_approvel_topup'])){
    $show_approvel_topup = $_SESSION['show_approvel_topup'];
}
if($show_approvel_topup=='pending'){
    $total = $db->num_rows("select id_ar from approvel_request where status_ar='0'");
}else{
    $total = $db->num_rows("select id_ar from approvel_request");
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Daftar Approvel Topup - <?PHP echo $c_name; ?></title>
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
					
					<section class="card card-blue mb-3">
						<header class="card-header">
							Semua Daftar Request Approve Topup
						</header>
						<div class="card-block">
                            Total Data : <?PHP echo $total; ?><p>
							<div id='top-action' style='margin-bottom:20px'>
								<span class="input-group"  style='width:30%'>
									<input class="form-control" required type="text" name="keyword" id="search_cat" placeholder='Enter keyword...' onkeyup='changePagination(1, "search", this.value)'>
									<span class="input-group-btn">
									<button class="btn btn-default"><i class='fa fa-search'></i></button>
									</span>
								</span>
							</div>
                            <div id='filter' style='margin-bottom:10px'>
                                <?PHP if($show_approvel_topup=='pending'){ ?>
                                <a href='approvel_topup.php?act=show_all' class='btn btn-success'>Tampilkan Semua Riwayat Approvel</a>
                                <?PHP }else{ ?>
                                <a href='approvel_topup.php?act=show_pending' class='btn btn-warning'>Tampilkan Hanya Yang Belum Di Approve</a>
                                <?PHP } ?>
                            </div>
							<span class="flash"></span>
							<div id="pageData"></div>
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
				url: "ajax/load_approvel_topup.php",
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