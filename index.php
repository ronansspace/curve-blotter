<?php
session_start();
require_once('inc/def.php');
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


    <script>


        var result_count  = 0 ;
        var tableid = 1;

        $(document).ready(function() {
            getrecord_max();
        });

        function getrecord_max(){


            $('#jsontable').dataTable().fnDestroy();

            var oTable = $('#jsontable').dataTable({
                "iDisplayLength": 25,
                "processing": true,
                "scrollX": true,
            });

            var all_val = $('input[name=options]:checked').val();
            var stDate = $('input[name=stDate]').val();
            var enDate = $('input[name=enDate]').val();


            $.ajax({

                url: 'process.php?method=fetchdata&theid='+all_val+'&stdate='+stDate+'&endate='+enDate + " ",
                dataType: 'json',
                success: function(s){

                    oTable.fnClearTable();

                    if(s == "empty"){


                    } else {

                        for(var i = 0; i < s.length; i++)
                        {
                            //, env - EMAIL ICON

                            oTable.fnAddData([ "<input type='checkbox' name='id_trades' class='check_box' value='"+s[i][0]+"'/>", s[i][0], s[i][1], s[i][2],
                                s[i][3], s[i][4], s[i][5], s[i][6], s[i][7], s[i][8], s[i][9],
                                s[i][10], s[i][11], s[i][12], s[i][13], s[i][14], s[i][15], s[i][16], s[i][17], s[i][18], s[i][19], s[i][20], s[i][21], s[i][22],
                                s[i][23], s[i][24], s[i][25]
                            ]);

                            var theNode = oTable.fnSettings().aoData[i].nTr;
                            theNode.setAttribute('data-did', s[i][0]);
                            theNode.setAttribute('class', 'record_row');

                            $('td', theNode)[3].setAttribute( 'class', s[i][0] );
                            $('td', theNode)[4].setAttribute( 'class', s[i][0] );

                        } // End For

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