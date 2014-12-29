<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	if( $User->isGuest() == 0 )
	{
		echo "<div class='error'>Please logout before accessing this page!</div>";
	}else{
	
?>

<form action="?area=doregister" method="post">
	<table style='width: 100%;'>
		<tr>
			<td><b>Username</b></td>
			<td><b><input type='text' name='username' value='<?php echo $_POST['username']; ?>' /></b></td>
		</tr>
		
		<tr>
			<td><b>Password</b></td>
			<td><b><input type='password' name='password' /></b></td>
		</tr>
		
		<tr>
			<td><b>Confirm Password</b></td>
			<td><b><input type='password' name='password_conf' /></b></td>
		</tr>
		
		<tr>
			<td><b>Email</b></td>
			<td><b><input type='text' name='email' value='<?php echo $_POST['email']; ?>' /></b></td>
		</tr>
		
		<tr>
			<td><!--<b>Are you human?</b>--></td>
			<td><?php echo recaptcha_get_html($PublicKey); ?></td>
		</tr>
	</table>
	<br />
	<input type='submit' class='regbutton' value='Register!' />
</form>

<?php
	}
?>