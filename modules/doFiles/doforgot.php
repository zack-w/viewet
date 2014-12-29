<?php
	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	$Input = $_GET['input'];
	$Input = $DB->escape( $Input );
	
	$query = $DB->query("SELECT * FROM users WHERE username = '".$Input."' or email = '".$Input."' LIMIT 0,1;");
	
	if( $DB->num_rows( $query ) == 0 )
	{
		$_GET['area'] = "forgot";
		$User->setMessage( "That account couldn't be located!" );
	}else{
		$Info = $DB->get_arr( $query );

		$ResetKey = rand(1, 99000000);
		
		$DB->query("UPDATE users SET ResetKey = '".md5($ResetKey)."' WHERE ID = ".$Info["ID"].";");
	
		mail( 
			$Info["email"], 
			"ViewET Email Reset", 
			"Please goto the link below to reset your password. This email was sent due to request.
			
http://hexgaming.net/viewet/?area=forgotpassword&key=" . $ResetKey . "&uid=" . $Info["ID"]
		);
	
		$User->setMessage( "An email has been sent to email on the account.", 2 );
	}
	
?>