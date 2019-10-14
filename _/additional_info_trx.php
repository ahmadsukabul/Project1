<?PHP
$show_additional = false;
if($status==1){
	if($pembelianoperator_id==18){
		//token listrik
		$show_additional = true;
		$ax_text_info_salin = "Token berhasil di salin";
		$ax_text_salin = "Salin Token";
		$ax_info = "TOKEN";
		$ax_sn = $sn_pecah[0];
		$ax_alert = "success";
		$ax_additional = "";
	}else if($pembelianoperator_id==2 and $pembelianoperator_id==97){
		//axis aigo kode aktifasi
		$show_additional = true;
		$ax_text_info_salin = "Kode Voucher berhasil di salin";
		$ax_text_salin = "Salin Kode Voucher";
		$ax_info = "Kode Voucher";
		$ax_sn = $sn;
		$ax_alert = "success";
		$ax_additional = "<div style='margin-top:10px'>* Cara aktivasi voucher axis aigo kamu => <b>*838*$sn#</b></div>";
	}else if($pembelianoperator_id==106){
		$show_additional = true;
		$ax_text_info_salin = "Kode Voucher berhasil di salin";
		$ax_text_salin = "Salin Kode Voucher";
		$ax_info = "Kode Voucher";
		$ax_sn = $sn;
		$ax_alert = "success";
		$ax_additional = "<div style='margin-top:10px'>* Silahkan masukan kode voucher di atas saat bertransaksi di google playstore :)</div>";
	}
}else{
	$show_additional = true;
	$ax_text_info_salin = "Catatan berhasil di salin";
	$ax_text_salin = "Salin catatan";
	$ax_info = "Catatan";
	$ax_sn = $sn;
	$ax_alert = "danger";
	$ax_additional = "";
}
?>
<?PHP if($show_additional){ ?>
<div class="alert alert-<?PHP echo $ax_alert; ?>" style="padding:20px;">
	<center><h3><?PHP echo $ax_info; ?> :</h3>
	<h3 
	style=";margin-bottom:-20px;margin-top:10px;font-size:20px" 
	id="sn_catatan" 
	data-text="<?PHP echo $ax_text_info_salin; ?>" 
	data-copy="<?PHP echo $ax_sn; ?>">
	<?PHP echo $ax_sn; ?>
	</h3>
	<br>
	<span style="text-decoration:underline;color:#00bfff;cursor:pointer" 
		onclick="copyToClipboard('sn_catatan')">
		<?PHP echo $ax_text_salin; ?>
	</span></center>
	<?PHP echo $ax_additional; ?>
</div> <?PHP } ?>

<?PHP
if($status>1){
	//refund
	$jumlah_refund = $app->idr($price_client);;
	echo "<div class='alert alert-info'>
	<b>Harap Baca!!!</b><br>
	Di karenakan transaksi ini gagal, dana sebesar <b>$jumlah_refund</b> sudah kami kembalikan ke saldo akun kamu :) , jika ada yang ingin di tanyakan silahkan <a href='kontak.html'>kontak kami</a>
	</div>";
}
?>