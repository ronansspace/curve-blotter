<?php
session_start();
require_once('inc/def.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$qry_type = $_GET['theid'];

$xtra_qry = "";

$startDate = "";
$endDate = "";

$dt_today = date('Ymd');

//Last 10 days
$dt_today_ten = date('Ymd', strtotime("-10 days"));

$dt_first = str_replace("/", "-", $_GET['stdate']);
$dt_first = date('Ymd', strtotime($dt_first));

$dt_sec = str_replace("/", "-", $_GET['endate']);
$dt_sec = date('Ymd', strtotime($dt_sec));

if($qry_type == 1){

}else if($qry_type == 2){
    $startDate = $dt_today;
    $endDate = $dt_today;
}else if($qry_type == 3){
    $startDate = $dt_today_ten;
    $endDate = $dt_today;
}else if($qry_type == 4){
    $startDate = $dt_first;
    $endDate = $dt_sec;
}

$sql = "call get_pl('$startDate','$endDate')";

$result = $conn->query($sql);

$size = $result->num_rows;

if($size <= 0){
    print json_encode("empty");
    exit;
}

while($fetch = $result->fetch_array()) {

    $output[] = array (
        $fetch["CcyPair"],$fetch["BoughtQty"],$fetch["SoldQty"],$fetch["SettledQty"],$fetch["BoughtAVG"],$fetch["SoldAVG"],$fetch["Banked"],$fetch["OutstandingQty"]
    );
}

echo json_encode($output);
exit;
?>
