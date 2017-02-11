<?php
session_start();
require_once('../inc/def.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$qry_type = $_GET['theid'];

$xtra_qry = "";

$dt_today = date('Ymd');

//Last 10 days
$dt_today_ten = date('Ymd', strtotime("-10 days"));

$dt_first = str_replace("/", "-", $_GET['stdate']);
$dt_first = date('Ymd', strtotime($dt_first));

$dt_sec = str_replace("/", "-", $_GET['endate']);
$dt_sec = date('Ymd', strtotime($dt_sec));

if($qry_type == 1){

}else if($qry_type == 2){
    $xtra_qry =  "and TradeDate = '$dt_today'";
}else if($qry_type == 3){
    $xtra_qry =  " and (TradeDate >= '$dt_today_ten' and TradeDate <= '$dt_today') ";
}else if($qry_type == 4){
    $xtra_qry =  " and (TradeDate >= '$dt_first' and TradeDate <= '$dt_sec') ";
}

$sql = "select OrderID, Account, PartyID, Side, Symbol, Currency, AvgPx, TradeDate, SettlDate, OrdType, OrderQty, OrdStatus, LeavesQty, SourceSystem from FIXExecutionReport where TransactTime = (select max(TransactTime) from FIXExecutionReport i where i.OrderID = FIXExecutionReport.OrderId) $xtra_qry";

$result = $conn->query($sql);

$size = $result->num_rows;

if($size <= 0){
    print json_encode("empty");
    exit;
}

while($fetch = $result->fetch_array()) {

    $output[] = array (
        $fetch["OrderID"],$fetch["Account"],$fetch["PartyID"],$fetch["Side"],$fetch["Symbol"],$fetch["Currency"],
        $fetch["AvgPx"],$fetch["TradeDate"],$fetch["SettlDate"],$fetch["OrdType"],$fetch["OrderQty"],$fetch["OrdStatus"],
        $fetch["LeavesQty"],$fetch["SourceSystem"]
        );
}

echo json_encode($output);
exit;
?>
