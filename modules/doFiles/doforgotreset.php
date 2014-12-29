<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	$Key = $_GET['key'];
	$UID = $_GET['uid'];
	
	$UID = $DB->escape( $UID );
	
	$query = $DB->query("SELECT username, email, ResetKey FROM users WHERE ID = ".$UID.";");
	$query = $DB->get_arr( $query );
	
	if( $query['ResetKey'] != "" && $query['ResetKey'] == md5( $Key ) )
	{
		$RealPass = md5( rand() );
		$NewPass = User::hashPassword( $query['username'], $RealPass );
	
		$DB->query("UPDATE users SET password = '".$NewPass."', ResetKey = '', CookieStr = 'NA' WHERE ID = ".$UID.";");
	
		mail( 
			$query["email"], 
			"ViewET - New Password", 
			"Your new ViewET password is " . $RealPass
		);
	
		$User->setMessage( "Your password has been emailed to you!", 2 );
	}else{
		$User->setMessage( "Key is invalid or expired." );
	}
	
?>