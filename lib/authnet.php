<?php
// http://www.php.net/manual/en/class.httprequest.php
//require_once( 'HTTP/Request.php');
/*
// EXAMPLE USAGE

$config = array(
       'auth_net_login_id' => '24vMp4BT8tZk',
       'auth_net_tran_key' => '2f2gk84t37KpGF3u',
       'auth_net_url'  => 'https://secure.authorize.net/gateway/transact.dll',
       'test_mode' => 'TRUE'
);

$donation_record = array(
       'First_Name' => 'Testy',
       'Last_Name' => 'McTest',
       'Company' => 'Goggle Inc',
       'Email' => 'testy@testing.com',
       'Phone' => '123-456-7890',
       'Street' => '142 Highland Ave',
       'City' => 'San Francisco',
       'State' => 'CA',
       'Zip' => '94110',
       'cc_number' => '370000000000002',
       'cc_month' => '04',
       'cc_year' => '2011',
       'amount' => '30.50',
       'ccv' => '123',
       'cc_type' => 'Visa',
       'other_amount' => '',
       'recurring_donation' => false
);

$proccessor = new AuthorizeNet_Donation( $config);

$proccessor->save( $donation_record );

// show error messages
echo '<h1>Error Messages</h1>';
echo Flash::dump_errors();

// some useful feedback info for testing
echo '<h1>Debug Info</h1>';
echo $proccessor->debug_html;
*/


// Authorize.net DONATION PROCCESSOR

class AuthorizeNet_Donation {

       function __construct( $config = array() ) {
       // make sure required configurations are present
               $required_options = array('auth_net_login_id','auth_net_tran_key','auth_net_url');
               foreach($required_options as $required_option){
                       if(empty($config[$required_option])){
                               trigger_error( 'Missing required configuration: '.$required_option, E_USER_ERROR);
                       }
               }
               
               $this->auth_net_login_id = $config['auth_net_login_id'];
               $this->auth_net_tran_key = $config['auth_net_tran_key'];
               $this->auth_net_url     = $config['auth_net_url'];
               
               // Set the testing flag so that transactions are not live
               // possible values are "TRUE" and "FALSE"              
               if( empty($config['test_mode'])){
                       $config['test_mode'] = 'TRUE';
                       trigger_error('test_mode not set, setting to TRUE by default');
               }      
               $this->test_mode        = $config['test_mode'];
       }

       function save ( $data ) {
               $response = $this->sendPayment($data);

               // TODO: just a temporary replacement for our system's flash message
               // y'all at carrotmob should tear this out and use your own error messaging
               


               // Returns string if response is not of type array
               if ( !is_array($response)) {
                       Flash::add_error($response);
                       return false;
               }

               if ($response['code'] == 1){
                       return true;
               }

               if (!$response['text']){
                       $response = array('code'=>'3','text'=>'Undefined Error.  Your card has not been charged.  Please check the information you entered and try again, or contact us directly to resolve.');
               }      

               if ($response['code'] == 3){
                       Flash::add_error('Error Proccessing: '.$response['text']);
                       return false;
               }
               
               if ($response['reason_code'] == 2){
                       Flash::add_error($response['text'].'  Please check that your Credit Card number, expiration date, and CCV number are correct and try again.  If you continue to experice problems, please contact us directly or try another donation method.');
                       return false;
               }

               Flash::add_error($response['text']);
               
               return false;
       }

       function sendPayment( $data ) {
               
               $data['auth_net_login_id']      = $this->auth_net_login_id;
               $data['auth_net_tran_key']      = $this->auth_net_tran_key;
               $data['auth_net_url']           = $this->auth_net_url;

               $data['project_name'] = "Carrotmob";
               $data['project_id'] = '5040';
                       

               $exp_date = $data['cc_month'].'/'.$data['cc_year'];
               $data['exp_date'] = $exp_date;

               $amount = $data['amount'];
               if ($amount == 'other'){
                       $amount = trim($data['other_amount']," $\t");
                       $amount = number_format($amount, 2, '.','');
               }
               if ($amount == '' || $amount == 0){
                       $response = array('code'=>'3','text'=>'You must enter an amout');
                       return $response;
               }
               $data['amount'] = $amount;
               
               if ($data['recurring_donation']){
                       return $this->executeRecurringTransaction($data);
               } else {
                       return $this->executeOneTimeTransaction($data);
               }
       }

       function executeOneTimeTransaction($data){
               //Values to be sent to AIM API
               $authnet_values = array(
                       "x_login"                               => $data['auth_net_login_id'],
                       "x_version"                             => "3.1",
                       "x_delim_char"                  => "|",
                       "x_delim_data"                  => "TRUE",
                       "x_type"                                => "AUTH_CAPTURE",
                       "x_method"                              => "CC",
                       "x_tran_key"                    => $data['auth_net_tran_key'],
                       "x_relay_response"              => "FALSE",
                       "x_card_num"                    => $data['cc_number'],
                       "x_card_code"                   => $data['ccv'],
                       "x_exp_date"                    => $data['exp_date'],
                       "x_description"                 => "Donation: ".$data['project_name'],
                       "x_amount"                              => $data['amount'],
                       "x_first_name"                  => $data['First_Name'],
                       "x_last_name"                   => $data['Last_Name'],
                       "x_phone"                               => $data['Phone'],
                       "x_email"                               => $data['Email'],
                       "x_email_customer"              => "TRUE",
                       "x_address"                             => $data['Street'],
                       "x_city"                                => $data['City'],
                       "x_state"                               => $data['State'],
                       "x_zip"                                 => $data['Zip'],
                       "x_company"                             => $data['Company'],
                       "x_invoice_num"                 => $data['project_id'],
                       "x_test_request"                => $this->test_mode,
               );

               var_dump($authnet_values);

               //Encode for transfer
               $fields = "";
               foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";


               $ch = curl_init($data['auth_net_url']);
               curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
               curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
               ### curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
               $resp = curl_exec($ch); //execute post and get results
               curl_close ($ch);

               ///////////////////////////////////////////////////////////

               $text = $resp;
               $h = substr_count($text, "|");
               $h++;

               # $html can be used for debugging transactions, currently does not get output anywhere
               $html = '';

               # $response returns the response code, and error message if there is one
               # Next line is default response code
               $response = array('code'=>'3','text'=>'Undefined Error.  Your card has not been charged.  Please check the information you entered and try again, or contact us directly to resolve.');

               for($j=1; $j <= $h; $j++){

                       $p = strpos($text, "|");

                       if ($p === false) { // note: three equal signs
                               $html .= "$j:$text";    
                       }else{

                               $p++;

                               //  We found the x_delim_char and accounted for it . . . now do something with it

                               //  get one portion of the response at a time
                               $pstr = substr($text, 0, $p);

                               //  this prepares the text and returns one value of the submitted
                               //  and processed name/value pairs at a time
                               //  for AIM-specific interpretations of the responses
                               //  please consult the AIM Guide and look up
                               //  the section called Gateway Response API
                               $pstr_trimmed = substr($pstr, 0, -1); // removes "|" at the end

                               if($pstr_trimmed==""){
                                       $pstr_trimmed="NO VALUE RETURNED";
                               }

                               switch($j){

                                       case 1:
                                               $html.= "Response Code: ";

                                               $fval="";
                                               if($pstr_trimmed=="1"){
                                                       $fval="Approved";
                                               }elseif($pstr_trimmed=="2"){
                                                       $fval="Declined";
                                               }elseif($pstr_trimmed=="3"){
                                                       $fval="Error";
                                               }

                                               $response['code'] = $pstr_trimmed;
                                               
                                               $html.= $fval;
                                               $html.= "<br>";
                                               break;

                                       case 2:
                                               $html.= "Response Subcode: ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 3:
                                               $html.= "Response Reason Code: ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                       
                                               $response['reason_code'] = $pstr_trimmed;
                                               break;

                                       case 4:
                                               $html.= "Response Reason Text: ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               
                                               $response['text'] = $pstr_trimmed;
                                               break;

                                       case 5:
                                               $html.= "Approval Code: ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 6:
                                               $html.= "AVS Result Code: ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 7:
                                               $html.= "Transaction ID: ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 8:
                                               $html.= "Invoice Number (x_invoice_num): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 9:
                                               $html.= "Description (x_description): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 10:
                                               $html.= "Amount (x_amount): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 11:
                                               $html.= "Method (x_method): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 12:
                                               $html.= "Transaction Type (x_type): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 13:
                                               $html.= "Customer ID (x_cust_id): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 14:
                                               $html.= "Cardholder First Name (x_first_name): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 15:
                                               $html.= "Cardholder Last Name (x_last_name): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 16:
                                               $html.= "Company (x_company): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 17:
                                               $html.= "Billing Address (x_address): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 18:
                                               $html.= "City (x_city): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 19:
                                               $html.= "State (x_state): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 20:
                                               $html.= "ZIP (x_zip): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 21:
                                               $html.= "Country (x_country): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 22:
                                               $html.= "Phone (x_phone): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 23:
                                               $html.= "Fax (x_fax): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 24:
                                               $html.= "E-Mail Address (x_email): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 25:
                                               $html.= "Ship to First Name (x_ship_to_first_name): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 26:
                                               $html.= "Ship to Last Name (x_ship_to_last_name): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 27:
                                               $html.= "Ship to Company (x_ship_to_company): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 28:
                                               $html.= "Ship to Address (x_ship_to_address): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 29:
                                               $html.= "Ship to City (x_ship_to_city): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 30:
                                               $html.= "Ship to State (x_ship_to_state): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 31:
                                               $html.= "Ship to ZIP (x_ship_to_zip): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 32:
                                               $html.= "Ship to Country (x_ship_to_country): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 33:
                                               $html.= "Tax Amount (x_tax): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 34:
                                               $html.= "Duty Amount (x_duty): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 35:
                                               $html.= "Freight Amount (x_freight): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 36:
                                               $html.= "Tax Exempt Flag (x_tax_exempt): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 37:
                                               $html.= "PO Number (x_po_num): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 38:
                                               $html.= "MD5 Hash: ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       case 39:
                                               $html.= "Card Code Response: ";
                                               $fval="";
                                               if($pstr_trimmed=="M"){
                                                       $fval="M = Match";
                                               }elseif($pstr_trimmed=="N"){
                                                       $fval="N = No Match";
                                               }elseif($pstr_trimmed=="P"){
                                                       $fval="P = Not Processed";
                                               }elseif($pstr_trimmed=="S"){
                                                       $fval="S = Should have been present";
                                               }elseif($pstr_trimmed=="U"){
                                                       $fval="U = Issuer unable to process request";
                                               }else{
                                                       $fval="NO VALUE RETURNED";
                                               }

                                               $html.= $fval;
                                               $html.= "<br>";
                                               break;

                                       case 68:
                                               $html.= "Reserved (".$j."): ";
                                               $html.= $pstr_trimmed;
                                               $html.= "<br>";
                                               break;

                                       default:

                                               if($j>=69){

                                                       $html.= "Merchant-defined (".$j."): ";
                                                       $html.= $pstr_trimmed;
                                                       $html.= "<br>";

                                               } else {

                                                       $html.= $j;
                                                       $html.= ": ";
                                                       $html.= $pstr_trimmed;
                                                       $html.= "<br>";

                                               }

                                               break;

                               }

                               // remove the part that we identified and work with the rest of the string
                               $text = substr($text, $p);

                       }

               }
               $this->debug_html =  $html;
               
               return $response;
       }

       function executeRecurringTransaction($data){
               
               $host = "api.authorize.net";
               $path = "/xml/v1/request.api";
               
               //define variables to send
               $loginname= $data['auth_net_login_id'];
               $transactionkey= $data['auth_net_tran_key'];
               $amount = $data["amount"];
//              $refId = $data["refId"];
               $name = $data["name"];
               $length = 1;
               $unit = "months";
               $startDate = Date("Y-m-d");
               $totalOccurrences = 9999;
               $trialOccurrences = 0;
               $trialAmount = $data['amount'];
               $cardNumber = $data["cc_number"];
               $expirationDate = $data["exp_date"];
               $firstName = $data["First_Name"];
               $lastName = $data["Last_Name"];
               $address = $data["Street"];
               $email = $data["Email"];
               $phone = $data["Phone"];
               $city = $data['City'];
               $state = $data['State'];
               $zip = $data['Zip'];
               $company = $data['Company'];
               $invoiceNumber = $data['project_id'];
               $description = "Recurring Donation: ".$data['project_name'];
               $html .=  "Results <br><br>";
               
               //build xml to post
               $content =
                               "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                               "<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
                               "<merchantAuthentication>".
                               "<name>" . $loginname . "</name>".
                               "<transactionKey>" . $transactionkey . "</transactionKey>".
                               "</merchantAuthentication>".
       //                      "<refId>" . $refId . "</refId>".
                               "<subscription>".
                               "<name>" . $name . "</name>".
                               "<paymentSchedule>".
                               "<interval>".
                               "<length>". $length ."</length>".
                               "<unit>". $unit ."</unit>".
                               "</interval>".
                               "<startDate>" . $startDate . "</startDate>".
                               "<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
       //                      "<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
                               "</paymentSchedule>".
                               "<amount>". $amount ."</amount>".
       //                      "<trialAmount>" . $trialAmount . "</trialAmount>".
                               "<payment>".
                               "<creditCard>".
                               "<cardNumber>" . $cardNumber . "</cardNumber>".
                               "<expirationDate>" . $expirationDate . "</expirationDate>".
                               "</creditCard>".
                               "</payment>".
                               "<order>".
                               "<invoiceNumber>".$invoiceNumber."</invoiceNumber>".
                               "<description>".$description."</description>".
                               "</order>".
                               "<customer>".
                               "<email>".$email."</email>".
                               "<phoneNumber>".$phone."</phoneNumber>".
                               "</customer>".
                               "<billTo>".
                               "<firstName>". $firstName . "</firstName>".
                               "<lastName>" . $lastName . "</lastName>".
                               "<company>". $company ."</company>".
                               "<address>".$address."</address>".
                               "<city>".$city."</city>".
                               "<state>".$state."</state>".
                               "<zip>".$zip."</zip>".
                               "</billTo>".
                               "</subscription>".
                               "</ARBCreateSubscriptionRequest>";

               //send the xml via curl
               $response = $this->send_request_via_curl($host,$path,$content);
               //if curl is unavilable you can try using fsockopen
               /*
               $response = send_request_via_fsockopen($host,$path,$content);
               */


               //if the connection and send worked $response holds the return from Authorize.net
               if ($response)
               {
                               /*
                       a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
                       please explore using SimpleXML in php 5 or xml parsing functions using the expat library
                       in php 4
                       parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
                       */
                       list ($refId, $resultCode, $code, $text, $subscriptionId) = $this->parse_return($response);

                       if ($resultCode == 'Ok'){
                               $message = array();
                               $message['code'] = 1;
                       } else {
                               $message = array();
                               $message['code'] = 3;
                               $message['text'] = $text;
                       }


                       $html .=  " Response Code: $resultCode <br>";
                       $html .=  " Response Reason Code: $code<br>";
                       $html .=  " Response Text: $text<br>";
                       $html .=  " Reference Id: $refId<br>";
                       $html .=  " Subscription Id: $subscriptionId <br><br>";
                       $html .=  " Data has been written to data.log<br><br>";
                       $html .=  $loginname;
                       $html .=  "<br />";
                       $html .=  $transactionkey;
                       $html .=  "<br />";
               
                       $html .=  "amount:";
                       $html .=  $amount;
                       $html .=  "<br \>";
                       
                       $html .=  "refId:";
                       $html .=  $refId;
                       $html .=  "<br \>";
                       
                       $html .=  "name:";
                       $html .=  $name;
                       $html .=  "<br \>";
                       
                       $html .=  "amount: ";
                       $html .=  $HTTP_POST_VARS[amount];
                       $html .=  "<br \>";
                       $html .=  "<br \>";
                       $html .=  $content;
                       $html .=  "<br \>";
                       $html .=  "<br \>";

                       $this->debug_html =  $html;
                       return $message;
               }
               else
               {
                       $html .=  "Transaction Failed. <br>";
                       $this->debug_html =  $html;

                       $message = array();
                       $message['code'] = 3;
                       $message['text'] = $text;
                       return $message;
               }
               
               $this->debug_html =  $html;
       }

       //function to send xml request via curl
       function send_request_via_curl($host,$path,$content)
       {
               $posturl = "https://" . $host . $path;
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $posturl);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
               curl_setopt($ch, CURLOPT_HEADER, 1);
               curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
               $response = curl_exec($ch);
               return $response;
       }

       //function to parse Authorize.net response
       function parse_return($content)
       {
               $refId = $this->substring_between($content,'<refId>','</refId>');
               $resultCode = $this->substring_between($content,'<resultCode>','</resultCode>');
               $code = $this->substring_between($content,'<code>','</code>');
               $text = $this->substring_between($content,'<text>','</text>');
               $subscriptionId = $this->substring_between($content,'<subscriptionId>','</subscriptionId>');
               return array ($refId, $resultCode, $code, $text, $subscriptionId);
       }

       //helper function for parsing response
       function substring_between($haystack,$start,$end)
       {
               if (strpos($haystack,$start) === false || strpos($haystack,$end) === false)
               {
                       return false;
               }
               else
               {
                       $start_position = strpos($haystack,$start)+strlen($start);
                       $end_position = strpos($haystack,$end);
                       return substr($haystack,$start_position,$end_position-$start_position);
               }
       }
}


// a temporary replacement for our system's flash message
abstract class Flash{

         private static $errors = array();

   public static function add_error($msg){
       self::$errors[] = $msg;
   }

   public static function dump_errors(){
                       $html = '';
       foreach( self::$errors as $error_msg){
               $html .= "<div class='error-msg'>$error_msg</div>";
       }
       return $html;
   }

}
