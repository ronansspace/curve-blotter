<?php
session_start();
 require_once('../inc/def.php');
if(tdrLoggedIn()){	
	
  
  
  
  /*$servername = "213.171.200.80";
  $username = "admin_cmarkets";
  $password = "Admin1@cmarkets";
  $dbname = "cmarkets";
  */
  
  /*echo '<pre>';
    var_dump($_POST);
    var_dump($_GET);
  echo '</pre>';*/
  
// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
//$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
  
$tdrID = $_SESSION['auth_id'];
$contract = $_GET['contract'];
$account  = $_GET['account'];
$status  = $_GET['status'];

$id_contract = $_POST['id_contract'];

$cl = $_POST['client'];

$rate = $_POST['rate'];

$tdate = $_POST['trade_date'];

$exp = $_POST['expiry'];

$cp = $_POST['ccy_pair'];

$vd = $_POST['value_date'];

$spcut = $_POST['spcut'];

$b = $_POST['buy_sell'];

$ca = $_POST['counter_amt'];

$ta = $_POST['traded_as'];

$ct = $_POST['cut_time'];

$not = str_replace(',','',$_POST['notional']);

$calc = $_POST['calc'];

$pb = $_POST['prime_broker'];

$st = $_POST['settlement'];

$I = $_POST['inverted'];

$oet = $_POST['order_entry_time'];

$fpi = $_POST['fx_pair_id'];

$md = $_POST['match_date'];



$sql = "";

      if($contract == "FXSP"){
      $sql = "INSERT INTO contract (tdrID, client, ccy_pair,buy_sell,Notional,Inverted_price,rate,counter_amt,calc,trade_date,value_date,
              traded_as,prime_broker,order_entry_time,expiry,spcut,cut_time,settlement,fx_pair_id,matching_date,contract,account,status)
              VALUES ($tdrID, '$cl', '$cp','$b',$not,'$I','$rate','$ca','$calc','$tdate','$vd','$ta','$pb','$oet','$exp','$spcut','$ct','$st','$fpi','$md','$contract','$account','$status')";
      }
      
      if($contract == "FXSP" && $id_contract <>""){
              $sql = "update contract set tdrID = $tdrID, client = '$cl', ccy_pair = '$cp', buy_sell = '$b', Notional = $not, Inverted_price = '$I',
                      rate = '$rate',counter_amt = '$ca',calc = '$calc',trade_date = '$tdate',value_date = '$vd',
                      traded_as = '$ta',prime_broker = '$pb',order_entry_time = '$oet',expiry = '$exp',
                      spcut = '$spcut',cut_time = '$ct',settlement = '$st',fx_pair_id = '$fpi',matching_date = '$md',contract ='$contract',account = '$account', status = '$status'
                      where id_contract = $id_contract";
      
      }
      
      if($contract == "FXFW"){
        	$mid_price = $_POST['mid_price'];
        	$del = $_POST['deliverablity'];
        	$sql = "INSERT INTO contract (tdrID, client, ccy_pair,buy_sell,Notional,Inverted_price,rate,counter_amt,calc,trade_date,value_date,
                  traded_as,prime_broker,order_entry_time,expiry,spcut,cut_time,settlement,fx_pair_id,matching_date,contract,deliverablity,mid_price,account,status)
                  VALUES ($tdrID, '$cl', '$cp','$b',$not,'$I','$rate','$ca','$calc','$tdate','$vd','$ta','$pb','$oet','$exp','$spcut','$ct','$st','$fpi','$md','$contract','$del','$mid_price','$account','$status')";
      }
      if($contract == "FXFW" && $id_contract <>""){
         $mid_price = $_POST['mid_price'];
      	 $del = $_POST['deliverablity'];
         
         $sql = "update contract set tdrID = $tdrID, client = '$cl', ccy_pair = '$cp', buy_sell = '$b', Notional = $not, Inverted_price = '$I',
                      rate = '$rate',counter_amt = '$ca',calc = '$calc',trade_date = '$tdate',value_date = '$vd',
                      traded_as = '$ta',prime_broker = '$pb',order_entry_time = '$oet',expiry = '$exp',
                      spcut = '$spcut',cut_time = '$ct',settlement = '$st',fx_pair_id = '$fpi',matching_date = '$md',contract ='$contract',
                      deliverablity = '$del', mid_price = '$mid_price', account = '$account', status = '$status'
                      where id_contract = $id_contract";
                      
      
      }
      
      
      if($contract == "FXNDF"){
      	$mid_price = $_POST['mid_price'];
      	$del = $_POST['deliverablity'];
      	$invert_price = $_POST['invertedprice'];
      	$fxdate =  $_POST['fixing_date'];
      	$sql = "INSERT INTO contract (tdrID, client, ccy_pair,buy_sell,Notional,Inverted_price,rate,counter_amt,calc,trade_date,value_date,
                traded_as,prime_broker,order_entry_time,expiry,spcut,cut_time,settlement,fx_pair_id,matching_date,contract,deliverablity,mid_price,account,fixing_date,status)
                VALUES ($tdrID, '$cl', '$cp','$b',$not,'$I','$rate','$ca','$calc','$tdate','$vd','$ta','$pb','$oet','$exp','$spcut','$ct','$st','$fpi','$md','$contract','$del','$mid','$account','$fxdate','$status')";
      }
      
      
      if($contract == "FXNDF" && $id_contract <>""){
      	$mid_price = $_POST['mid_price'];
      	$del = $_POST['deliverablity'];
      	$invert_price = $_POST['invertedprice'];    
      	$fxdate =  $_POST['fixing_date'];
        
         /*
      	 $sql = "INSERT INTO contract (tdrID, client, ccy_pair,buy_sell,Notional,Inverted_price,rate,counter_amt,calc,trade_date,value_date,
                traded_as,prime_broker,order_entry_time,expiry,spcut,cut_time,settlement,fx_pair_id,matching_date,contract,deliverablity,mid_price,account,fixing_date)
                VALUES ($tdrID, '$cl', '$cp','$b',$not,'$I','$rate','$ca','$calc','$tdate','$vd','$ta','$pb','$oet','$exp','$spcut','$ct','$st','$fpi','$md','$contract','$del','$mid','$account','$fxdate')";
         */
      
         $sql = "update contract set tdrID = $tdrID, client = '$cl', ccy_pair = '$cp', buy_sell = '$b', Notional = $not, Inverted_price = '$I',
                      rate = '$rate',counter_amt = '$ca',calc = '$calc',trade_date = '$tdate',value_date = '$vd',
                      traded_as = '$ta',prime_broker = '$pb',order_entry_time = '$oet',expiry = '$exp',
                      spcut = '$spcut',cut_time = '$ct',settlement = '$st',fx_pair_id = '$fpi',matching_date = '$md',contract ='$contract',
                      deliverablity = '$del', mid_price = '$mid_price', account = '$account', fixing_date = '$fxdate',status = '$status'
                      where id_contract = $id_contract";
      
      }
      
      
      if($contract == "FXOPT"){
      	
        $mid_price = $_POST['mid_price'];
      	$del = $_POST['deliverablity'];
      	$invert_price = $_POST['invertedprice'];
      	$fxdate =  $_POST['fixing_date'];
        
        
        //NOT IN DB
        $premium_ccy = $_POST['premium_ccy'];
        $settle_date = $_POST['settle_date'];
        $spcut_cp = $_POST['spcut_cp'];
        $price_percentage = $_POST['price_percentage'];
        $option_style = $_POST['option_style'];  
        $calculations = $_POST['calculations'];
        $premium_amount = $_POST['premium_amount'];
        
        // IN DB
        $expiry_date = $_POST['expiry_date'];
        $payout_ccy = $_POST['payout_ccy'];
        $strike = $_POST['strike'];
        
        
      	$sql = "INSERT INTO contract (tdrID, client, ccy_pair,buy_sell,Notional,Inverted_price,rate,counter_amt,calc,trade_date,value_date,
                traded_as,prime_broker,order_entry_time,expiry,spcut,cut_time,settlement,fx_pair_id,matching_date,contract,deliverablity,mid_price,account,fixing_date,
                premium_ccy,settle_date,spcut_cp,price_percentage,option_style,calculations,expiry_date,payout_ccy,premium_amount, strike, status)
                VALUES ($tdrID, '$cl', '$cp','$b',$not,'$I','$rate','$ca','$calc','$tdate','$vd','$ta','$pb','$oet','$exp','$spcut','$ct','$st','$fpi','$md',
                '$contract','$del','$mid','$account','$fxdate',
                '$premium_ccy','$settle_date','$spcut_cp','$price_percentage','$option_style','$calculations','$expiry_date','$payout_ccy','$premium_amount','$strike','$status')";
      
      }
      
      if($contract == "FXOPT" && $id_contract <>""){
       
               //NOT IN DB
              $premium_ccy = $_POST['premium_ccy'];
              
              $spcut_cp = $_POST['spcut_cp'];
              $price_percentage = $_POST['price_percentage'];
              $option_style = $_POST['option_style'];  
              $calculations = $_POST['calculations'];
              $premium_amount = $_POST['premium_amount'];
              
              // IN DB
              $expiry_date = $_POST['expiry_date'];
              $payout_ccy = $_POST['payout_ccy'];
              $settle_date = $_POST['settle_date'];
              $strike = $_POST['strike']; 
       
                 $sql = "update contract set tdrID = $tdrID, client = '$cl', ccy_pair = '$cp', buy_sell = '$b', Notional = $not, Inverted_price = '$I',
                      rate = '$rate',counter_amt = '$ca',calc = '$calc',trade_date = '$tdate',value_date = '$vd',
                      traded_as = '$ta',prime_broker = '$pb',order_entry_time = '$oet',expiry = '$exp',
                      spcut = '$spcut',cut_time = '$ct',settlement = '$st',fx_pair_id = '$fpi',matching_date = '$md',contract ='$contract',
                      deliverablity = '$del', mid_price = '$mid_price', account = '$account', fixing_date = '$fxdate',
                      premium_ccy = '$premium_ccy',settle_date  = '$settle_date',spcut_cp  = '$spcut_cp',price_percentage  = '$price_percentage',
                      option_style  = '$option_style', calculations = '$calculations',expiry_date = '$expiry_date',payout_ccy = '$payout_ccy', 
                      premium_amount = '$premium_amount', strike = '$strike', status = '$status'                        
                      where id_contract = $id_contract";      
       
      }
      
      if($contract == "EOPT"){
      	
        $mid_price = $_POST['mid_price'];
      	$del = $_POST['deliverablity'];
      	$invert_price = $_POST['invertedprice'];
      	$fxdate =  $_POST['fixing_date'];
        
        
        //NOT IN DB
        $premium_ccy = $_POST['premium_ccy'];
        $settle_date = $_POST['settle_date'];
        $spcut_cp = $_POST['spcut_cp'];
        $price_percentage = $_POST['price_percentage'];
        $option_style = $_POST['option_style'];  
        $calculations = $_POST['calculations'];
        $premium_amount = $_POST['premium_amount'];
        
        // IN DB
        $expiry_date = $_POST['expiry_date'];
        $payout_ccy = $_POST['payout_ccy'];
        $strike = $_POST['strike'];
        
        
        $opt_type =  $_POST['opt_type'];
        $lower_barrier = $_POST['lower_barrier'];
        $cashat = $_POST['cashat'];
        $up_barrier_sd = $_POST['up_barrier_sd'];
        $up_barrier_ed = $_POST['up_barrier_ed'];
        
        $barrier_type = $_POST['barrier_type']; //
        $knock_in_out = $_POST['knock_in_out']; //
        $rebate_ccy = $_POST['rebate_ccy'];   //
        $touch_up_down = $_POST['touch_up_down'];  //
        $rebate_amt = $_POST['rebate_amt']; //
        
        $lw_barrier_sd = $_POST['lw_barrier_sd'];
        $lw_barrier_ed = $_POST['lw_barrier_ed'];
        $up_barrier = $_POST['up_barrier'];
        
        $barrier_style = $_POST['barrier_style'];
        $mid_barrier = $_POST['mid_barrier'];
        
        
        
      	$sql = "INSERT INTO contract (tdrID, client, ccy_pair,buy_sell,Notional,Inverted_price,rate,counter_amt,calc,trade_date,value_date,
                traded_as,prime_broker,order_entry_time,expiry,spcut,cut_time,settlement,fx_pair_id,matching_date,contract,deliverablity,mid_price,account,fixing_date,
                premium_ccy,settle_date,spcut_cp,price_percentage,option_style,calculations,expiry_date,payout_ccy,premium_amount, strike,
                opt_type, lower_barrier, cashat, up_barrier_sd, up_barrier_ed, barrier_type, knock_in_out, rebate_ccy, touch_up_down, rebate_amt, 
                lw_barrier_sd, lw_barrier_ed, up_barrier, barrier_style, mid_barrier,status)
                VALUES ($tdrID, '$cl', '$cp','$b',$not,'$I','$rate','$ca','$calc','$tdate','$vd','$ta','$pb','$oet','$exp','$spcut','$ct','$st','$fpi','$md',
                '$contract','$del','$mid','$account','$fxdate',
                '$premium_ccy','$settle_date','$spcut_cp','$price_percentage','$option_style','$calculations','$expiry_date','$payout_ccy','$premium_amount','$strike',
                '$opt_type', '$lower_barrier', '$cashat', '$up_barrier_sd', '$up_barrier_ed', '$barrier_type', '$knock_in_out', '$rebate_ccy', '$touch_up_down', '$rebate_amt', 
                '$lw_barrier_sd', '$lw_barrier_ed', '$up_barrier', '$barrier_style', '$mid_barrier','$status')";
      
      }
      
      if($contract == "EOPT" && $id_contract <>""){
       
               //NOT IN DB
              $premium_ccy = $_POST['premium_ccy'];
              
              $spcut_cp = $_POST['spcut_cp'];
              $price_percentage = $_POST['price_percentage'];
              $option_style = $_POST['option_style'];  
              $calculations = $_POST['calculations'];
              $premium_amount = $_POST['premium_amount'];
              
              // IN DB
              $expiry_date = $_POST['expiry_date'];
              $payout_ccy = $_POST['payout_ccy'];
              $settle_date = $_POST['settle_date'];
              $strike = $_POST['strike']; 
              
              
              $opt_type =  $_POST['opt_type'];
              $lower_barrier = $_POST['lower_barrier'];
              $cashat = $_POST['cashat'];
              $up_barrier_sd = $_POST['up_barrier_sd'];
              $up_barrier_ed = $_POST['up_barrier_ed'];
              
              $barrier_type = $_POST['barrier_type']; //
              $knock_in_out = $_POST['knock_in_out']; //
              $rebate_ccy = $_POST['rebate_ccy'];   //
              $touch_up_down = $_POST['touch_up_down'];  //
              $rebate_amt = $_POST['rebate_amt']; //
              
              $lw_barrier_sd = $_POST['lw_barrier_sd'];
              $lw_barrier_ed = $_POST['lw_barrier_ed'];
              $up_barrier = $_POST['up_barrier'];
              
              $barrier_style = $_POST['barrier_style'];
              $mid_barrier = $_POST['mid_barrier'];
              
       
                 $sql = "update contract set tdrID = $tdrID, client = '$cl', ccy_pair = '$cp', buy_sell = '$b', Notional = $not, Inverted_price = '$I',
                      rate = '$rate',counter_amt = '$ca',calc = '$calc',trade_date = '$tdate',value_date = '$vd',
                      traded_as = '$ta',prime_broker = '$pb',order_entry_time = '$oet',expiry = '$exp',
                      spcut = '$spcut',cut_time = '$ct',settlement = '$st',fx_pair_id = '$fpi',matching_date = '$md',contract ='$contract',
                      deliverablity = '$del', mid_price = '$mid_price', account = '$account', fixing_date = '$fxdate',
                      premium_ccy = '$premium_ccy',settle_date  = '$settle_date',spcut_cp  = '$spcut_cp',price_percentage  = '$price_percentage',
                      option_style  = '$option_style', calculations = '$calculations',expiry_date = '$expiry_date',payout_ccy = '$payout_ccy', 
                      premium_amount = '$premium_amount', strike = '$strike',
                      opt_type = '$opt_type', lower_barrier = '$lower_barrier', cashat = '$cashat', up_barrier_sd = '$up_barrier_sd', up_barrier_ed = '$up_barrier_ed', barrier_type = '$barrier_type', 
                      knock_in_out = '$knock_in_out', rebate_ccy = '$rebate_ccy', touch_up_down = '$touch_up_down', rebate_amt = '$rebate_amt', 
                      lw_barrier_sd = '$lw_barrier_sd', lw_barrier_ed = '$lw_barrier_ed', up_barrier = '$up_barrier', barrier_style = '$barrier_style', mid_barrier = '$mid_barrier', status = '$status'                        
                      where id_contract = $id_contract";      
       
      }
      
  /*    
  opt_type
  lower_barrier
  cashat
  up_barrier_sd
  up_barrier_ed
  barrier_type
  knock_in_out
  rebate_ccy
  lw_barrier_sd
  lw_barrier_ed
  up_barrier
  touch_up_down
  rebate_amt
  barrier_style
  mid_barrier
  */

      if ($conn->query($sql) === TRUE) {
      
          echo "New record created successfully";
      
      } else {
      
          echo "Error: " . $sql . "<br>" . $conn->error;
      
      }
      
      
      $conn->close();
}
?>
       