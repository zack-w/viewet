<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	if( $User->isGuest() == 1 || $User->isAdmin() == 0 )
	{
		$User->setMessage( "Access Denied!" );
	}else{
		$VID = $DB->escape( $_GET['vid'] );
		
		$query = $DB->query( "DELETE FROM video_reports WHERE VideoID = ".$VID.";" );
		
		$User->setMessage( "Video reports for that video have been removed successfully!", 2 );
	}
	
?>