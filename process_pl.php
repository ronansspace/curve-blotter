<?php
session_start();
require_once('inc/def.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Side, SUM(LastQty) AS TotalQty, AVG(LastPx) As AvgPrice, Symbol FROM FIXExecutionReport GROUP BY Symbol, Side ORDER BY Symbol";

$result = $conn->query($sql);

$size = $result->num_rows;

if($size <= 0){
    print json_encode("empty");
    exit;
}

while($fetch = $result->fetch_array()) {

    $output[] = array (
        $fetch["Side"],$fetch["TotalQty"],$fetch["AvgPrice"],$fetch["Symbol"]
    );
}

echo json_encode($output);
exit;
?>
