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
    <link rel="icon" type="image/png" href="../images/favicon.png" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../include/pace.css">
    <link rel="stylesheet" href=../include/bootstrap.css">

    <link rel="stylesheet" href="../include/jquery-ui.css">
    <link rel="stylesheet" href="../include_online/datatables.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="../include/main.css">

</head>
<body>

    <div class="container-fluid">

        <div style="width:90%;margin:0 auto;padding-top:15px;">

            <header>
                <img src="../images/logo.jpg">
                <h1>Manual Blotter</h1>
                <br style="clear:both">
            </header>

            <div class="controls-div">

                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-sm btn-info">
                        <input type="radio" name="options" value="1" autocomplete="off"> All Trades
                    </label>
                    <label class="btn btn-sm btn-info active" >
                        <input type="radio" name="options" value="2" autocomplete="off" checked> Today's Trade
                    </label>
                    <label class="btn btn-sm btn-info">
                        <input type="radio" name="options" value="3" autocomplete="off"> Last 10 Days
                    </label>
                    <label class="btn btn-sm btn-info">
                        <input type="radio" name="options" value="4" autocomplete="off"> By Date
                    </label>
                </div>


                <div id="tradebdate" style="width:20%;display:none;">
                    <input type="text" class="input-xs" placeholder="Start Date" name="stDate" id="stDate">
                    <input type="text" class="input-xs" placeholder="End Date" name="enDate" id="enDate">
                    <input type="button" class="btn btn-xs btn-default" id="date_filter_submit" value="Submit">
                </div>


                <input type="hidden" name="trade_filter" value="1">

            </div>

            <div style="width:20%;float:left;display:inline;padding-left:10px;">
                <h4 class="table_heading">Expiries</h4>
                <table id="jsontable_expiries" class="display table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Trade ID</th>
                        <th>Expiry Date</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div style="width:80%;float:left;display:inline;padding-left:10px;">
                <h4 class="table_heading">Brokerage</h4>
                <table id="jsontable_pnl" class="display table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Trade ID</th>
                        <th>Gros Profit</th>
                        <th>PB Cost</th>
                        <th>Venue Cost</th>
                        <th>Total Cost</th>
                        <th>Net Profit</th>
                        <th>Contract</th>
                        <th>Trader</th>
                        <th>FX Pair ID</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div style="width:90%;float:left;display:inline;padding-left:10px;">
                <h4 class="table_heading">Trades</h4>
                <table id="jsontable" class="display table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th> </th>
                        <th>ID</th>
                        <th>TET</th>
                        <th>PB</th>
                        <th>Client</th>
                        <th>Contract</th>
                        <th>Client</th>
                        <th>B/S</th>
                        <th>Notional</th>
                        <th>CCY</th>
                        <th>Counter&nbsp;Amount</th>
                        <th>Rate</th>
                        <th>Trade&nbsp;Date</th>
                        <th>Value&nbsp;Date</th>
                        <th>Trader</th>
                        <th>SPCUT</th>
                        <th>Status</th>
                        <th>Prem&nbsp;Amount</th>
                        <th>Barrier&nbsp;Type</th>
                        <th>Lower&nbsp;Barrier</th>
                        <th>Upper&nbsp;Barrier</th>
                        <th>Knock&nbsp;in&nbsp;out</th>
                        <th>Touch&nbsp;up&nbsp;down</th>
                        <th>Rebate&nbsp;CCY</th>
                        <th>Expiry</th>
                        <th>Rebate&nbsp;Amount</th>
                        <th>Payout&nbsp;CCY</th>
                        <th>Delivery</th>
                        <th>FX&nbsp;Pair&nbsp;ID</th>
                        <th>platform</th>
                        <th>indicator</th>
                        <th>platform_trade_id</th>
                        <th>Cparty</th>
                        <th>P/C</th>
                        <th>OptCut</th>
                        <th>Type</th>
                        <th>Cash&nbsp;at</th>
                        <th>Barrier&nbsp;StartDate</th>
                        <th>Barrier&nbsp;EndDate</th>
                        <th>Strike</th>
                        <th>Expiry&nbsp;Date</th>
                        <th>Sett&nbsp;Date</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script src="../include/jquery10.js"></script>
    <script src="../include/pace.min.js"></script>
    <script src="../include/bootstrap.min.js"></script>

    <script type="text/javascript" src="../include_online/datatable.js"></script>
    <script type="text/javascript" src="../include_online/bootstrap.js"></script>

    <script src="../include/jquery-ui-11.js"></script>
    <script src="../include/paging.js"></script>


    <script>

        $('input[name="options"]').change( function() {

            var all_val = $(this).val();
            $("#tradebdate").hide();

            if(all_val == 1){
                $('input[name="trade_filter"]').val(1);
            } else if(all_val == 2){
                $('input[name="trade_filter"]').val(2);
            } else if(all_val == 3){
                $('input[name="trade_filter"]').val(3);
            } else if(all_val == 4){
                $("#tradebdate").css('display', 'inline');
                $("#tradebdate").show();
                $('input[name="trade_filter"]').val(4);
            }

            if(all_val != 4){

                getrecord_max();
                getpl_records();
                get_order_summary();

            }


        });

        $(document).on("click", "#date_filter_submit", function (){

            var stDate = $('input[name=stDate]').val();
            var enDate = $('input[name=enDate]').val();



            if(stDate == "" || enDate == ""){

                alert("Please choose date range.");
                return false;

            }else{

                getrecord_max();
                getpl_records();
                get_order_summary();

            }


        });

        $("body").disableSelection();

        var result_count  = 0 ;
        var tableid = 1;

        $("#stDate").datepicker({ dateFormat: 'dd/mm/yy' });
        $("#enDate").datepicker({ dateFormat: 'dd/mm/yy' });

        function updateRecord(){
            $(".badge").html("&nbsp;"+result_count+"&nbsp;");
        }

        $(document).ready(function() {
            getrecord_max();
            getpl_records();
            get_order_summary();
        });

        function getpl_records(){

            $('#jsontable_pl').dataTable().fnDestroy();

            var all_val = $('input[name=options]:checked').val();
            var stDate = $('input[name=stDate]').val();
            var enDate = $('input[name=enDate]').val();

            $.ajax({

                url: 'process_pl.php?method=fetchdata&theid='+all_val+'&stdate='+stDate+'&endate='+enDate + " ",
                dataType: 'json',
                success: function(s){

                    if(s == "empty"){

                    } else {
                        var data = [];

                        for(var i = 0; i < s.length; i++) {
                            data.push([s[i][0], s[i][1], s[i][2], s[i][3], s[i][4], s[i][5], s[i][6], s[i][7]]);
                        }

                        var oTable = $('#jsontable_pl').dataTable({
                            "data": data,
                            "iDisplayLength": 25,
                            "processing": true,
                            "scrollX": true,
                            "deferRender": true
                        });
                    }
                },
                error: function(e){
                    //console.log(e.responseText);
                    //alert(e.responseText);
                    //alert('Error loading records.')
                }
            });
        }

        function get_order_summary(){

            $('#jsontable_order').dataTable().fnDestroy();

            var all_val = $('input[name=options]:checked').val();
            var stDate = $('input[name=stDate]').val();
            var enDate = $('input[name=enDate]').val();

            $.ajax({

                url: 'process_order.php?method=fetchdata&theid='+all_val+'&stdate='+stDate+'&endate='+enDate + " ",
                dataType: 'json',
                success: function(s){

                    if(s == "empty"){

                    } else {
                        var data = [];

                        for(var i = 0; i < s.length; i++) {
                            data.push([s[i][0], s[i][1], s[i][2], s[i][3], s[i][4], s[i][5], s[i][6], s[i][7], s[i][8], s[i][9], s[i][10], s[i][11], s[i][12], s[i][13]]);
                        }

                        var oTable = $('#jsontable_order').dataTable({
                            "data": data,
                            "iDisplayLength": 25,
                            "processing": true,
                            "scrollX": true,
                            "deferRender": true,
                            "order": [[ 0, "desc" ]]
                        });
                    }
                },
                error: function(e){
                    //console.log(e.responseText);
                    //alert(e.responseText);
                    //alert('Error loading records.')
                }
            });
        }

        function getrecord_max(){

            $('#jsontable').dataTable().fnDestroy();

            var all_val = $('input[name=options]:checked').val();
            var stDate = $('input[name=stDate]').val();
            var enDate = $('input[name=enDate]').val();

            $.ajax({

                url: 'process.php?method=fetchdata&theid='+all_val+'&stdate='+stDate+'&endate='+enDate + " ",
                dataType: 'json',
                success: function(s){

                    if(s == "empty"){
                    } else {
                        var data = [];
                        for(var i = 0; i < s.length; i++) {
                            data.push([s[i][16], s[i][6], s[i][0], s[i][14], s[i][1], s[i][8], s[i][7], s[i][10], s[i][19], s[i][17], s[i][12], s[i][11], s[i][20], s[i][2], s[i][4], s[i][21], s[i][5], s[i][13], s[i][15], s[i][18], s[i][22], s[i][23], s[i][24], s[i][3], s[i][9], s[i][25], s[i][26], s[i][27]]);
                        }

                        var oTable = $('#jsontable').dataTable({
                            "data": data,
                            "iDisplayLength": 25,
                            "processing": true,
                            "scrollX": true,
                            "deferRender": true,
                            "order": [[ 0, "desc" ]]
                        });
                    }
                },
                error: function(e){
                    //console.log(e.responseText);
                    //alert(e.responseText);
                    //alert('Error loading records.')
                }
            });
        }

    </script>



    <div id="back" style="display:none;"></div>

    <div id="back_email" style="display:none;"></div>

</body>
</html>