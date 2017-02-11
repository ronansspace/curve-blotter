<?php
session_start();
require_once('../inc/def.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
} 

if(!tdrLoggedIn()){	

}else{

        $fl_attach = 0;        
        $id_trades = $_GET['id_trades'];
                
        $sql = "SELECT * FROM contract where id_contract in($id_trades) order by id_contract desc";
      	$result = $conn->query($sql);
        
        $sql_mark_trade = "update contract set client_email = '1' where id_contract in($id_trades) order by id_contract";
      	$result_mark_trade = $conn->query($sql_mark_trade);
        
        $report_date = date('d/m/Y');
      
        while($fetch = $result->fetch_assoc())
        {
                        
                        $buy_sell = $fetch["buy_sell"];
                        
                        
                        // REVERSE becasue curve asks for it.
                        if($buy_sell == "B"){
                            $buy_sell = "SELL";
                        }else{
                            $buy_sell = "BUY";
                        }
                        
                        $result_pair = substr_replace($fetch["ccy_pair"], "/", 3, 0);
                        
                        $rest_pair = substr($fetch["ccy_pair"],0 , 3);
                        
                        $deci = strlen(substr(strrchr($fetch["Notional"], "."), 1));                           
                        $notional =  number_format($fetch["Notional"], $deci, '.', ',');
                        
                        $decic = strlen(substr(strrchr($fetch["counter_amt"], "."), 1));        
                        $counter_amts =  number_format($fetch["counter_amt"], $decic, '.', ',');
                        
                       
                        $client_id = $fetch["client"];
                        $client_trader = $fetch["client_trader"];
                        
                        $sql2 = "select * from clients where id = $client_id";
                        $result2 = $conn->query($sql2);                       
                        $fetch2 = $result2->fetch_array();
                        
                        if($fetch2['name'] <> ""){  
                           
                          $client_name = $fetch2['name'];
                          $client_email = $fetch2['email'];
                          
                        }
                        
                        $message_fxndf = "";
                        if($fetch["contract"] == "FXNDF"){
                               
                              $message_fxndf = '<tr>
                                <td width="30%"> <b>Fixing Date :</b> </td>
                                 <td>'.$fetch["fixing_date"].'</td>
                              </tr>';
                              
                        }
                        
                        $message = "                        
                        <table width='100%'>
                            <tr>
                                <td width='30%'> <b>Client Name :</b>          </td>
                                <td>".$client_name."</td>
                            </tr>
                            <tr>
                                <td> <b>Counter Party :</b>          </td>
                                <td> Curve Markets (RBS)</td>
                            </tr>
                            <tr>
                                <td> <b>Currency Pair :</b>       </td>
                                <td>".$result_pair."</td>
                            </tr>
                            <tr>
                                <td> <b>Amount :</b>              </td>
                                <td>".$notional."</td>
                            </tr>
                            <tr>
                                <td> <b>Contra Amount :</b>       </td>
                                <td>".$counter_amts."</td>                        
                            </tr>
                            <tr>
                                <td> <b>Dealt Currency :</b>      </td>
                                <td> ".$rest_pair."</td>
                            </tr>
                            <tr>
                                <td> <b>Client buys/sells :</b>   </td>
                                <td>".$buy_sell."</td>
                            </tr>
                            <tr>
                                <td> <b>Spot Rate :</b>           </td>
                                <td>".$fetch["rate"]."</td>
                            </tr>
                            <tr>
                                <td> <b>Value Date :</b>          </td>
                                <td>".$fetch["value_date"]."</td>
                            </tr>
                            <tr>
                                <td> <b>Trade Date :</b>           </td>
                                <td>".$fetch["trade_date"]."</td>
                            </tr> ".$message_fxndf." </table>";
                            
                            
                            if($fetch["contract"] == "FXOPT"){                               
                                  $message = "";
                                  $expiry = $fetch["expiry_date"];
                                  $settlement = $fetch["settle_date"]; 
                                  $callput = $fetch["spcut_cp"];
                                  $cut = $fetch["spcut"];
                                  
                                  $delta = $fetch['delta'];
                                  $delta_text = $fetch['delta_text'];  
                                  $delta_text_show = "";
                                  
                                  if($delta == "YES"){
                                    
                                        $delta_text_show = "<tr>
                                                <td> <b>Delta Instruction :</b> </td>
                                                <td>".$delta_text."</td>
                                            </tr>";
                                        
                                  }else{
                                  
                                       $delta = "No Delta; Traded Live";
                                  }
                                  
                                  $strike_d = strlen(substr(strrchr($fetch["strike"], "."), 1));        
                                  $strike =  number_format($fetch["strike"], $strike_d, '.', ',');
                                  
                                  $price_per_d = strlen(substr(strrchr($fetch["price_percentage"], "."), 1));
                                  
                                  $price_per = $price_per * 100;
                                  $price_per = number_format($fetch["price_percentage"], $price_per_d, '.', ',');
                                  $price_per = $price_per."% ".$rest_pair;   
                                                                          
                                  $premium_amount_d = strlen(substr(strrchr($fetch["premium_amount"], "."), 1));
                                  //$premium_amount =  number_format($fetch["premium_amount"], $premium_amount_d, '.', ',');
                                  
                                  $premium_amount =  number_format($fetch["premium_amount"], 2, '.', ',');
                                  
                                  if($callput == "C"){
                                      $callput_send = "Call";
                                  }else{
                                      $callput_send = "Put";
                                  }    
                                                                 
                                   $message = "                        
                                        <table width='100%'>
                                            <tr>
                                                <td width='30%'> <b>Client Name :</b>          </td>
                                                <td>".$client_name."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Counter Party :</b>          </td>
                                                <td> Curve Markets (RBS)</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Instrument :</b>          </td>
                                                <td> Vanilla Option </td>
                                            </tr>
                                            <tr>
                                                <td> <b>Currency Pair :</b>       </td>
                                                <td>".$result_pair."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Notional :</b>              </td>
                                                <td>".$notional."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Contra Amount :</b>       </td>
                                                <td>".$counter_amts."</td>                        
                                            </tr>
                                            <tr>
                                                <td> <b>Dealt Currency :</b>      </td>
                                                <td> ".$rest_pair."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Client buys/sells :</b>   </td>
                                                <td>".$buy_sell."</td>
                                            </tr>                                             
                                            <tr>
                                                <td> <b>Expiry :</b>   </td>
                                                <td>".$expiry."</td>
                                            </tr>                                              
                                            <tr>
                                                <td> <b>Delivery :</b>   </td>
                                                <td>".$settlement."</td>
                                            </tr>
                                            
                                            <tr>
                                                <td> <b>Call / Put :</b>   </td>
                                                <td>".$callput_send."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Strike :</b>   </td>
                                                <td>".$strike."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Cut :</b>   </td>
                                                <td>".$cut."</td>
                                            </tr>                                             
                                            <tr>
                                                <td> <b>Price % :</b>   </td>
                                                <td>".$price_per."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Premium Amount :</b>   </td>
                                                <td>".$premium_amount."</td>
                                            </tr>                                               
                                            <tr>
                                                <td> <b>Premium Value Date :</b>          </td>
                                                <td>".$fetch["value_date"]."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Trade Date :</b>           </td>
                                                <td>".$fetch["trade_date"]."</td>
                                            </tr> 
                                            <tr>
                                                <td> <b>Delta :</b>           </td>
                                                <td>".$delta."</td>
                                            </tr>
                                            ".$delta_text_show."
                                            </table>";
                            
                            }
                            
                            if($fetch["contract"] == "EOPT"){                               
                                  
                                  $message = "";
                                  $expiry = $fetch["expiry_date"];
                                  $settlement = $fetch["settle_date"]; 
                                  $callput = $fetch["spcut_cp"];
                                  $cut = $fetch["spcut"];
                                  
                                                                    
                                  $strike_d = strlen(substr(strrchr($fetch["strike"], "."), 1));        
                                  $strike =  number_format($fetch["strike"], $strike_d, '.', ',');
                                  
                                  $price_per_d = strlen(substr(strrchr($fetch["price_percentage"], "."), 1));
                                  
                                  $price_per = $price_per * 100;
                                  $price_per = number_format($fetch["price_percentage"], $price_per_d, '.', ',');
                                  $price_per = $price_per."% ".$rest_pair;   
                                                                          
                                  $premium_amount_d = strlen(substr(strrchr($fetch["premium_amount"], "."), 1));
                                  //$premium_amount =  number_format($fetch["premium_amount"], $premium_amount_d, '.', ',');
                                  
                                  $premium_amount =  number_format($fetch["premium_amount"], 2, '.', ',');
                                  
                                  // Barrier
                                  
                                  $opt_type = $fetch["opt_type"];                                      
                                  $exotic_option_barrier_type = $fetch["barrier_type"];
                                  $exotic_option_touch_up_down = $fetch["touch_up_down"]; 
                                  
                                  $all_opt_types = "";
                                  
                                  $exotic_option_style = $fetch["option_style"];
                                  $exotic_barrier_style = $fetch["barrier_style"];
                                  
                                  
                                  
                                     
                                 if($opt_type=="BARR"){
                                                                          
                                      $all_opt_types .= "<tr>
                                          <td> <b>Option Type :</b> </td>
                                          <td>".$exotic_option_barrier_type."</td>
                                      </tr>";
                                    	
                                      if( $exotic_option_barrier_type == "DO" || $exotic_option_barrier_type == "DI"){
                                    		      //$exotic_option_lower_barrier='white';
                                              $all_opt_types .= "<tr>
                                                  <td> <b>Lower Barrier :</b> </td>
                                                  <td>".$fetch["lower_barrier"]."</td>
                                              </tr>";
                                    	}
                                      
                                    	if($exotic_option_barrier_type=="UO" || $exotic_option_barrier_type=="UI"){                                           
                                    	   
                                    		  //$exotic_option_upper_barrier='white';
                                          $all_opt_types .= "<tr>
                                                  <td> <b>Upper Barrier :</b> </td>
                                                  <td>".$fetch["up_barrier"]."</td>
                                              </tr>";
                                      }
                                    
                                    	if($exotic_option_barrier_type=="DI" || $exotic_option_barrier_type=="UI"){
                                    		  //$exotic_option_knock_in_out="I";
                                          $all_opt_types .= "<tr>
                                                  <td> <b>Knock�in�out(I/O) :</b> </td>
                                                  <td>I</td>
                                              </tr>";
                                      }
                                      
                                    	if($exotic_option_barrier_type=="DO" || $exotic_option_barrier_type=="UO"){
                                      		//$exotic_option_knock_in_out="O";
                                          $all_opt_types .= "<tr>
                                                  <td> <b>Knock�in�out(I/O) :</b> </td>
                                                  <td>O</td>
                                              </tr>";
                                      }
                                                                                                             
                                    	//$exotic_option_knock_in_out='white';
                                    	//$option_put_call_ind='white';
                                  		//$strike='white';
                                      
                                                                        
                                }
                                
                                if($opt_type=="DBAR"){
                                  
                                    	//$exotic_option_upper_barrier='white';
                                    	//$exotic_option_lower_barrier='white';
                                      
                                      $all_opt_types .= "<tr>
                                              <td> <b>Lower Barrier :</b> </td>
                                              <td>".$fetch["lower_barrier"]."</td>
                                          </tr>";
                                          
                                      $all_opt_types .= "<tr>
                                              <td> <b>Upper Barrier :</b> </td>
                                              <td>".$fetch["up_barrier"]."</td>
                                          </tr>";
                                     
                                      $all_opt_types .= "<tr>
                                                  <td> <b>Knock�in�out(I/O) :</b> </td>
                                                  <td>".$fetch["knock_in_out"]."</td>
                                              </tr>"; 
                                      
                                    	//$exotic_option_knock_in_out='white';
                                    	
                                      //$option_put_call_ind='white';
                                    	//$strike='white';
                                }
                                	
                                if($opt_type=="MBAR"){
                                
                                    
                                    	//$exotic_option_upper_barrier='white';
                                    	//$exotic_option_lower_barrier='white';
                                    	//$exotic_option_middle_barrier='white';
                                    	//$exotic_option_knock_in_out='white';
                                      
                                      
                                      $all_opt_types .= "<tr>
                                              <td> <b>Lower Barrier :</b> </td>
                                              <td>".$fetch["lower_barrier"]."</td>
                                          </tr>";
                                          
                                      $all_opt_types .= "<tr>
                                              <td> <b>Upper Barrier :</b> </td>
                                              <td>".$fetch["up_barrier"]."</td>
                                          </tr>";
                                          
                                      $all_opt_types .= "<tr>
                                              <td> <b>Middle Barrier :</b> </td>
                                              <td>".$fetch["mid_barrier"]."</td>
                                          </tr>";
                                     
                                      $all_opt_types .= "<tr>
                                                  <td> <b>Knock�in�out(I/O) :</b> </td>
                                                  <td>".$fetch["knock_in_out"]."</td>
                                              </tr>"; 
                                      
                                    	//$option_put_call_ind='white';
                                    	//$strike='white';
                                
                                }
                                  
                              	if($opt_type=="DDIG"){                                         
                                	
                                		
                                			//$exotic_option_rebate_ccy='white';
                                			//$exotic_option_rebate_amount='white';
                                      
                                			//$exotic_option_lower_barrier='white';
                                			//$exotic_option_upper_barrier='white';
                              		   
                              				//$exotic_option_knock_in_out='white';  
                                      
                                      $all_opt_types .= "<tr>
                                              <td> <b>Rebate CCY :</b> </td>
                                              <td>".$fetch["rebate_ccy"]."</td>
                                          </tr>";
                                      
                                      $all_opt_types .= "<tr>
                                              <td> <b>Rebate Amount :</b> </td>
                                              <td>".$fetch["rebate_amt"]."</td>
                                          </tr>";
                                      
                                      $all_opt_types .= "<tr>
                                              <td> <b>Lower Barrier :</b> </td>
                                              <td>".$fetch["lower_barrier"]."</td>
                                          </tr>";
                                          
                                      $all_opt_types .= "<tr>
                                              <td> <b>Upper Barrier :</b> </td>
                                              <td>".$fetch["up_barrier"]."</td>
                                          </tr>";
                                          
                                     
                                      $all_opt_types .= "<tr>
                                                  <td> <b>Knock�in�out(I/O) :</b> </td>
                                                  <td>".$fetch["knock_in_out"]."</td>
                                              </tr>";                               
                              
                              	}
                    	
                                if($opt_type=="DIGI"){
                                  
                                  		 $all_opt_types .= "<tr>
                                              <td> <b>Rebate CCY :</b> </td>
                                              <td>".$fetch["rebate_ccy"]."</td>
                                          </tr>";
                                      
                                      $all_opt_types .= "<tr>
                                              <td> <b>Rebate Amount :</b> </td>
                                              <td>".$fetch["rebate_amt"]."</td>
                                          </tr>";
                                    
                                    	if(($exotic_option_barrier_type=="DI") || ($exotic_option_barrier_type=="DO")){
                                    		  //$exotic_option_touch_up_down="D";
                                           $all_opt_types .= "<tr>
                                              <td> <b>Touch Up Down :</b> </td>
                                              <td>D</td>
                                          </tr>";
                                      }
                                    	
                                      if(($exotic_option_barrier_type=="UI") || ($exotic_option_barrier_type=="UO")){
                                    		  //$exotic_option_touch_up_down="U";
                                          
                                          $all_opt_types .= "<tr>
                                              <td> <b>Touch Up Down :</b> </td>
                                              <td>U</td>
                                          </tr>";
                                      }
                                    
                                  		
                                      //$exotic_option_touch_up_down='white';    
                                    
                                    	if($exotic_option_touch_up_down=="U"){
                                          
                                          $all_opt_types .= "<tr>
                                                  <td> <b>Upper Barrier :</b> </td>
                                                  <td>".$fetch["up_barrier"]."</td>
                                              </tr>";
                                      }
                                    
                                    	if($exotic_option_touch_up_down=="D"){
                                        		$all_opt_types .= "<tr>
                                                  <td> <b>Lower Barrier :</b> </td>
                                                  <td>".$fetch["lower_barrier"]."</td>
                                              </tr>";
                                      }   		
                              	}
                                          
                                  
                                  $all_opt_types .= "<tr>
                                          <td> <b>Option Style :</b> </td>
                                          <td>".$exotic_option_style."</td>
                                      </tr>";
                                  
                                  $all_opt_types .= "<tr>
                                          <td> <b>Barrier Style :</b> </td>
                                          <td>".$exotic_barrier_style."</td>
                                      </tr>";
                                      
                                                                 
                                   $message = "                        
                                        <table width='100%'>
                                            <tr>
                                                <td width='30%'> <b>Client Name :</b>          </td>
                                                <td>".$client_name."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Counter Party :</b>          </td>
                                                <td> Curve Markets (RBS)</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Instrument :</b>          </td>
                                                <td> Exotic Option </td>
                                            </tr>
                                            <tr>
                                                <td> <b>Currency Pair :</b>       </td>
                                                <td>".$result_pair."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Notional :</b>              </td>
                                                <td>".$notional."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Contra Amount :</b>       </td>
                                                <td>".$counter_amts."</td>                        
                                            </tr>
                                            <tr>
                                                <td> <b>Dealt Currency :</b>      </td>
                                                <td> ".$rest_pair."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Client buys/sells :</b>   </td>
                                                <td>".$buy_sell."</td>
                                            </tr>                                             
                                            <tr>
                                                <td> <b>Expiry :</b>   </td>
                                                <td>".$expiry."</td>
                                            </tr>                                              
                                            <tr>
                                                <td> <b>Delivery :</b>   </td>
                                                <td>".$settlement."</td>
                                            </tr>                                              
                                            <tr>
                                                <td> <b>Call / Put :</b>   </td>
                                                <td>".$callput."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Strike :</b>   </td>
                                                <td>".$strike."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Cut :</b>   </td>
                                                <td>".$cut."</td>
                                            </tr>                                             
                                            <tr>
                                                <td> <b>Price % :</b>   </td>
                                                <td>".$price_per."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Premium Amount :</b>   </td>
                                                <td>".$premium_amount."</td>
                                            </tr>                                               
                                            <tr>
                                                <td> <b>Premium Value Date :</b>          </td>
                                                <td>".$fetch["value_date"]."</td>
                                            </tr>
                                            <tr>
                                                <td> <b>Trade Date :</b>           </td>
                                                <td>".$fetch["trade_date"]."</td>
                                            </tr> 
                                            
                                            <tr>
                                                <td> <b>Option Type :</b>           </td>
                                                <td>".$opt_type."</td>
                                            </tr> 
                                            ".$all_opt_types."
                                            
                                            </table>";
                            
                            }
                            
                            
                            
                      
        }                          
        
          ////EMAIL DATA /////
        
          $sql2 = "select * from email_settings";
          $result2 = $conn->query($sql2);                       
          $fetch2 = $result2->fetch_array();      
          $cc_head = "";
          
          if($client_trader != ""){                            
                    
                  $sql3 = "select * from client_trader where id = $client_trader";
                  $result3 = $conn->query($sql3);                       
                  $fetch3 = $result3->fetch_array();                    
                  
                  $email_to = $fetch3["email"]; //"craig.davis@curvemarkets.com";
                  
                  $allemail = $fetch3["email_cc"]; 
                  $client_tarder_name  = $fetch3["name"];
                  
                  $email_cc = str_replace(";", ",", $allemail); 
                    
                  if($email_cc != ""){                  
                      //$headers .= "\nCc: ".$email_cc;
                      $cc_head .= 'Cc: '.$email_cc."\r\n";                         
                  }
                  
                  if($email_to == ""){
                        echo "error_client_email";
                        exit;
                  }
          
          }else{
          
          
                   //$email_to = "craig.davis@curvemarkets.com";
                   echo "error_client_trader";
                   exit;    
          
          }
        
          //$email_cc = "";            
          
          $email_from = $fetch2['email_from']; //"fxconfirmations@curvemarkets.com"; // Who the email is from
          $email_subject =   $client_name.": ".$fetch2['client_subject']; //"Curvemarkets Trades"; // The Subject of the email
          
          $email_add_trader =  str_replace("{trader}","$client_tarder_name",$fetch2['client_body']);
          
          $email_message = nl2br($email_add_trader);
          $email_message .= "<br><br>".$message;
          $email_message .= "<br><br>".nl2br($fetch2['email_footer']);
          /*$email_message .= "<br><br><img src='http://www.curvemarkets.com/auth/admin/images/logo.jpg' width='150px' />";*/ 
          
          $email_message .= "<br><br><br><font size='2'>".nl2br($fetch2['email_disclaimer'])."</font>";          
      
          $headers = 'From: Curve Markets <'.$email_from.">\r\n";
          
          $headers .= $cc_head;
          
          $headers .= 'Content-type: text/html;charset=iso-8859-1\r\n'.
          'MIME-Version: 1.0\r\n'.
          'Reply-To: '.$email_from."\r\n" .
          'X-Mailer: PHP/' . phpversion();    
                             
          $ok = @mail($email_to, $email_subject, $email_message, $headers);        
       
          // now we just send the message
          
          //echo $email_cc;
          //exit;
          
          if($ok) {                             
            echo "sent";              
          } else {                         
            echo "error";           
          }
    
          exit;
      
}
?>   
  