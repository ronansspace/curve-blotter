<?php
session_start();
require_once('../inc/def.php');
include('Classes/PHPExcel.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
} 

if(!tdrLoggedIn()){	

}else{

        $fl_attach = 0;        
        $id_trades = $_GET['id_trades'];
        
        //$filename = "blotter_" . date("Y-m-d_H-i") . ".csv";
        $filename = "Curve_RBS_CSV_" . date("Ymd_His") . ".csv"; 
        $fd = fopen('excel_files/'.$filename, "w");
    
        //header('Content-Type: text/csv; charset=utf-8');
        //header('Content-Disposition: attachment; filename=excel_files\"'.$filename.'"');
        //header('Pragma: no-cache');
        //header('Expires: 0');
        
        //$f = fopen('excel_files/'.$filename, 'w');

        //$BOM = "\xEF\xBB\xBF";
        //fwrite($f, $BOM); // EXCEL PROBLEM SOLVED   
            
        $sql = "SELECT * FROM contract where id_contract in($id_trades) order by id_contract desc";
      	$result = $conn->query($sql);
        
        $sql_mark_trade = "update contract set pb_email = '1' where id_contract in($id_trades)";
      	$result_mark_trade = $conn->query($sql_mark_trade);                 
      
        //$serialnumber=0;
        /*
        $tmparray = array("source_system", "client_trade_id",	"report_date", "value_date", "trade_date", "ccy_pair",	"buy_sell_indicator",	"notional",	
        "counter_amount", "price", "fixing_date",	"fixing_source",	"account",	"contract_type_code",	"far_leg_amount",
        "far_leg_rate",	"far_leg_value_date",	"far_fixing_date", "far_fixing_source",	"option_put_call_ind",	"option_payment_ccy", 
        "option_settlement_date",	"option_expiry_date",	"option_premium_amount", "option_premium_date",	"option_style",	
        "option_price", "platform_indicator",	"platform_trade_id",	"counter_party", "deleted_trade_flag", "amended_trade_flag",
        "parent_trade_id",	"trade_type", "traded_ccy",	"option_exercise",	"option_cut_code",	"second_fixing_source",	"advice_status_id",	
        "exotic_option_type",	"exotic_option_barrier_type",	"exotic_option_upper_barrier",	"exotic_option_lower_barrier",	
        "exotic_option_knock_in_out", "exotic_option_touch_up_down",	"exotic_option_cash_at", 
        "exotic_option_rebate_ccy",	"exotic_option_rebate_amount",	"exotic_option_barrier_startdate",	
        "exotic_option_barrier_enddate",	"exotic_option_monitor_window_cutoff",	"exotic_option_monitor_window_cutoffcity", "exotic_option_monitoring_window",	
        "exotic_option_distribution_fallback1",	"exotic_option_distribution_fallback2",	"exotic_option_distribution_fallback3",	
        "exotic_option_distribution_fallback4",	"trade_event_type",	"exotic_option_lower_barrier_startdate",	"exotic_option_lower_barrier_enddate",	
        "exotic_option_upper_barrier_startdate",	"exotic_option_upper_barrier_enddate",	"original_file_name",	"is_novation	deliverability",	
        "option_pricing_premium_ccy",	"far_leg_counter_amount",	"is_swap",	"option_pricing_premium_conversion_rate",	"option_pricing_premium",	
        "ignore_duplicate_check",	"is_fast_track",	"mid_price",	"mid_points",	"dealer_code");
        
        $pasajeros = [  "source_system", "client_trade_id",	"report_date", "value_date", "trade_date", "ccy_pair",	"buy_sell_indicator",	"notional",	
                        "counter_amount", "price", "fixing_date",	"fixing_source",	"account",	"contract_type_code",	"far_leg_amount",
                        "far_leg_rate",	"far_leg_value_date",	"far_fixing_date", "far_fixing_source",	"option_put_call_ind",	"option_payment_ccy", 
                        "option_settlement_date",	"option_expiry_date",	"option_premium_amount", "option_premium_date",	"option_style",	
                        "option_price", "platform_indicator",	"platform_trade_id",	"counter_party", "deleted_trade_flag", "amended_trade_flag",
                        "parent_trade_id",	"trade_type", "traded_ccy",	"option_exercise",	"option_cut_code",	"second_fixing_source",	"advice_status_id",	
                        "exotic_option_type",	"exotic_option_barrier_type",	"exotic_option_upper_barrier",	"exotic_option_lower_barrier",	
                        "exotic_option_knock_in_out", "exotic_option_touch_up_down",	"exotic_option_cash_at", 
                        "exotic_option_rebate_ccy",	"exotic_option_rebate_amount",	"exotic_option_barrier_startdate",	
                        "exotic_option_barrier_enddate",	"exotic_option_monitor_window_cutoff",	"exotic_option_monitor_window_cutoffcity", "exotic_option_monitoring_window",	
                        "exotic_option_distribution_fallback1",	"exotic_option_distribution_fallback2",	"exotic_option_distribution_fallback3",	
                        "exotic_option_distribution_fallback4",	"trade_event_type",	"exotic_option_lower_barrier_startdate",	"exotic_option_lower_barrier_enddate",	
                        "exotic_option_upper_barrier_startdate",	"exotic_option_upper_barrier_enddate",	"original_file_name",	"is_novation	deliverability",	
                        "option_pricing_premium_ccy",	"far_leg_counter_amount",	"is_swap",	"option_pricing_premium_conversion_rate",	"option_pricing_premium",	
                        "ignore_duplicate_check",	"is_fast_track",	"mid_price",	"mid_points",	"dealer_code"
                    ];  
        
        */
        //take new main array and set header array in it.
        //$sheet =array($tmparray);
        
        
         $csv = "source_system".",". "client_trade_id".",".	"report_date".",". "value_date".",". "trade_date".",". "ccy_pair".",".	"buy_sell_indicator".",".	"notional".",".	
                        "counter_amount".",". "price".",". "fixing_date".",".	"fixing_source".",".	"account".",".	"contract_type_code".",".	"far_leg_amount".",".
                        "far_leg_rate".",".	"far_leg_value_date".",".	"far_fixing_date".",". "far_fixing_source".",".	"option_put_call_ind".",".	"option_payment_ccy".",". 
                        "option_settlement_date".",".	"option_expiry_date".",".	"option_premium_amount".",". "option_premium_date".",".	"option_style".",".	
                        "option_price".",". "platform_indicator".",".	"platform_trade_id".",".	"counter_party".",". "deleted_trade_flag".",". "amended_trade_flag".",".
                        "parent_trade_id".",".	"trade_type".",". "traded_ccy".",".	"option_exercise".",".	"option_cut_code".",".	"second_fixing_source".",".	"advice_status_id".",".	
                        "exotic_option_type".",".	"exotic_option_barrier_type".",".	"exotic_option_upper_barrier".",".	"exotic_option_lower_barrier".",".	
                        "exotic_option_knock_in_out".",". "exotic_option_touch_up_down".",".	"exotic_option_cash_at".",". 
                        "exotic_option_rebate_ccy".",".	"exotic_option_rebate_amount".",".	"exotic_option_barrier_startdate".",".	
                        "exotic_option_barrier_enddate".",".	"exotic_option_monitor_window_cutoff".",".	"exotic_option_monitor_window_cutoffcity".",". "exotic_option_monitoring_window".",".	
                        "exotic_option_distribution_fallback1".",".	"exotic_option_distribution_fallback2".",".	"exotic_option_distribution_fallback3".",".	
                        "exotic_option_distribution_fallback4".",".	"trade_event_type".",".	"exotic_option_lower_barrier_startdate".",".	"exotic_option_lower_barrier_enddate".",".	
                        "exotic_option_upper_barrier_startdate".",".	"exotic_option_upper_barrier_enddate".",".	"original_file_name".",".	"is_novation".","."deliverability".",".	
                        "option_pricing_premium_ccy".",".	"far_leg_counter_amount".",".	"is_swap".",".	"option_pricing_premium_conversion_rate".",".	"option_pricing_premium".",".	
                        "ignore_duplicate_check".",".	"is_fast_track".",".	"mid_price".",".	"mid_points".",".	"dealer_code"."\r\n"; 
        
        $report_date = date('d/m/Y');
        
        //fputcsv($f, $pasajeros);      
      
        while($fetch = $result->fetch_assoc())
        {
                     
                        if($fetch["Notional"] <> "" || $fetch["Notional"] <> 0){
                               $deci = strlen(substr(strrchr($fetch["Notional"], "."), 1));
                               $notional =  number_format($fetch["Notional"], $deci, '.', '');
                        }else{
                               $notional = 0;
                        }
                        
                        if($fetch["counter_amt"] <> "" || $fetch["counter_amt"] <> 0){
                              $deci = strlen(substr(strrchr($fetch["counter_amt"], "."), 1));
                              $counter_amts =  number_format($fetch["counter_amt"], 2, '.', ',');
                        }else{
                               $counter_amts = 0;
                        }
                        
                        if($fetch["price"] <> "" || $fetch["price"] <> 0){
                               $deci = strlen(substr(strrchr($fetch["price"], "."), 1));
                               $price =  number_format($fetch["price"], $deci, '.', ',');
                        }else{
                               $price = "0.00";
                        }
                        
                        if($fetch["rate"] <> "" || $fetch["rate"] <> 0){
                               $deci = strlen(substr(strrchr($fetch["rate"], "."), 1));
                               $rate =  number_format($fetch["rate"], $deci, '.', ',');
                        }else{
                               $rate = "0.00";
                        }
                        
                        if($fetch["premium_amount"] <> "" || $fetch["premium_amount"] <> 0){
                               //$premium_amount=  number_format($fetch["premium_amount"], 2, '.', '');
                               $deci = strlen(substr(strrchr($fetch["premium_amount"], "."), 1)); 
                               $premium_amount =  number_format($fetch["premium_amount"], $deci, '.', ',');
                        }else{
                               $premium_amount = "0.00";
                        }
                        
                        if($fetch["deleted_trade_flag"] <> "" || $fetch["deleted_trade_flag"] == 1){ 
                            $deleted_trade_flag  = 'Y';
                        }else{
                            $deleted_trade_flag  = '';
                        }
                        
                        if($fetch["amended_trade_flag"] <> "" || $fetch["amended_trade_flag"] == 1){ 
                            $amended_trade_flag  = 'Y';
                        }else{
                            $amended_trade_flag  = '';
                        }
                        
                        if($fetch["mid_price"] <> "" || $fetch["mid_price"] <> 0){
                        
                              $deci = strlen(substr(strrchr($fetch["mid_price"], "."), 1)); 
                              $mid_price =  number_format($fetch["mid_price"], $deci, '.', '');
                        }else{
                              $mid_price = "0.00";
                        }
                        
                        $client_id = $fetch["client"];
                        
                        $sql2 = "select * from clients where id = $client_id";
                        $result2 = $conn->query($sql2);                       
                        $fetch2 = $result2->fetch_array();
                        
                        if($fetch2['name'] <> ""){  
                          $client_name = $fetch2['name'];
                        }
                        
                        
                        //$fetch["contract"]
                        
                        //$message_fxndf = "";
                        if($fetch["contract"] == "FXNDF"){
                              $contract_all = "FXFW";
                        } else {
                              $contract_all = $fetch["contract"];
                        }
                        
                        
                        // Unknown Variables
                        $fixing_source = "";
                        $far_leg_amount = "";
                        $far_leg_rate = "";
                        $far_leg_value_date = "";
                        $far_fixing_date = "";
                        $far_fixing_source = "";
                        $option_put_call_ind = "";   
                        $option_payment_ccy = "";  
                        $option_premium_date = "";
                        $option_price = ""; 
                        $platform_indicator = ""; 
                        $platform_trade_id = ""; 
                        $parent_trade_id = ""; 
                        $trade_type = "";
                        $traded_ccy = ""; 
                        $option_exercise = "";
                        $option_cut_code = ""; 
                        $second_fixing_source = "";
                        $advice_status_id = "";  
                        $exotic_option_type = ""; 
                        $exotic_option_barrier_start_date = "";
                        $exotic_option_barrier_enddate = "";
                        $exotic_option_monitor_window_cutoff = ""; 
                        $exotic_option_monitor_window_cutoffcity = "";    
                        $exotic_option_monitoring_window = "";   
                        $exotic_option_distribution_fallback1 = "";  
                        $exotic_option_distribution_fallback2 = "";  
                        $exotic_option_distribution_fallback3 = ""; 
                        $exotic_option_distribution_fallback4 = "";
                        $trade_event_type = "";
                        $original_file_name = "";
                        $is_novation = "";
                        $option_pricing_premium_ccy = "";
                        $far_leg_counter_amount = "";
                        $is_swap = "";
                        $option_pricing_premium_conversion_rate = "";
                        $option_pricing_premium ="";
                        $ignore_duplicate_check = "";
                        $is_fast_track = "";
                        $mid_points = "";
                        $dealer_code = "";
                      
                     
                      //$tmparray = array();
          
                      //$serialnumber = $serialnumber + 1;
                      
                       
                      //$fetch["account"]
                      $account = "CURVE_MP";
                      
                      
                      /*
                      array_push($tmparray,"CURVE");
                      array_push($tmparray,$fetch["id_contract"]);
                      array_push($tmparray,$report_date);
                      array_push($tmparray,$fetch["value_date"]);
                      array_push($tmparray,$fetch["trade_date"]);
                      array_push($tmparray,$fetch["ccy_pair"]);
                      array_push($tmparray,$fetch["buy_sell"]);
                      array_push($tmparray,$notional);
                      array_push($tmparray,$counter_amts);  
                      /*array_push($tmparray,$rate);
                      array_push($tmparray,$rate);
                      array_push($tmparray,$fetch["fixing_date"]);
                      array_push($tmparray,$fixing_source);
                      array_push($tmparray,$account);
                      array_push($tmparray,$fetch["contract"]);
                      array_push($tmparray,$far_leg_amount);
                      array_push($tmparray,$far_leg_rate);
                      array_push($tmparray,$far_leg_value_date);
                      array_push($tmparray,$far_fixing_date);
                      array_push($tmparray,$far_fixing_source);
                      array_push($tmparray,$option_put_call_ind);
                      array_push($tmparray,$option_payment_ccy);
                      array_push($tmparray,$fetch["settle_date"]);
                      array_push($tmparray,$fetch["expiry_date"]);
                      array_push($tmparray,$premium_amount);
                      array_push($tmparray,$option_premium_date);
                      array_push($tmparray,$fetch["option_style"]);
                      array_push($tmparray,$option_price);
                      array_push($tmparray,$platform_indicator);
                      array_push($tmparray,$platform_trade_id);
                      array_push($tmparray,$client_name);
                      array_push($tmparray,$deleted_trade_flag);
                      array_push($tmparray,$amended_trade_flag);
                      array_push($tmparray,$parent_trade_id);
                      array_push($tmparray,$trade_type);
                      array_push($tmparray,$traded_ccy);
                      array_push($tmparray,$option_exercise);
                      array_push($tmparray,$option_cut_code);
                      array_push($tmparray,$second_fixing_source);
                      array_push($tmparray,$advice_status_id);
                      array_push($tmparray,$exotic_option_type);
                      array_push($tmparray,$fetch["barrier_type"]);
                      array_push($tmparray,$fetch["u_barrier"]);
                      array_push($tmparray,$fetch["l_barrier"]);
                      array_push($tmparray,$fetch["knock_in_out"]);
                      array_push($tmparray,$fetch["touch_up_down"]);
                      array_push($tmparray,$fetch["cash_at"]);
                      array_push($tmparray,$fetch["rebate_ccy"]);
                      array_push($tmparray,$fetch["rebate_amt"]);
                      array_push($tmparray,$exotic_option_barrier_start_date);
                      array_push($tmparray,$exotic_option_barrier_enddate);
                      array_push($tmparray,$exotic_option_monitor_window_cutoff);
                      array_push($tmparray,$exotic_option_monitor_window_cutoffcity);
                      array_push($tmparray,$exotic_option_monitoring_window);
                      array_push($tmparray,$exotic_option_distribution_fallback1);
                      array_push($tmparray,$exotic_option_distribution_fallback2);
                      array_push($tmparray,$exotic_option_distribution_fallback3);
                      array_push($tmparray,$exotic_option_distribution_fallback4);
                      array_push($tmparray,$trade_event_type);
                      array_push($tmparray,$fetch["lw_barrier_sd"]);
                      array_push($tmparray,$fetch["lw_barrier_ed"]);
                      array_push($tmparray,$fetch["up_barrier_sd"]);
                      array_push($tmparray,$fetch["up_barrier_ed"]);
                      array_push($tmparray,$original_file_name);
                      array_push($tmparray,$is_novation);
                      array_push($tmparray,$fetch["deliverablity"]);
                      array_push($tmparray,$option_pricing_premium_ccy);
                      array_push($tmparray,$far_leg_counter_amount);
                      array_push($tmparray,$is_swap);
                      array_push($tmparray,$option_pricing_premium_conversion_rate);
                      array_push($tmparray,$option_pricing_premium);
                      array_push($tmparray,$ignore_duplicate_check);
                      array_push($tmparray,$is_fast_track);
                      array_push($tmparray,$mid_price);
                      array_push($tmparray,$mid_points);
                      array_push($tmparray,$dealer_code);
                                            
                      $pasajeros2 = [   "CURVE", $fetch["id_contract"], $report_date, $fetch["value_date"], $fetch["trade_date"], $fetch["ccy_pair"], $fetch["buy_sell"],
                                        $notional, $counter_amts, $rate, $fetch["fixing_date"], $fixing_source, $account, $fetch["contract"], $far_leg_amount, $far_leg_rate,
                                        $far_leg_value_date, $far_fixing_date, $far_fixing_source, $option_put_call_ind, $option_payment_ccy, $fetch["settle_date"], $fetch["expiry_date"],
                                        $premium_amount, $option_premium_date, $fetch["option_style"], $option_price, $platform_indicator, $platform_trade_id, $client_name, $deleted_trade_flag,
                                        $amended_trade_flag, $parent_trade_id, $trade_type, $traded_ccy, $option_exercise, $option_cut_code, $second_fixing_source, $advice_status_id, $exotic_option_type,
                                        $fetch["barrier_type"], $fetch["u_barrier"], $fetch["l_barrier"], $fetch["knock_in_out"], $fetch["touch_up_down"], $fetch["cash_at"], $fetch["rebate_ccy"],
                                        $fetch["rebate_amt"], $exotic_option_barrier_start_date, $exotic_option_barrier_enddate, $exotic_option_monitor_window_cutoff, $exotic_option_monitor_window_cutoffcity, 
                                        $exotic_option_monitoring_window, $exotic_option_distribution_fallback1, $exotic_option_distribution_fallback2, $exotic_option_distribution_fallback3, $exotic_option_distribution_fallback4,
                                        $trade_event_type, $fetch["lw_barrier_sd"], $fetch["lw_barrier_ed"], $fetch["up_barrier_sd"], $fetch["up_barrier_ed"], $original_file_name, $is_novation, $fetch["deliverablity"],
                                        $option_pricing_premium_ccy, $far_leg_counter_amount, $is_swap,  $option_pricing_premium_conversion_rate, $option_pricing_premium, $ignore_duplicate_check, $is_fast_track,
                                        $mid_price, $mid_points, $dealer_code              
                      
                                    ];          
                       */
                       
                      $csv .= "CURVE".",". $fetch["trade_entry_type"].$fetch["id_contract"].",". $report_date.",". $fetch["value_date"].",". $fetch["trade_date"].",". $fetch["ccy_pair"].",". $fetch["buy_sell"].",".
                                        $notional.",". $counter_amts.",". $rate.",". $fetch["fixing_date"].",". $fixing_source.",". $account.",". $contract_all .",". $far_leg_amount.",". $far_leg_rate.",".
                                        $far_leg_value_date.",". $far_fixing_date.",". $far_fixing_source.",". $option_put_call_ind.",". $option_payment_ccy.",". $fetch["settle_date"].",". $fetch["expiry_date"].",".
                                        $premium_amount.",". $option_premium_date.",". $fetch["option_style"].",". $option_price.",". $platform_indicator.",". $platform_trade_id.",". $client_name.",". $deleted_trade_flag.",".
                                        $amended_trade_flag.",". $parent_trade_id.",". $trade_type.",". $traded_ccy.",". $option_exercise.",". $option_cut_code.",". $second_fixing_source.",". $advice_status_id.",". $exotic_option_type.",".
                                        $fetch["barrier_type"].",". $fetch["u_barrier"].",". $fetch["l_barrier"].",". $fetch["knock_in_out"].",". $fetch["touch_up_down"].",". $fetch["cash_at"].",". $fetch["rebate_ccy"].",".
                                        $fetch["rebate_amt"].",". $exotic_option_barrier_start_date.",". $exotic_option_barrier_enddate.",". $exotic_option_monitor_window_cutoff.",". $exotic_option_monitor_window_cutoffcity.",". 
                                        $exotic_option_monitoring_window.",". $exotic_option_distribution_fallback1.",". $exotic_option_distribution_fallback2.",". $exotic_option_distribution_fallback3.",". $exotic_option_distribution_fallback4.",".
                                        $trade_event_type.",". $fetch["lw_barrier_sd"].",". $fetch["lw_barrier_ed"].",". $fetch["up_barrier_sd"].",". $fetch["up_barrier_ed"].",". $original_file_name.",". $is_novation.",". $fetch["deliverablity"].",".
                                        $option_pricing_premium_ccy.",". $far_leg_counter_amount.",". $is_swap.",".  $option_pricing_premium_conversion_rate.",". $option_pricing_premium.",". $ignore_duplicate_check.",". $is_fast_track.",".
                                        $mid_price.",". $mid_points.",". $dealer_code."\r\n";             
                      
                                       
                      
                      //fputcsv($f, $tmparray);
                      
                      //fputcsv($f, $pasajeros2);
                      
                      //echo  $pasajeros2;
                      
        }
        
        //$csv_handler = fopen('csvfile.csv','w');
        //fwrite ($csv_handler,$csv);
        //fclose ($csv_handler);
        
        fputs($fd, $csv);
                 
        ////EMAIL DATA /////
        
        $sql2 = "select * from email_settings";
        $result2 = $conn->query($sql2);                       
        $fetch2 = $result2->fetch_array();
                      
        $name = "RBS";         
        
        $email_to = $fetch2['rbs_email']; //"craig.davis@curvemarkets.com"; 
        $email_cc = $fetch2['email_cc']; //"";
        
    
        $email_from = $fetch2['email_from']; //"fxconfirmations@curvemarkets.com"; // Who the email is from
        $email_subject =  $fetch2['rbs_subject']; //"Curvemarkets Trades"; // The Subject of the email
       
        $email_message = nl2br($fetch2['rbs_body']);
         
        $email_message .= "<br><br><br>".nl2br($fetch2['email_footer']);
        /*$email_message .= "<br><br><img src='http://www.curvemarkets.com/auth/admin/images/logo.jpg' width='150px' />";*/
        $email_message .= "<br><br><br><font size='2'>".nl2br($fetch2['email_disclaimer'])."</font>";
    
        $headers = "From: ".$email_from;
        
        if($email_cc != ""){
            $headers .= "\nCc: ".$email_cc;
        }
    
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";          
    
        $headers .= "\nMIME-Version: 1.0\n" .
        "Content-Type: multipart/mixed;\n" .
        " boundary=\"{$mime_boundary}\"";           
        
        $email_message .= "This is a multi-part message in MIME format.\n\n" .
        "--{$mime_boundary}\n" .
        "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" .
        $email_message .= "\n\n";
       
          //$f = fopen('excel_files/'.$filename, 'w');
          $fileatt_name_xl =  'excel_files/'.$filename;
          $file_name_xl = $filename;
          
          $email_message .= "--{$mime_boundary}\n";
          
          $file_xl = fopen($fileatt_name_xl,'rb');
          $data_xl = fread($file_xl,filesize($fileatt_name_xl));
          
          //$fileatt_type_xl = filetype($fileatt_name_xl);
          fclose($file_xl);
          $data_xl = chunk_split(base64_encode($data_xl));   
          
          
          $email_message .= "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;\n" .
          " name=\"{$file_name_xl}\"\n" .
          //"Content-Disposition: attachment;\n" .
          //" filename=\"{$file_name_xl}\"\n" .
          "Content-Transfer-Encoding: base64\n\n" . 
          $data_xl .= "\n\n" .                      
          "--{$mime_boundary}--\n";
                         
          
    
          $ok = @mail($email_to, $email_subject, $email_message, $headers);
       
          // now we just send the message
          if($ok) {                  
            echo "sent";              
          } else {               
            echo "error";            
          }
    
          fclose($fd);  
          unlink($fileatt_name_xl); 
          exit;
      
}
?>   
  