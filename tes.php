<?PHP
$password = "dewa";
$salt = sha1(md5($password));
$final_hash = md5($password.$salt);
echo "salt : $salt<br>";
echo "md5 : $final_hash<br>";
echo abs("78889");
?>