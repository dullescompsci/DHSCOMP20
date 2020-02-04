<?php

	if(version_compare(phpversion(),'4.3.0')>=0) { 
  		  if(!ereg('^SESS[0-9a-zA-Z]+$',$_REQUEST['SESSION_NAME'])) { 
			  header("Location: ../index.html"); 
 		   } 
  		  output_add_rewrite_var('SESSION_NAME',$_REQUEST['SESSION_NAME']); 
  		  session_name($_REQUEST['SESSION_NAME']); 
	}
		session_start();
		require_once("Java.inc");

		$server = java("ServerInterface")->getInstance();
		try {
			$currentStartTime = $server->getStartTimeEpoch($_SESSION['cid']);
			if(!java_is_null($currentStartTime))
			{
				$arr = array( 
					"currentStartTime" => java_cast($currentStartTime, "long")
				);
			        echo json_encode($arr);
				
			}
		} catch (JavaException $exception) {
			echo 'failed!';
		}
?>
