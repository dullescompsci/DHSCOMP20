<!DOCTYPE html>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Thu, 01 Jan 1970 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<script>
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

	if($_SERVER["REQUEST_METHOD"] == "POST") {
				try {

					$_SESSION['cid'] = "" . new Java("java.lang.String",$server->login($_REQUEST['SESSION_NAME'], isset($_SESSION['cid']) ? $_SESSION['cid'] : ""));
					$server->setStartTime($_POST['startTime'], $_SESSION['cid']);
					
					if($_POST['startTime'] == 0) {
						printf('Countdown STOPPED');
					} elseif($_POST['startTime'] > 0) {
						$_SESSION['contestStartTime'] = "" . new Java("java.lang.Long",$server->getStartTimeEpoch(isset($_SESSION['cid']) ? $_SESSION['cid'] : ""));
						$myContestStartTime = $_SESSION['contestStartTime'];
						

						echo "Countdown Started, Start Time: <script type=\"text/javascript\"> document.write(new Date(" . $_SESSION['contestStartTime'] * 1000 . ").toString());</script>";
						echo "<BR><BR><BR>\n";


						if (false) {
							echo "<form name='frmCountdown' action='java script:void(0);' style='margin:0'>\n";
							echo "<input type=text value='' readonly size=42 name='countdown' border-style='none' style='font-size: 24pt; color: BLACK; background-color:transparent; border-bottom: 0px solid; border-left: 0px solid;border-right: 0px solid;border-top: 0px solid'>\n";
							echo "<script type='text/javascript'>\n";
						
							echo "var startTime=\"" . $_POST['dateDisplay'] . "\";\n";
						
							echo "textCountdown(startTime);\n";
							echo "</script>\n";
							echo "</form>\n";
						} else {
							echo "<script type=\"application/javascript\">\n";
							echo "var myCountdown1 = new Countdown({\n";
							date_default_timezone_set("UTC");
							// echo " 	time: 86400 * 3, // 86400 seconds = 1 day\n";
							echo "year	: " . date("Y",$myContestStartTime) . ", \n";
							echo "month	: " . date("n",$myContestStartTime) . ", \n";
							echo "day	: " . date("j",$myContestStartTime) . ", \n";
							echo "hour	: " . date("H",$myContestStartTime) . ", \n";
							echo "minute	: " . date("i",$myContestStartTime) . ", \n";
							echo "second	: " . date("s",$myContestStartTime) . ", \n";
							echo "offset	: new Date().getTimezoneOffset()/-60,\n";
							echo "	width:300,\n ";
							echo "	height:60, \n";
							echo " interval : 300,\n";
							echo "	rangeHi:\"day\",\n";
							echo "	style:\"flip\"\n";
							echo "	});\n";
							echo "</script>\n";
						}
					} elseif($_POST['startTime'] == -1) {
						echo 'Stopped Contest clock';
					} elseif($_POST['startTime'] == -2) {
						echo 'Started Contest clock';
					} else {
						echo "nothing;";
					}

					

				} catch (JavaException $exception) { 
						echo "Cause: ".$exception->getCause()."\n";
						echo "Message: ".$exception->getMessage()."\n";
				}

		} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
		   $_SESSION['contestStartTime'] = "" . new Java("java.lang.Long",$server->getStartTimeEpoch(isset($_SESSION['cid']) ? $_SESSION['cid'] : ""));

		   if($_SESSION['contestStartTime'] != 0) {
			$myContestStartTime = $_SESSION['contestStartTime'];

			echo "Countdown Started, Start Time: <script type=\"text/javascript\"> document.write(new Date(" . $_SESSION['contestStartTime'] * 1000 . ").toString());</script>";
			echo "<BR><BR><BR>\n";

			echo "<script type=\"application/javascript\">\n";
			echo "var myCountdown1 = new Countdown({\n";
			date_default_timezone_set("UTC");
			// echo " 	time: 86400 * 3, // 86400 seconds = 1 day\n";
			echo "year	: " . date("Y",$myContestStartTime) . ", \n";
			echo "month	: " . date("n",$myContestStartTime) . ", \n";
			echo "day	: " . date("j",$myContestStartTime) . ", \n";
			echo "hour	: " . date("H",$myContestStartTime) . ", \n";
			echo "minute	: " . date("i",$myContestStartTime) . ", \n";
			echo "second	: " . date("s",$myContestStartTime) . ", \n";
			echo "offset	: new Date().getTimezoneOffset()/-60,\n";
			echo "	width:300,\n ";
			echo "	height:60, \n";
			echo " interval : 300,\n";
			echo "	rangeHi:\"day\",\n";
			echo "	style:\"flip\"\n";
			echo "	});\n";
			echo "</script>\n";
		   } else {
			   echo "Start Time not set!";
		   }
		}
	} else	{
		$_SESSION['error'] = "Java bridge could not be established! Contact your site administrator.";
		printf("<BR><h3>");
		printf("<font style='font-family:verdana;' color=#ff0000>");
		printf("Ensure JavaBridge is running on port 50006, could not connect to anything<br>");
		printf("</font>");
		printf("</h3>");
	}
?>


<body style="background-color:#ffd;font-family:verdana;">
<br>
<br>

<form name="ivnForm" onsubmit="return false" style="margin:0;">

<table style="width:600px;border:1px black solid;border-left:0;border-right:0;background-color:#ffd;">
  <tr>
    <td class="content" nowrap>Select a Time:</td>
    <td width="100">
      <select name="month" accesskey="1"
        onchange="if(window.getDays) window.getDays(this,this.form.day,this.form.year)" 
      >
      <option value="0">January</option>
      <option value="1">February</option>
      <option value="2">March</option>
      <option value="3">April</option>
      <option value="4">May</option>
      <option value="5">June</option>
      <option value="6">July</option>
      <option value="7">August</option>
      <option value="8">September</option>
      <option value="9">October</option>
      <option value="10">November</option>
      <option value="11">December</option>
      </select>
    </td>
    <td width="50">
      <select name="day" ></select>
    </td>
    <td width="40">
      <input type="text" name="year" maxlength="4" 
        onchange="getDays(this.form.month,this.form.day,this.form.year)"
        value="" style="width:50px;"
      >
    </td>
    <td width="200" nowrap>&nbsp;&nbsp;
      <script type="text/javascript">
      var html = '<select name="hour">'
      for(var i=0; i<24; i++){ html+='<option value="'+i+'">'+i }
      html += '</select>:<select name="minute">'
      for(var i=0; i<=59; i++){ html+='<option value="'+i+'">'+i }
      html += '</select>:<select name="second">'
      for(var i=0; i<=59; i++){ html+='<option value="'+i+'">'+i }
      document.write(html)
      </script>
    </td>
  </tr>
  <tr>
    <td align="right" width="100%" colspan="4">
      <!--button accesskey="u" style="width:200px;"
        onclick="populateDates();"
      >Update current Time</button -->
    </td>
    <td align="right" width="100%" colspan="5">
      <button accesskey="c" style="width:90px;"
        onclick="toEpoch(this.form.month,this.form.day,this.form.year,this.form.hour,this.form.minute,this.form.second)"
      >Set Start Time</button>
    </td>
  </tr>
</table>


<!-- p><input type="checkbox" name="GMT" accesskey="g" onchange="populateDates();"> <u>G</u>MT (if unchecked, it uses your local time without attempting the offset.) -->
</form>

<form method=post name=cci_input onsubmit='return validateStartTime()' action=admin.php>
<h4>
<br><br>
<table>
<tr><td><strong>Start Time:</strong></td>
<td><input readonly type=text size=66 name=dateDisplay value=></td>
</tr>
<tr><td><font size=-3>Epoch:</font></td>
<td><input type=text name=startTime value=></td>
</tr>
<tr><td><br></td></tr>
<tr>
<td align=center><input type=Submit value='Start Countdown'></td>
<td align=center><input type=button value='Stop Countdown' onclick='startTime.value=0;submit();'></td>
</tr>
<!-- tr>
<td align=center><input type=button value='Start Contest' onclick='startTime.value=-2;submit();'></td>
<td align=center><input type=button value='Stop Contest' onclick='startTime.value=-1;submit();'></td>
</tr -->
</table>
</h4>
</form>

<script type="text/javascript">

if(!window.dDate) window.dDate = new Date()


window.getEpoch = function(){
  // var GMT = document.ivnForm.GMT.checked
  var GMT = false;
  if(GMT){ 
    var x = parseInt(Date.UTC(dDate.getUTCFullYear(),dDate.getUTCMonth(),dDate.getUTCDate(),dDate.getUTCHours(),dDate.getUTCMinutes(),dDate.getUTCSeconds(),dDate.getUTCMilliseconds())/1000);
    return x;
  } else {
    var x = (dDate.getTime()-dDate.getMilliseconds())/1000;
//    x += dDate.getTimezoneOffset();
    return x;
  }
}



window.getDays = function(mObj,dObj,yObj){
  // build array of days in a select container based on selected month and year
  iMonth=parseInt(mObj.options[mObj.selectedIndex].value)+1
  iYear=(yObj.value?yObj.value:1900);

  var iDays=31;
  switch(iMonth){ /* determine the number of days this month including leap years */
    case 4: case 6: case 9: case 11:  --iDays; break;
    case 2: iDays=29; if (!((iYear%4==0)&&(iYear%100!= 0))||(iYear%400== 0)) --iDays;
  }

  dObj.options.length = 0;
  for(var i=0; i<iDays; i++){
    dObj.options[i] = new Option(i+1,i+1)
  }
}




window.toDate = function(eObj){
  var mEpoch = parseInt(eObj.value); 
  if(mEpoch<10000000000) mEpoch *= 1000; // convert to milliseconds (Epoch is usually expressed in seconds, but Javascript uses Milliseconds)

  dDate.setTime(mEpoch)
  return dDate;
}


window.toEpoch = function(mObj,dObj,yObj,hrObj,minObj,secObj){
  var month = mObj.options[mObj.selectedIndex].value
  var day = dObj.options[dObj.selectedIndex].value
  var year = yObj.value
  var hour = hrObj.options[hrObj.selectedIndex].value
  var minute = minObj.options[minObj.selectedIndex].value
  var second = secObj.options[secObj.selectedIndex].value

  //alert(month+']['+day+']['+year)
  dDate.setMonth(month,day)
  dDate.setFullYear(year)
  dDate.setHours(hour,minute,second)
  //alert(dDate)

  var fObj= document.forms.cci_input
  fObj.startTime.value = window.getEpoch()
  fObj.dateDisplay.value = toDate(fObj.startTime)

  if(window && window.clipboardData && window.clipboardData.setData)
    bResult = window.clipboardData.setData("Text",zObj.innerHTML); //stuff the text onto the clipboard
  
}

function populateDates(){
  var fobj = document.forms.ivnForm
  var fobj2 = document.forms.cci_input
  // if(fobj.GMT.checked){
  if(false){
    // GMT TIME
    window.dDate = new Date(Date.UTC(dDate.getUTCFullYear(),dDate.getUTCMonth(),dDate.getUTCDate(),dDate.getUTCHours(),dDate.getUTCMinutes(),dDate.getUTCSeconds(),dDate.getUTCMilliseconds()));
    fobj.month.selectedIndex = dDate.getUTCMonth(); // set initial month to current
    fobj.year.value = dDate.getUTCFullYear()
    getDays(fobj.month,fobj.day,fobj.year)
    fobj.day.selectedIndex = dDate.getUTCDate()-1
//    fobj.epoch.value = window.getEpoch()
    fobj2.startTime.value = window.getEpoch()
    fobj2.dateDisplay.value = window.toDate(fobj2.startTime)
    fobj.hour.selectedIndex = dDate.getUTCHours();
    fobj.minute.selectedIndex = dDate.getUTCMinutes();
    fobj.second.selectedIndex = dDate.getUTCSeconds();
  } else {
    // LOCAL TIME
    window.dDate = new Date();
    fobj.month.selectedIndex = dDate.getMonth(); // set initial month to current
    fobj.year.value = dDate.getFullYear()
    getDays(fobj.month,fobj.day,fobj.year)
    fobj.day.selectedIndex = dDate.getDate()-1
//    fobj.epoch.value = window.getEpoch()
    fobj2.startTime.value = window.getEpoch()
    fobj2.dateDisplay.value = window.toDate(fobj2.startTime)
    fobj.hour.selectedIndex = dDate.getHours();
    fobj.minute.selectedIndex = dDate.getMinutes();
    fobj.second.selectedIndex = dDate.getSeconds();
  }
  
//  var GMT = document.ivnForm.GMT.checked
  var GMT = false
  if(GMT){
    var html = parseInt(Date.UTC(dDate.getUTCFullYear(),dDate.getUTCMonth(),dDate.getUTCDate(),dDate.getUTCHours(),dDate.getUTCMinutes(),dDate.getUTCSeconds(),dDate.getUTCMilliseconds())/1000)+' (Epoch)'
    + '<br>'+dDate.toUTCString()+' (Standard)'
  } else {
    var html = (dDate.getTime()-dDate.getMilliseconds())/1000+' (Epoch)'
    + '<br>'+dDate+' (Standard)'
  }
  if(document && document.getElementById){
    obj = document.getElementById('jdate1')
    if(obj) obj.innerHTML = html
  }
}
populateDates();

function validateStartTime()
{
  var fObj = document.forms.cci_input
  var startTime = fObj.startTime.value;


  var dCurrentDate = new Date();
  var currentTime = (dCurrentDate.getTime()-dCurrentDate.getMilliseconds())/1000;

  if (startTime == 0) return true;

  if (startTime <= (currentTime + 120 )) {
	  if (confirm('Start time is less than 2 minutes away and counting, Click OK to proceed.')) {
		  return true;
		 } else {
		  return false;
		 }
  } else {
    return true;
  }
}

</script>

</body>

