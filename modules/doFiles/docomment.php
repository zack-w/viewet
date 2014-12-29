<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}

	global $User, $DB;
	
	if( $User->isGuest() != 0 )
	{
		$User->setMessage("You must be logged in to do that!");
	}else{
		$CommentData = $_POST["comment_data"];
		$CommentLength = strlen( $CommentData );
		
		if( $CommentLength >= 125 || 10 >= $CommentLength )
		{
			$User->setMessage("Your comment must be between 10 and 125 letters long!");
		}else{
			$Err = Video::postComment( $_POST['vid'], $CommentData );
			
			if( $Err == false )
			{
				$User->setMessage("Your comment could not be posted!");
			}else{
				$User->setMessage("Your comment was posted successfully!", 2);
			}
		}
	}
	
	$_GET['area'] = "watch";
	$_GET['id'] = $_POST['vid'];
	
?>