<?php
$auto_connect = 1; //auto connect database;

require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");


class Grafik1 {

    public function fetch_minus_perbulan()
    {
        
        echo $start = $_POST['start'];
        $end = $_POST['end'];
        $sql = "SELECT total_minus FROM buka_kios.tbl_total_minus_not_match where tanggal_matching between '$start'  and '$end'";
        // return $data = $db->fetch_json($sql);
    }

} 

?>