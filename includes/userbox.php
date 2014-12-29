<?php
	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
?>

<div>
	<!--<a href='?area=logout'>-->
		<span class="headbox"> <!--onmouseover="frmtxt = innerHTML;innerHTML = 'Logout?';className = 'headboxover';" onmouseout="innerHTML = frmtxt;className = 'headbox';"-->
			<span>Welcome, <a href='?area=profile'><u><?php echo $User->getData(1); ?></u></a></span>
			<br />
			<a href='?area=logout'><span style='text-align: center;'><u>Logout?</u></span></a>
		</span>
	<!--</a>-->
</div>