<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}

	global $DB, $User;
	$err = 0;
	
	$Name = $DB->escape( $_POST['name'] );
	$Vid = $DB->escape( $_POST['url'] );
	$Cat = $_POST['cat'];
	$Desc = $DB->escape( $_POST['desc'] );
	
	if( $User->isGuest() == 1 )
	{
		$User->setMessage("You must login before accessing this page!");
		$err = 1;
	}
	
	if( $err == 0 )
	{
		if( Video::categoryExist( $Cat ) == 0 )
		{
			$err = 1;
			$User->setMessage("Sorry, that category dosent exist!");
		}
	}
	
	if( $err == 0 )
	{
		if( Video::IsVideoValid( $Vid ) == 0 )
		{
			$err = 1;
			$User->setMessage("There was an issue locating that video!");
		}
	}
	
	if( $err == 0 )
	{
		$BadChars = preg_match('#^[A-Z0-9 ]+$#i', $Name)?(0):(1);
	
		if( ($BadChars == 1) || strlen( $Name ) > 28 || 5 > strlen( $Name ) )
		{
			$err = 1;
			$User->setMessage("The video name must be A-Z, 0-9, and 6 - 28 letters long.");
		}
	}
	
	if( $err == 0 )
	{
		$Key = Video::uploadVideo($Name, $Vid, $Cat, $Desc);
		$User->setMessage("Your video has been uploaded successfully, click me to watch it!", 2, "?area=watch&id=" . $Key);
	}else{
		$_GET['area'] = "upload";
	}
	
?>