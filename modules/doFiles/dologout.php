<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}

	if( $User->isGuest() == 0 )
	{
		$User->logoutUser();
		$User->setMessage( "You have successfully been logged out!", 2 );
	}

?>