<?php
session_start();
require_once('../inc/def.php');
?>

<!doctype html>
<html>
<head><meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Curve Markets FX Blotter</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="include/pace.css">
    <link rel="stylesheet" href=include/bootstrap.css">

    <link rel="stylesheet" href="include/jquery-ui.css">
    <link rel="stylesheet" href="include_online/datatables.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="include/main.css">

</head>
<body>

    <div class="container-fluid">

        <div style="width:90%;margin:0 auto;padding-top:15px;">

            <header>
                <img src="images/logo.jpg">
                <h1>FIX Blotter</h1>
                <br style="clear:both">
            </header>

            <div style="width:60%;float:left;display:inline;">
                <h4 class="table_heading">Execution Reports</h4>
                <table id="jsontable" class="display table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th> </th>
                        <th>Account</th>
                        <th>AvgPx</th>
                        <th>ClOrdID</th>
                        <th>CumQty</th>
                        <th>Currency</th>
                        <th>ExecID</th>
                        <th>LastPx</th>
                        <th>LastQty</th>
                        <th>OrderID</th>
                        <th>OrderQty</th>
                        <th>OrdStatus</th>
                        <th>OrdType</th>
                        <th>Price</th>
                        <th>Side</th>
                        <th>TimeInForce</th>
                        <th>TransactTime</th>
                        <th>SettlDate</th>
                        <th>ListID</th>
                        <th>TradeDate</th>
                        <th>ExecType</th>
                        <th>LeavesQty</th>
                        <th>EffectiveTime</th>
                        <th>NoContraBrokers</th>
                        <th>SecondaryExecID</th>
                        <th>SourceSystem</th>
                        </tr>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <script src="include/jquery10.js"></script>
    <script src="include/pace.min.js"></script>
    <script src="include/bootstrap.min.js"></script>

    <script type="text/javascript" src="include_online/datatable.js"></script>
    <script type="text/javascript" src="include_online/bootstrap.js"></script>

    <script src="include/jquery-ui-11.js"></script>
    <script src="include/paging.js"></script>

</body>
</html>