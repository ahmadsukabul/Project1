<?PHP
define('_DB_HOST', 'localhost');
define('_DB_USER', 'root');
define('_DB_PASS', '');
define('_DB_NAME', 'bukakios');
define('_DB_NAME_2', 'bukakios_h2h');
require_once(ROOT."/core/db.class.php"); 
$db=new Database(_DB_HOST, _DB_USER, _DB_PASS, _DB_NAME);
$db2=new Database(_DB_HOST, _DB_USER, _DB_PASS, _DB_NAME_2);
?>