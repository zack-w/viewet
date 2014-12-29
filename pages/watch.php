<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}

	$ID = $_GET['id'];
	
	$Exists = Video::videoExists( $ID );
	
	if( $Exists == 0 )
	{
		echo '<div class="error">That video wasnt found!</div>';
	}else{
	
		$VData = Video::getData($ID);
	
		echo "
			<h1 style='margin-left: 15%;'>".$VData['Name']."</h1>
			<div style='font-size: 12px;color: #666;margin-left: 15%;'>Posted by ".$VData["username"]." ".(Video::time_elapsed_B(time() - $VData["Posted"]))."</div>
			<span style='margin-left: 15%;'>".$VData['Description']."</span><br /><br />
		";
		
		echo "<div style='text-align: center;'>" . Video::getEmbeed( $ID ) . "</div>";
		
		if( $User->isGuest() == 0 )
		{
			$HasVoted = Video::didUserLike( $ID );
		}else{
			$HasVoted = 1;
		}
?>

<table class="videoSubTable">
	<!--<tr>
		<td colspan=10 class="videoSubTableBG">
			<?php echo $VData['Description']; ?>
		</td>
	</tr>-->

	<tr>
		<td class="videoSubTableBG">
			<b>Views:</b> <?php echo $VData['Views']; ?>
		</td>
		
		<td class="videoSubTableBG">
			<span id="videoRatingSpan" style="display: block;" class="videoSubNoBG">
				<b>Rating:</b> <span id="curRating"><?php echo $VData['Rating']; ?></span>
			</span>
			
			<span id="videoRateSpan" style="display: none;">
				<table style='width: 100%;'>
					<tr>
						<td style="width: 45%;" class="iLike" onclick="doRate('1','<?php echo $VData['ID']; ?>');">Like</td>
						<td style="width: 10%;"></td>
						<td style="width: 45%;" class="iDislike" onclick="doRate('2','<?php echo $VData['ID']; ?>');">Dislike</span></td>
					</tr>
				</table>
			</span>
		</td>
	</tr>
	
	<?php
		if( $HasVoted == 0 )
		{
	?>
	
	<tr>
		<td></td>
		<td>
			<table style='width: 100%;background-color: #D5D5D5;padding: 2px 2px 4px 2px;' id='viewLikePane'>
				<tr>
					<td style="width: 50%;" class="iLike" onclick="doRate('1','<?php echo $VData['ID']; ?>');">Like</td>
					<td style="width: 0%;"></td>
					<td style="width: 50%;" class="iDislike" onclick="doRate('2','<?php echo $VData['ID']; ?>');">Dislike</span></td>
				</tr>
			</table>
		</td>
	</tr>
	<?php
		}
	?>
</table>

<br />

<div style='text-align: right;'>
	<a href='?area=report&vid=<?php echo $VData['ID']; ?>'>Report</a>
	
	<?php if( $User->isAdmin() ) { ?>
		 - <a href='?area=dodelete&vid=<?php echo $VData['ID']; ?>'>Delete Video</a> - 
		<a href='?area=dodeletereports&vid=<?php echo $VData['ID']; ?>'>Delete Video Reports</a> -
		<a href='?area=editvideo&vid=<?php echo $VData['ID']; ?>'>Edit Video</a>
	<?php } ?>
</div>

<br /><hr style='border-bottom: 1px solid #F5F5F5;'/><br />

<form action="?area=comment" method="post">
	<input type="hidden" name="vid" value="<?php echo $_GET['id']; ?>" />

	<div class="commentPane" style='padding-bottom: 10px;'>
		<textarea name="comment_data" id="commentText" class="commentTextArea" onkeydown="commentCheck();" onkeyup="commentCheck();" onfocus="if( value == 'Comment.' ){ value = ''; }" onblur="if( value == '' ){ value = 'Comment.' }" rows="1">Comment.</textarea>
		
		<table width='100%'>
			<tr>
				<td width='100%'><span id="commentError" class="tooLong" style="display: none;">Your comment is too long!</span></td>
				<td><input type="submit" value="Post" class="commentButton" style='float: right;margin-right: 5px;' /></td>
			</tr>
		</table>
	</div>
</form>

<br />

<?php
	
		$Comments = Video::getComments( $ID	);
		
		while( $row = $DB->get_arr( $Comments ) )
		{
			$elapsed = Video::time_elapsed_B( time() - $row["Date"] );
		
			echo "
				<div class='commentPane'>" . $row["Comment"] . "</div>
				<div class='commentAuthor'>Posted by " . $row["username"] . " " . $elapsed . " ago - <a href='?area=commentreport&cid=".$row['ID']."'>Report?</a></div>
			";
		}
	
	}
?>