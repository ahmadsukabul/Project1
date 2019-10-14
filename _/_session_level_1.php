<?PHP
//wajib include _session.php , jika ingin menggunakan ini 
if($admin_level!=1 and $admin_level!=3){
	echo "Akses Level Di Tolak, halaman ini hanya bisa di akses oleh pengguna dengan aksesl level 1";
	exit;
}

?>