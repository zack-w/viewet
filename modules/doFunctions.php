<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	$DoFunctions = array(
		array( "login", "dologin" ),
		array( "logout", "dologout" ),
		array( "doregister", "doregister" ),
		array( "doupload", "doupload" ),
		array( "comment", "docomment" ),
		array( "updateprofile", "updateprofile" ),
		array( "forgotpassword", "doforgotreset" ),
		array( "doreport", "doreport" ),
		array( "dodelete", "dodelete" ),
		array( "dodeletereports", "dodeletereports" ),
		array( "doedit", "doedit" ),
		array( "docommentreport", "docommentreport" ),
		array( "deletecomment", "deletecomment" ),
		array( "deletecommentreports", "deletecommentreports" ),
		array( "doforgot", "doforgot" ),
	);

	foreach( $DoFunctions as $Do )
	{
		if( $_GET['area'] == $Do[0] )
		{
			require_once( "modules/doFiles/" . $Do[1] . ".php" );
		}
	}
	
?>