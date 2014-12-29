<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	$err = 0;
	
	if( $User->isGuest() == 0 )
	{
		$User->setMessage("You must logout before accessing this page!");
		$err = 1;
	}
	
	$usr = $_POST['username'];
	$pas = $_POST['password'];
	$eml = $_POST['email'];
	
	// var, min, max, feasible
	$maxLengths = array(
		array( $usr, 4, 28, "username" ),
		array( $pas, 6, 28, "password" ),
		array( $eml, 7, 28, "email" ),
	);
	
	if( empty( $usr ) ||  empty( $pas ) ||  empty( $eml ) && $err == 0 )
	{
		$User->setMessage( "You are missing some stuff!" );
		$err = 1;
	}
	
	if ( $err == 0 ){
		foreach( $maxLengths as $do )
		{
			$len = strlen( $DB->escape( $do[0] ) );
		
			if( $len > $do[2] || $do[1] > $len )
			{
				$User->setMessage("Field " . $do[3] . " must be between " . $do[1] . " and " . $do[2] . " characters.");
				
				$err = 1;
				break;
			}
		}
	}
	
	if( $err == 0 )
	{
		if( !ctype_alnum( $usr ) )
		{
			$err = 1;
			$User->setMessage("Your username can only contain letters A-Z and numbers.");
		}
	}
	
	if( $err == 0 )
	{
		if( $_POST['password_conf'] != $pas )
		{
			$err = 1;
			$User->setMessage("The passwords you entered don't match!");
		}
	}
	
	if( $err == 0 )
	{
		$resp = recaptcha_check_answer( $PrivateKey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"] );
		
		if (!$resp->is_valid) {
			$User->setMessage( "They're just letters!" );
			$err = 1;
		}
	}
	
	if( $err == 0 )
	{
		$User->registerUser($usr, $pas);
		$User->setMessage("You have been registered and logged in successfully!");
	}else{
		$_GET['area'] = "register";
	}

?>