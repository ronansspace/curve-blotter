<?php
session_start();
require_once('inc/def.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$qry_type = $_GET['theid'];

$xtra_qry = "";

$dt_today = date('Y-m-d');

//Last 10 days
$dt_today_ten = date('Y-m-d', strtotime("-10 days"));

$dt_first = str_replace("/", "-", strtotime($_GET['stdate']));
$dt_first = date('Y-m-d', strtotime($_GET['stdate']));

$dt_sec = str_replace("/", "-", $_GET['endate']);
$dt_sec = date('Y-m-d', strtotime($dt_sec));

if($qry_type == 1){

}else if($qry_type == 2){
    $xtra_qry =  "and str_to_date( TradeDate, '%d/%m/%Y') = '$dt_today'";
}else if($qry_type == 3){

}else if($qry_type == 4){
    $xtra_qry =  " and (str_to_date( TradeDate, '%d/%m/%Y') between '$dt_today_ten' and '$dt_today') ";
}else if($qry_type == 5){
    $xtra_qry =  " and (str_to_date( TradeDate, '%d/%m/%Y') between '$dt_first' and '$dt_sec') ";
}

$sql = "SELECT * FROM FIXExecutionReport WHERE 1=1 $xtra_qry ORDER by TransactTime DESC";

$result = $conn->query($sql);

$size = $result->num_rows;

if($size <= 0){
    print json_encode("empty");
    exit;
}

while($fetch = $result->fetch_array()) {

    $output[] = array (
        $fetch["Account"],$fetch["Symbol"],$fetch["AvgPx"],$fetch["ClOrdID"],$fetch["CumQty"],$fetch["Currency"],
        $fetch["ExecID"],$fetch["LastPx"],$fetch["LastQty"],$fetch["OrderID"],$fetch["OrderQty"],
        $fetch["OrdStatus"],$fetch["OrdType"],$fetch["Price"],$fetch["Side"],$fetch["TimeInForce"],
        $fetch["TransactTime"],$fetch["SettlDate"],$fetch["ListID"],$fetch["TradeDate"],$fetch["ExecType"],
        $fetch["LeavesQty"],$fetch["EffectiveTime"],$fetch["NoContraBrokers"],$fetch["SecondaryExecID"],$fetch["SourceSystem"]
    );
}

echo json_encode($output);
exit;
?>
