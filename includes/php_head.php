<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	require_once( "includes/recapatcha.php" );
	require_once( "modules/user.php" );
	require_once( "modules/mysql.php" );
	require_once( "modules/video.php" );
	
	global $User, $DB, $PublicKey, $PrivateKey;
	
	$User = new User();
	$DB = new db();
	
	$PublicKey = "6LeXd9ISAAAAAC84-BPYTSPx0gpmWr7N9a-Wtov7";
	$PrivateKey = "6LeXd9ISAAAAAIPOUOvWEcl81j8c7bnPd5gSHCBU";
	
	$User->checkCookieAuth();
	
	require_once( "modules/doFunctions.php" );