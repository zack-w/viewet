<?php
	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	if( $User->isGuest() == 1 )
	{
		$_GET['area'] = "";
	}else{
		
?>

<form action="?area=updateprofile" method="post">
	<table width='100%' cellspacing='7'>
		<tr><td style='width: 25%;'></td><td></td></tr>
	
		<tr>
			<td><b>Username</b></td>
			<td><?php echo $User->getData(1); ?></td>
		</tr>
		
		<tr>
			<td><b>Email</b></td>
			<td><input name="emailconf" type='text' value='<?php echo $User->getData("email"); ?>' /></td>
		</tr>
		
		<tr>
			<td colspan=2><hr style="border-bottom: 1px solid #FFF;border-collapse: collapse;display: none;" /></td>
		</tr>
		
		<tr>
			<td><b>Password</b></td>
			<td><input name="password" type='password' value='empty' /> <i class="passwordEditText">Edit only if you are changing your password!</i></td>
		</tr>
		
		<tr>
			<td><b>Password Confirmation</b></td>
			<td><input name="passwordConf" type='password' value='empty' /></td>
		</tr>
		
		<tr>
			<td colspan=2><input type="submit" value="Update" class="navButton" /></td>
		</tr>
	</table>
</form>

<?php
		
	}
	
?>
