<?php
session_start();
require_once('inc/def.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "call get_pl";

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
