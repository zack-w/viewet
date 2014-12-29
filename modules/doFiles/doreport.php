<?php
	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	$Video = $_GET['vid'];
	
	if( $User->isGuest() )
	{
		$User->setMessage( "You must be logged in to use that feature!" );
	}else{
		if( is_numeric( $Video ) && !empty( $Video ) )
		{
			$Reason = $_GET['reason'];
			
			if( empty( $Reason ) )
			{
				$Reason = "No reason entered!";
			}else{
				$Reason = $DB->escape( $Reason );
			}
			
			$resp = recaptcha_check_answer( $PrivateKey, $_SERVER["REMOTE_ADDR"], $_GET["recaptcha_challenge_field"], $_GET["recaptcha_response_field"] );
			
			if (!$resp->is_valid) {
				$User->setMessage( "You're not human?!?" );
				
				$_GET['area'] = "report";
				$_GET['vid'] = $Video;
				$_GET['reason'] = $Reason;
			}elseif( strlen( $Reason ) <= 50 ){
				Video::doReport($Video, $Reason);
				$User->setMessage( "Your report has been successfully omnmitted!", 2 );
			}
		}
	}
?>