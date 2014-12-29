<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}

	if( $User->isGuest() == 0)
	{
		$User->logoutUser();
	}
	
	if( !empty( $_POST['username'] ) && !empty( $_POST['password'] ) )
	{
		$Login = $User->loginUser($_POST['username'], $_POST['password']);
		
		if( $Login == true )
		{
			$_GET['area'] = "";
			$User->setMessage("You were logged in successfully", 2);
		}else{
			$User->setMessage("That username or password is incorrect. <a href='?area=forgot&user=".($_POST['username'])."'>Forgot Password?</a>");
		}
	}
		
?>