<?php
	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
?>

<div>
	<div class="headbox">
		<form action="?area=login" method="post">
			<input class='textbox' type='text' name='username' value="Username"
				onfocus="if( value == 'Username' ){ value = ''; }"
				onblur="if( value == '' ){ value = 'Username' }"
			/>
			<br />
			<input class='textbox' type='password' name='password' value="Password"
				onfocus="if( value == 'Password' ){ value = ''; }"
				onblur="if( value == '' ){ value = 'Password' }"
			/>
			<br />
			
			<table style='margin-left: auto;margin-right: auto;'>
				<tr>
					<td>
						<button class='regbutton'>
							Login
						</button>
					</td>
		</form>
					<td>
						<form action="" method="get">
							<input type='hidden' name='area' value='register' />
							
							<button class='regbutton'>
								Register
							</button>
						</form>
					</td>
				</tr>
			</table>
			</span>
	</div>
</div>