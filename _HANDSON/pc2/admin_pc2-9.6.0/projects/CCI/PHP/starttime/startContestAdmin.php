<!DOCTYPE html>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Thu, 01 Jan 1970 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />


<body style="background-color: #ffd; font-family: verdana;">

<?php
if (version_compare ( phpversion (), '4.3.0' ) >= 0) {
	if (! ereg ( '^SESS[0-9a-zA-Z]+$', $_REQUEST ['SESSION_NAME'] )) {
		$_REQUEST ['SESSION_NAME'] = 'SESS' . uniqid ( '' );
	}
	output_add_rewrite_var ( 'SESSION_NAME', $_REQUEST ['SESSION_NAME'] );
	session_name ( $_REQUEST ['SESSION_NAME'] );
}

session_start ();

ini_set ( 'display_errors', 'On' );
error_reporting ( E_ALL | E_STRICT );

	if ($_SERVER ["REQUEST_METHOD"] == "PUT") {
		try {
			
//			$_SESSION ['cid'] = "" . new Java ( "java.lang.String", $server->login ( $_REQUEST ['SESSION_NAME'], isset ( $_SESSION ['cid'] ) ? $_SESSION ['cid'] : "" ) );

			$inString = urldecode(@file_get_contents('php://input'));
			$obj =  json_decode($inString);

			if (is_null($obj) || !array_key_exists('starttime', $obj) ) {
				echo "invalid: '" . $inString . "'";
			} else if ($obj->{'starttime'} == 'undefined') {
				echo "stopping contest";
			} else {
				echo "starting @ " . $obj->{'starttime'};
			}
			
		} catch ( JavaException $exception ) {
			echo "Cause: " . $exception->getCause () . "\n";
			echo "Message: " . $exception->getMessage () . "\n";
		}
	} elseif ($_SERVER ["REQUEST_METHOD"] == "POST") {
		$data = array("starttime" => $_POST['starttime']);                                                                    
		$data_string = json_encode($data);                                                                                   
 
		$ch = curl_init('http://novo/cci/starttime/index.php');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
 
		$result = curl_exec($ch);
		echo "The answer is: '" . $result . "'";
	} elseif ($_SERVER ["REQUEST_METHOD"] == "GET") {
		echo "<form name='myform' method=post>";
		echo "<input type=text name=starttime>";
		echo "<input type=submit>";
		echo "</form>";
	}
?>



</body>

