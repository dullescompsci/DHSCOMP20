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

if (is_resource ( @fsockopen ( 'localhost', 50006 ) )) {
	
	include ("Java.inc");
	
	$server = java ( "ServerInterface" )->getInstance ();
	
	if ($_SERVER ["REQUEST_METHOD"] == "PUT") {
		echo "PUT";
		try {
			
			$_SESSION ['cid'] = "" . new Java ( "java.lang.String", $server->login ( $_REQUEST ['SESSION_NAME'], isset ( $_SESSION ['cid'] ) ? $_SESSION ['cid'] : "" ) );

			$inString = urldecode(@file_get_contents('php://input'));
			$obj =  json_decode($inString);

			if (is_null($obj) || !array_key_exists('starttime', $obj) ) {
				echo "invalid: '" . $inString . "'";
			} else if ($obj->{'starttime'} == 'undefined') {
				echo "stopping contest";
				$server->setStartTime(0, $_SESSION['cid']);
			} else {
				echo "starting @ " . $obj->{'starttime'};
				$server->setStartTime(intval(round($obj->{'starttime'})), $_SESSION['cid']);
			}
			
		} catch ( JavaException $exception ) {
			echo "Cause: " . $exception->getCause () . "\n";
			echo "Message: " . $exception->getMessage () . "\n";
		}
	} elseif ($_SERVER ["REQUEST_METHOD"] == "POST") {
		echo "POST";
		try {
			
			$_SESSION ['cid'] = "" . new Java ( "java.lang.String", $server->login ( $_REQUEST ['SESSION_NAME'], isset ( $_SESSION ['cid'] ) ? $_SESSION ['cid'] : "" ) );

			$inString = urldecode(@file_get_contents('php://input'));
			$obj =  json_decode($inString);

			if (is_null($obj) || !array_key_exists('starttime', $obj) ) {
				echo "invalid: '" . $inString . "'";
			} else if ($obj->{'starttime'} == 'undefined') {
				echo "stopping contest";
				$server->setStartTime(0, $_SESSION['cid']);
			} else {
				echo "starting @ " . $obj->{'starttime'};
				$server->setStartTime(intval(round($obj->{'starttime'})), $_SESSION['cid']);
			}
			
		} catch ( JavaException $exception ) {
			echo "Cause: " . $exception->getCause () . "\n";
			echo "Message: " . $exception->getMessage () . "\n";
		}
	} elseif ($_SERVER ["REQUEST_METHOD"] == "GET") {
		echo "Bugger Off";
	}
} else {
	$_SESSION ['error'] = "Java bridge could not be established! Contact your site administrator.";
	printf ( "<BR><h3>" );
	printf ( "<font style='font-family:verdana;' color=#ff0000>" );
	printf ( "Ensure JavaBridge is running on port 50006, could not connect to anything<br>" );
	printf ( "</font>" );
	printf ( "</h3>" );
}
?>



</body>

