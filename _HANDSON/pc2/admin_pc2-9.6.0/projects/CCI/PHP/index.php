<!DOCTYPE html>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Thu, 01 Jan 1970 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script type="text/javascript" src="jquery-1.9.1.js"></script>
<script type="text/javascript">

function textCountdown( inDate ) {
	
	var rndNum = Math.floor(Math.random() * 10000);
	now = new Date();
	y2k = new Date(inDate);
	days = (y2k - now) / 1000 / 60 / 60 / 24;
	daysRound = Math.floor(days);
	hours = (y2k - now) / 1000 / 60 / 60 - (24 * daysRound);
	hoursRound = Math.floor(hours);
	minutes = (y2k - now) / 1000 / 60 - (24 * 60 * daysRound) - (60 * hoursRound);
	minutesRound = Math.floor(minutes);
	seconds = (y2k - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound) ;
	secondsRound = Math.round(seconds);

	if ((days < 0) | (hours < 0) | (minutes < 0) | (seconds < 0)) {
		thisoutput = "Start time has passed";
		if (thisoutput == "") thisoutput = "Countdown Finished";
	} else {
		sec = (secondsRound == 1) ? " second" : " seconds";
		min = (minutesRound == 1) ? " minute, " : " minutes, ";
		hr = (hoursRound == 1) ? " hour, " : " hours, ";
		dy = (daysRound == 1) ? " day, " : " days, ";
		thisoutput = daysRound  + dy + hoursRound + hr + minutesRound + min + secondsRound + sec;
	}

	eval("document.forms.frmCountdown.countdown.value = thisoutput;");
	thisclock = "textCountdown(\""+inDate+"\");";
	window.setTimeout(thisclock, 500);
}
</script>

<script src="countdown.js" type="text/javascript"></script>

<body style="background-color:#ffd;font-family:verdana;">

<?php
	if(version_compare(phpversion(),'4.3.0')>=0) { 
	    if(!ereg('^SESS[0-9a-zA-Z]+$',$_REQUEST['SESSION_NAME'])) { 
	        $_REQUEST['SESSION_NAME']='SESS'.uniqid(''); 
	    } 
	    output_add_rewrite_var('SESSION_NAME',$_REQUEST['SESSION_NAME']); 
	    session_name($_REQUEST['SESSION_NAME']); 
	}

	session_start();

	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);	

	if(is_resource(@fsockopen('localhost', 50006))) {

	include("Java.inc");

	$server = java("ServerInterface")->getInstance();
// 	$_SESSION['cid'] = "" . new Java("java.lang.String",$server->login($_REQUEST['SESSION_NAME'], isset($_SESSION['cid']) ? $_SESSION['cid'] : ""));
	$_SESSION['contestStartTimeEpoch'] = "" . new Java("java.lang.Long",$server->getStartTimeEpoch(isset($_SESSION['cid']) ? $_SESSION['cid'] : ""));
	
	echo "<center>\n";
	if ($_SESSION['contestStartTimeEpoch'] != 0 ) {
		echo "<BR><BR><BR>\n";
		echo "Start Time: <script type=\"text/javascript\"> document.write(new Date(" . $_SESSION['contestStartTimeEpoch'] * 1000 . ").toString());</script>";
		echo "<BR><BR><BR>\n";

		$myContestStartTime = $_SESSION['contestStartTimeEpoch'];

		if (false) {
			echo "<form name='frmCountdown' action='java script:void(0);' style='margin:0'>\n";
			echo "<input type=text value='' readonly size=42 name='countdown' border-style='none' style='font-size: 24pt; color: BLACK; background-color:transparent; border-bottom: 0px solid; border-left: 0px solid;border-right: 0px solid;border-top: 0px solid'>\n";
			echo "<script type='text/javascript'>\n";
		
			echo "var startTime=\"" . $_SESSION['contestStartTime'] . "\";\n";
		
			echo "textCountdown(startTime);\n";
			echo "</script>\n";
			echo "</form>\n";
		} else {
			echo "<script type=\"application/javascript\">\n";
			date_default_timezone_set("UTC");
			echo "var myCountdown1 = new Countdown({\n";
			// echo " 	time: 86400 * 3, // 86400 seconds = 1 day\n";
			echo "year	: " . date("Y",$myContestStartTime) . ", \n";
			echo "month	: " . date("n",$myContestStartTime) . ", \n";
			echo "day	: " . date("j",$myContestStartTime) . ", \n";
			echo "hour	: " . date("H",$myContestStartTime) . ", \n";
			echo "minute	: " . date("i",$myContestStartTime) . ", \n";
			echo "second	: " . date("s",$myContestStartTime) . ", \n";
			echo "offset	: new Date().getTimezoneOffset()/-60,\n";
			echo "	width:900,\n ";
			echo "	height:180, \n";
			echo " interval : 300,\n";
			echo "	rangeHi:\"day\",\n";
			echo "	style:\"flip\"\n";
			echo "	});\n";
			echo "</script>\n";
		}

	} else {
		echo "<BR><BR><BR>\n";
		echo "Check back in a bit :) ";
	}
	echo "</center>\n";
	} else	{
		$_SESSION['error'] = "Java bridge could not be established! Contact your site administrator.";
		printf("<BR><h3>");
		printf("<font style='font-family:verdana;' color=#ff0000>");
		printf("Ensure JavaBridge is running on port 50006, could not connect to anything<br>");
		printf("</font>");
		printf("</h3>");
	}
	echo "<form name=startTimes action=index.php method=POST>";
	echo "	<input textbox type=hidden id=lastStartTime>";
	echo "	<input textbox type=hidden id=currentStartTime>";
	echo "</form>";
?>
<script type="text/javascript">
setInterval('CheckStartTime()',1000);
function reCheckStartTime() {
	if (document.getElementById("lastStartTime").value != document.getElementById("currentStartTime").value) {
		if (document.getElementById("lastStartTime").value == "" ){
			document.getElementById("lastStartTime").value = document.getElementById("currentStartTime").value
			// console.log("firstTime don't reload");
		} else {
			document.getElementById("lastStartTime").value = document.getElementById("currentStartTime").value
			parent.window.location.reload();
		}
	}
}

function CheckStartTime() { 
  var cst

  $.ajax({
  type: 'POST',
  url: 'iCheckStartTime.php',
  data: 'SESSION_NAME=<?php echo session_name();  ?>',
  dataType: 'json',
  cache: false,
  success: function(result) {
	  document.getElementById("currentStartTime").value = result.currentStartTime;
	  reCheckStartTime();
//	iframe.contentWindow.location.reload(true)
  },
  error: function(jqXHR, exception) {
            if (jqXHR.status === 0) {
                console.log('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                console.log('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                console.log('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                console.log('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                console.log('Time out error.');
            } else if (exception === 'abort') {
                console.log('Ajax request aborted.');
            } else {
                console.log('Uncaught Error.\n' + jqXHR.responseText);
            }
        }
  });
	
}
</script>

</body>

