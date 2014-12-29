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
		
		echo $CID;
		
		$DB->query( "DELETE FROM comments WHERE ID = ".$CID.";" );
		$DB->query( "DELETE FROM comment_reports WHERE CommentID = ".$CID.";" );
		
		$User->setMessage( "That comment has been removed successfully!", 2 );
	}
	
?>