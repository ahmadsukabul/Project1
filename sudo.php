<?PHP
require_once("config.php");
$_SESSION['sudo'] = true;
header("location:index.php");
?>