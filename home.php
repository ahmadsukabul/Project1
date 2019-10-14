<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
$bulan_lalu = date('Y-m-d', strtotime("-6 week"));
$bulan_ini = date("Y-m-d");


function rupiah($angka){
	
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,0,',','.');
	return $hasil_rupiah;

}
$total = $db->num_rows("select id from transaksi");
if(isset($_POST['mulai'],$_POST['sampai'])){
	$start_date = "$_POST[mulai] 00:00:00";
	$end_date = "$_POST[sampai] 23:59:00";
	$_SESSION['rk_start_date'] = "$start_date";
	$_SESSION['rk_end_date'] = "$end_date";
}
if(!isset($_SESSION['rk_start_date'])){
	$default_start = "$today 00:00:00";
	$default_end = "$today 23:59:00";
	$_SESSION['rk_start_date'] = "$default_start";
	$_SESSION['rk_end_date'] = "$default_end";
}

$d_start = $_SESSION['rk_start_date'];
$d_end = $_SESSION['rk_end_date'];

$pengguna_baru_1 = $db->num_rows("select id from users where tanggal_daftar>='$d_start' and tanggal_daftar<='$d_end'");

$transaksi_berhasil = $db->num_rows("select id FROM  `transaksi` WHERE created_at>='$d_start' and created_at<='$d_end' AND `status` = 1");

$q_pengeluaran = $db->fetch("select sum(price_master) from transaksi where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$pengeluaran = $q_pengeluaran[0];

$q_user_topup = $db->fetch("select sum(nominal_topup) from topup where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$user_topup = $q_user_topup[0];

$q_master_topup = $db->fetch("select sum(jumlah_deposit) from deposit_master where status=1 and created_at>='$d_start' and created_at<='$d_end'");
$master_topup = $q_master_topup[0];
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Rangkuman Ringkas - <?PHP echo $c_name; ?></title>
	<link rel="stylesheet" href="css/lib/flatpickr/flatpickr.min.css">
	<link rel="stylesheet" href="css/separate/vendor/flatpickr.min.css">
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
            <div class="col-xl">
						<div class="card-block">
							<div id='top-action' style='margin-bottom:20px'>
							<form action='' method='post'>
								<div class='row'>
									
									<div class='col-md-5'>
										<fieldset>
											<label>Mulai Dari</label>
											<input id='mulai' class="flatpickr form-control" name="mulai" type="text" placeholder="Pilih tanggal.."/>
                                        
							From : <b><?PHP echo $d_start; ?></b>
                                        </fieldset>
									</div>
									<div class='col-md-5'>
										<fieldset>
											<label>Sampai Dengan</label>
											<input id='sampai' class="flatpickr form-control" name='sampai' type="text" placeholder="Pilih tanggal.."/>
                                        
							To : <b><?PHP echo $d_end; ?></b><br>
                                        </fieldset>
									</div>
									<div class='col-md-2'>
										.<br>
										<button class='btn btn-primary btn-md btn-block'><i class='fa fa-search'></i></button>
									</div>
									
								</div>
							</form>
							</div>
							<div class="row">

			
			
						</div>
                <div class="row">
                        <?php
                        $transaksi_berhasil_bulan_ini = $db->num_rows("select id FROM  `transaksi` WHERE  `created_at` LIKE  '%$bulan_ini%'AND  `status` = 1");
                        $transaksi_berhasil_bulan_lalu = $db->num_rows("select id FROM  `transaksi` WHERE  `created_at` LIKE  '%$bulan_lalu%'AND  `status` = 1");
                        if ($transaksi_berhasil_bulan_ini > $transaksi_berhasil_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $transaksi_berhasil_persen = ($transaksi_berhasil_bulan_ini - $transaksi_berhasil_bulan_lalu) / $transaksi_berhasil_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $transaksi_berhasil_persen = ($transaksi_berhasil_bulan_lalu - $transaksi_berhasil_bulan_ini) / $transaksi_berhasil * 100;
                        }
                        $transaksi_berhasil_persen = round($transaksi_berhasil_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box red">
                                <div>
                                    <a style="color:white" href="transaksi_berhasil.php">
                                        <div class="number">
                                            <?PHP echo rupiah($transaksi_berhasil); ?>
                                        </div>
                                        <div class="caption">
                                            <div>Transaksi Berhasil</div>
                                        </div>
                                        <div class="percent">
                                            <div class="arrow <?PHP echo $daftar_indikasi; ?>"></div>
                                            <p>
                                                <?PHP echo $transaksi_berhasil_persen; ?>%</p>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <?php
                        $pengguna_baru = $db->num_rows("select id from users where tanggal_daftar like '%$bulan_ini%'");
                        $pengguna_bulan_lalu = $db->num_rows("select id from users where tanggal_daftar like '%$bulan_lalu%'");
                        if ($pengguna_baru > $pengguna_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $pengguna_baru_persen = ($pengguna_baru - $pengguna_bulan_lalu) / $pengguna_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $pengguna_baru_persen = ($pengguna_bulan_lalu - $pengguna_baru) / $pengguna_baru * 100;
                        }
                        $pengguna_baru_persen = round($pengguna_baru_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box purple">
                                <div>
                                    <a style="color:white" href="user_today.php">
                                        <div class="number">
                                            <?php echo rupiah($pengguna_baru_1); ?></div>
                                        <div class="caption">
                                            <div>Pengguna Baru</div>
                                        </div>
                                        <div class="percent">
                                            <div class="arrow <?PHP echo $daftar_indikasi; ?>"></div>
                                            <p>
                                                <?PHP echo $pengguna_baru_persen; ?>%</p>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <?php
                        $q_profit = $db->fetch("select sum(profit) from transaksi where status=1 and created_at>='$d_start' and created_at<='$d_end'");
                        $profit = $q_profit[0];
                        $p_profit = $db->fetch("select sum(profit) FROM  transaksi WHERE created_at LIKE '%$bulan_ini%' AND status = 1");
                        $profit_bulan_ini = $p_profit[0];
                        $q_profit = $db->fetch("select sum(`profit` )FROM  `transaksi` WHERE  `created_at` LIKE  '%$bulan_lalu%' AND  `status` =1");
                        $profit_bulan_lalu = $q_profit[0];
                        if ($profit_bulan_ini > $profit_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $profit_persen = ($profit_bulan_ini - $profit_bulan_lalu) / $profit_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $profit_persen = ($profit_bulan_lalu - $profit_bulan_ini) / $profit_bulan_ini * 100;
                        }
                        $profit_persen = round($profit_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box yellow">
                                <div>
                                    <div class="number">
                                        <?PHP echo rupiah($profit); ?>
                                    </div>
                                    <div class="caption">
                                        <div>Profit</div>
                                    </div>
                                    <div class="percent">
                                        <div class="arrow <?PHP echo $daftar_indikasi; ?>"></div>
                                        <p>5%</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                    </div>
                    <!--.row-->
                    <div class="row">
                        <?php
                        $transaksi_gagal = $db->num_rows("select id FROM  `transaksi` WHERE  `created_at` LIKE  '%$bulan_ini%'AND  `status` > 1");
                        $transaksi_gagal_bulan_lalu = $db->num_rows("select id FROM  `transaksi` WHERE  `created_at` LIKE  '%$bulan_lalu%'AND  `status` > 1");
                        if ($transaksi_gagal > $transaksi_gagal_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $transaksi_gagal_persen = ($transaksi_gagal - $transaksi_gagal_bulan_lalu) / $transaksi_gagal_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $transaksi_gagal_persen = ($transaksi_gagal_bulan_lalu - $transaksi_gagal) / $transaksi_gagal * 100;
                        }
                        $transaksi_gagal_persen = round($transaksi_gagal_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box green">
                                <div>
                                    <a style="color:white" href="transaksi_gagal.php">
                                        <div class="number">
                                            <?PHP echo rupiah($transaksi_gagal); ?>
                                        </div>
                                        <div class="caption">
                                            <div>Transaksi Gagal</div>
                                        </div>
                                        <div class="percent">
                                            <div class="arrow <?PHP echo $daftar_indikasi; ?>"></div>
                                            <p>
                                                <?PHP echo $transaksi_gagal_persen; ?>%</p>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <?php
                        $pengguna_verif = $db->num_rows("select id from verify_id where status = 1");
                        $pengguna_verif_bulan_lalu = $db->num_rows("select id from verify_id where created_at like '%$bulan_lalu%' and status = 1");
                        if ($pengguna_verif > $pengguna_verif_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $pengguna_verif_persen = ($pengguna_verif - $pengguna_verif_bulan_lalu) / $pengguna_verif_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $pengguna_verif_persen = ($pengguna_verif_bulan_lalu - $pengguna_verif) / $pengguna_verif * 100;
                        }
                        $pengguna_verif_persen = round($pengguna_verif_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box red">
                                <div>
                                    <div class="number">
                                        <?PHP echo rupiah($pengguna_verif); ?>
                                    </div>
                                    <div class="caption">
                                        <div>Pengguna Terverifikasi</div>
                                    </div>
                                    <div class="percent">
                                        <!--<div class="arrow down"></div>
                                        <p>5%</p>-->
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <?php
                        $p_spending = $db->fetch("select sum(price_master) FROM  transaksi WHERE created_at LIKE '%$bulan_ini%' AND status = 1");
                        $spending = $p_spending[0];
                        $q_spending = $db->fetch("select sum(`price_master` )FROM  `transaksi` WHERE  `created_at` LIKE  '%$bulan_lalu%' AND  `status` =1");
                        $spending_bulan_lalu = $q_spending[0];
                        if ($spending > $spending_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $spending_persen = ($spending - $spending_bulan_lalu) / $spending_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $spending_persen = ($spending_bulan_lalu - $spending) / $spending * 100;
                        }
                        $spending_persen = round($spending_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box purple">
                                <div>
                                    <a style="color:white" href="user_today.php">
                                        <div class="number">
                                            <?PHP echo rupiah($pengeluaran); ?>
                                        </div>
                                        <div class="caption">
                                            <div>Spending</div>
                                        </div>
                                        <div class="percent">
                                            <div class="arrow up"></div>
                                            <p>84%</p>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                    </div>
                    <!--.row-->
                    <div class="row">
                        <?php
                        $transaksi_pending = $db->num_rows("select id FROM  `transaksi` WHERE `status` = 0");
                        $transaksi_pending_bulan_lalu = $db->num_rows("select id FROM  `transaksi` WHERE  `created_at` LIKE  '%$bulan_lalu%'AND  `status` = 0");
                        if ($transaksi_pending > $transaksi_pending_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $transaksi_pending_persen = ($transaksi_pending - $transaksi_pending_bulan_lalu) / $transaksi_pending_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $transaksi_pending_persen = ($transaksi_pending_bulan_lalu - $transaksi_pending) / $transaksi_pending * 100;
                        }
                        $transaksi_pending_persen = round($transaksi_pending_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box yellow">
                                <div>
                                    <a style="color:white" href="transaksi_pending.php">
                                        <div class="number">
                                            <?PHP echo rupiah($transaksi_pending); ?>
                                        </div>
                                        <div class="caption">
                                            <div>Transaksi Pending</div>
                                        </div>
                                        <div class="percent">
                                            <div class="arrow <?PHP echo $daftar_indikasi; ?>"></div>
                                            <p>84%</p>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <?php
                        $pengguna_aktif = $db->num_rows("select DISTINCT uid FROM transaksi WHERE created_at LIKE '%$bulan_ini%' and status = 1");
                        $pengguna_aktif_bulan_lalu = $db->num_rows("select DISTINCT uid FROM transaksi WHERE created_at LIKE '%$bulan_lalu%' and status = 1");
                        if ($pengguna_aktif > $pengguna_aktif_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $pengguna_aktif_persen = ($pengguna_aktif - $pengguna_aktif_bulan_lalu) / $pengguna_aktif_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $pengguna_aktif_persen = ($pengguna_aktif_bulan_lalu - $pengguna_aktif) / $pengguna_aktif * 100;
                        }
                        $pengguna_aktif_persen = round($pengguna_aktif_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box green">
                                <div>
                                    <div class="number">
                                        <?PHP echo rupiah($pengguna_aktif); ?>
                                    </div>
                                    <div class="caption">
                                        <div>Pengguna Aktif</div>
                                    </div>
                                    <div class="percent">
                                        <div class="arrow <?PHP echo $daftar_indikasi; ?>"></div>
                                        <p>
                                            <?PHP echo $pengguna_aktif_persen; ?>%</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <?php
                        $p_balance = $db->fetch("select sum(sisa_saldo) FROM  h2h");
                        $balance = $p_balance[0];
                        $q_balance = $db->fetch("select sum(`sisa_saldo` )FROM  h2h");
                        $balance_bulan_lalu = $q_balance[0];
                        if ($balance > $balance_bulan_lalu) {
                            $daftar_indikasi = "up";
                            $balance_persen = ($balance - $balance_bulan_lalu) / $balance_bulan_lalu * 100;
                        } else {
                            $daftar_indikasi = "down";
                            $balance_persen = ($balance_bulan_lalu - $balance) / $balance * 100;
                        }
                        $balance_persen = round($balance_persen, 0);
                        ?>
                        <div class="col-sm">
                            <article class="statistic-box red">
                                <div>
                                    <div class="number">
                                        <?PHP echo rupiah($balance); ?>
                                    </div>
                                    <div class="caption">
                                        <div>Balance</div>
                                    </div>
                                    <div class="percent">
                                        <div class="arrow <?PHP echo $daftar_indikasi; ?>"></div>
                                        <p>84%</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                    </div>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP require_once("_/js.php"); ?>
	<script type="text/javascript" src="js/lib/flatpickr/flatpickr.min.js"></script>
	<script>
	$(document).ready(function(){
		/* ==========================================================================
			 Datepicker
			 ========================================================================== */

			$('.flatpickr').flatpickr();
			$("#flatpickr-disable-range").flatpickr({
				disable: [
					{
						from: "2016-08-16",
						to: "2016-08-19"
					},
					"2016-08-24",
					new Date().fp_incr(30) // 30 days from now
				]
			});
		   
		});
	</script>
</body>
</html>