
<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}
	
	$rows = 4;
	$columns = 3;
	
	$videosPerPage = $rows * $columns;
	$doCat = 0;
	$page = 1;
	$method = 0;
	
	if( !empty( $_GET['cat'] ) && is_numeric( $_GET['cat'] ) ){ $doCat = $_GET['cat']; }
	if( !empty( $_GET['page'] ) && is_numeric( $_GET['page'] ) ){ $page = $_GET['page']; }
	if( !empty( $_GET['m'] ) && is_numeric( $_GET['m'] ) ){ $method = $_GET['m']; }
	
	$videoCount = ceil( Video::videoCount($doCat) / $videosPerPage );
	
	
	$trendingVids = Video::findTrending($doCat, $videosPerPage, $page, $method);
	
	
	if( $DB->num_rows( $trendingVids ) < 1 )
	{
		echo "<div class='error'>There are no videos in this category!</div>";
	}else{
		
		$catInfo = Video::categoryInfo( $doCat );
		
		if( empty( $catInfo ) )
		{
			echo "<h2>Front Page</h2>";
		}else{
			echo "<h2>".$catInfo['Name']."</h2>";
		}
		
		echo "
			<span class='catNav'>
				<a href='?m=0&cat=" . ($doCat) . "' " . ( ($method == 0)?("style='font-weight: bold;'"):("") ) . ">Trending</a> |
				<a href='?m=1&cat=" . ($doCat) . "' " . ( ($method == 1)?("style='font-weight: bold;'"):("") ) . ">Most Viewed</a> |
				<a href='?m=2&cat=" . ($doCat) . "' " . ( ($method == 2)?("style='font-weight: bold;'"):("") ) . ">Highest Rating</a> |
				<a href='?m=3&cat=" . ($doCat) . "' " . ( ($method == 3)?("style='font-weight: bold;'"):("") ) . ">Newest</a>
			</span>
			<br /><br />
		";
		
		$recompiled = array();
		$inserted = 0;
		
		while( $row = $DB->get_arr( $trendingVids ) )
		{
			$recompiled[ $inserted ] = $row;
			$inserted++;
		}
		
		/*
		while( $row = $DB->get_arr( $trendingVids ) )
		{
		
			?>
				<table class="videoFrontTable">
					<tr>
						<td style='width: 130px;padding: 5px;'><a href='?area=watch&id=<?php echo $row[0]; ?>'><img class="videoImg" src='http://<?php echo Video::static_getImagePreview( $row['Key'] ); ?>' onmouseover="old = src;src = 'includes/images/youtube_play.png';" onmouseout="src = old;" /></a><br /><div style='text-align: center;font-size: 12px;'>Rating: <?php echo $row['Rating']; ?></div></td>
						<td>
							<p><a href='?area=watch&id=<?php echo $row[0]; ?>'><b><?php echo $row['Name']; ?></b></a> <i style='font-size: 11px;'>Posted by <?php echo $row["username"] . " " . Video::time_elapsed_B( time() - $row['Posted'] ); ?></i></p>
							<p><?php echo $row['Description']; ?></p>
						</td>
					</tr>
				</table>
			<?php
		}*/
		
		?>
			<table class="videoFrontTable" style="table-layout:fixed;overflow: auto;">
			
			<tr>
				<td style="width: 33%;"></td>
				<td style="width: 1%;"></td>
				<td style="width: 33%;"></td>
				<td style="width: 1%;"></td>
				<td style="width: 33%;"></td>
			</tr>
		<?
		
		for($row = 0; $row < $rows; $row++ )
		{
			echo "<tr>";
			
			for($column = 0; $column < $columns; $column++)
			{
				$videoInfo = $recompiled[( $row * $columns + $column  )];
				
				if( !empty( $videoInfo ) )
				{
					$Desc = ($videoInfo["Description"] == "")?("<i>No Description Entered!</i>"):($videoInfo["Description"]);
				
					echo "
						<td style='text-align: left;'>
							<table style='table-layout: fixed;width: 100%;'>
								<tr>
									<td>
										<a href='?area=watch&id=" . $videoInfo['ID'] . "'><img class='videoImg' src='http://" . (Video::static_getImagePreview( $videoInfo['Key'] )) . "' onmouseover=\"old = src;src = 'includes/images/youtube_play.png';tooltip.show('<b>".$videoInfo["Name"]."</b><br />".$Desc."', 200);\" onmouseout=\"src = old;tooltip.hide();\" /></a>
									</td>
									
									<td style='overflow: hidden;width: 55%;'>
										<a class='viewLink' href='?area=watch&id=" . $videoInfo['ID'] . "'>". $videoInfo["Name"] ."</a>
										<br /><br />
										
										<div style='font-size: 12px;color: #999;'>
											Posted ".( Video::time_elapsed_B(time() - $videoInfo["Posted"]) )."
											<br />
											Rating: ".$videoInfo['Rating']." Views: ".$videoInfo['Views']."
										</div>
									</td>
								</tr>
							</table>
						</td>
						
						<td></td>
					";
				}
			}
			
			echo "</tr>";
		}
?>
</table>

<br />
<table style="width: 100%;margin-left: autp;margin-right: auto;">
	<tr>
		<td style="width: 40%;"><?php if( $page > 1 ){ ?><a href="?page=<?php echo ($page - 1) . "&m=" . $method . "&cat=" . $doCat; ?>"><span class="pageButton">Previous Page</span></a><?php } ?></td>
		<td style="width: 20%;text-align: center;"><div class="pageInfo">Current Page: <?php echo $page; ?></div></td>
		<td style="float: right;"><?php if(  $videoCount > $page ){ ?><a href=""><a href="?page=<?php echo ($page + 1) . "&m=" . $method . "&cat=" . $doCat; ?>"><span class="pageButton">Next Page</span></a><?php } ?></td>
	</tr>
</table>

<?php
	}
?>
