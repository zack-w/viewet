<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	if( $User->isGuest() == 1 || $User->isAdmin() == 0 )
	{
		$User->setMessage( "Access Denied!" );
	}else{
		$CID = $DB->escape( $_GET['cid'] );
		
		$DB->query( "DELETE FROM comment_reports WHERE CommentID = ".$CID.";" );
		
		$User->setMessage( "Comment reports for that comment have been removed successfully!", 2 );
	}
	
?>