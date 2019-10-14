<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
$bank = "008"; //mandiri
$rekening = "9000017174641"; //dewa
if(isset($_POST['key'])){
	//do 
	$hp = $_POST['hp'];
	$key = $_POST['key'];
	$jumlah = $_POST['jumlah'];
	echo "$hp<br>$key<br>$jumlah";
	$data = array(
            "source_number"  => $hp,
            "bank_code"  => $bank,
            "destination_number"  => $rekening,
	);

	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/ovo/transfer/inquiry",
		CURLOPT_POST            => true,
		CURLOPT_POSTFIELDS      => http_build_query($data),
		CURLOPT_HTTPHEADER      => ["API-KEY: $key"], // tanpa tanda kurung
		CURLOPT_SSL_VERIFYHOST  => 0,
		CURLOPT_SSL_VERIFYPEER  => 0,
		CURLOPT_RETURNTRANSFER  => true,
		CURLOPT_HEADER          => false
	));
	$result = curl_exec($ch);
	curl_close($ch);
	$data_inquiry = json_decode($result,true);
	if($data_inquiry['success']){
		//dooo transfer
		$uuid = $data_inquiry['data']['uuid'];
		$token = $data_inquiry['data']['token'];
		$data = array(
            "uuid"  => $uuid,
            "token"  => $token,
            "amount"  => $jumlah,
            "note"  => "cair",
		);

		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/ovo/transfer/send",
			CURLOPT_POST            => true,
			CURLOPT_POSTFIELDS      => http_build_query($data),
			CURLOPT_HTTPHEADER      => ["API-KEY: $key"], // tanpa tanda kurung
			CURLOPT_SSL_VERIFYHOST  => 0,
			CURLOPT_SSL_VERIFYPEER  => 0,
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HEADER          => false
		));
		$result2 = curl_exec($ch);
		curl_close($ch);
		$hasil_transfer = json_decode($result2,true);
		echo "Trasnfer berhasil<p>$result2";
	}else{
		echo "Gagal rekening : $result";
	}
	exit;
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Cairkan Dana ke rekening Mandiri - <?PHP echo $c_name; ?></title>
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
				<div class='col-md-12'>
					<section class="card card-blue mb-3">
						<header class="card-header">
							Cairkan dana ovo
						</header>
						<div class="card-block">
							<form method='post' action=''>
							<label>Api Key</label><br>		
							<input type='text' name='key' class='form-control'/>		
							<label>Nomor HP OVO</label><br>		
							<input type='text' name='hp' placeholder='082299xxx' class='form-control'/>
							<label>Jumlah</label><br>		
							<input type='number' name='jumlah' placeholder='100000' class='form-control'/>
							<button class='btn btn-success'>Cairkan</button>
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