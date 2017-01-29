<?php
session_start();
require_once('inc/def.php');
if(tdrLoggedIn()){  }

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql = "SELECT * FROM FIXExecutionReport";

$result = $conn->query($sql);

$size = $result->num_rows;

if($size <= 0){
    print json_encode("empty");
    exit;
}

while($fetch = $result->fetch_array()) {

    $output[] = array (
        $fetch["Account"],$fetch["AvgPx"],$fetch["ClOrdID"],$fetch["CumQty"],$fetch["Currency"],
        $fetch["ExecID"],$fetch["LastPx"],$fetch["LastQty"],$fetch["OrderID"],$fetch["OrderQty"],
        $fetch["OrdStatus"],$fetch["OrdType"],$fetch["Price"],$fetch["Side"],$fetch["TimeInForce"],
        $fetch["TransactTime"],$fetch["SettlDate"],$fetch["ListID"],$fetch["TradeDate"],$fetch["ExecType"],
        $fetch["LeavesQty"],$fetch["EffectiveTime"],$fetch["NoContraBrokers"],$fetch["SecondaryExecID"],$fetch["SourceSystem"]
    );
}

echo json_encode($output);
exit;
?>
