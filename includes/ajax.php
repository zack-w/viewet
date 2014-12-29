<?php

	// This page currently stands only to handle the like and dislike features and dosen't support new additions

	define ( "IN_VIEWIT", 1 );

	require_once( "includes/php_head.php" );
	
	if( $User->isGuest() != 0 )
	{
		die( "0" );
	}

	$VideoID = $_GET['vid'];
	
	$VidExists = Video::videoExists( $VideoID );
	
	if( $VidExists != 1 )
	{
		die( "1" );
	}
	
	$UserVoted = Video::didUserLike( $VideoID );

	if( $UserVoted == 1 )
	{
		die("2");
	}
	
	$Request = $_GET['stance'];
	
	if( $Request != "1" && $Request != "2" )
	{
		die("3");
	}
	
	$User->voteForVideo($VideoID, $Request);
	die("4");