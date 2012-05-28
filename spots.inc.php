<?php
	/* Render de header en filter templates */
	if (!isset($data['spotsonly'])) {
		require_once "includes/header.inc.php";	
		require_once "includes/filters.inc.php";
	} # if

	// We definieeren hier een aantal settings zodat we niet steeds dezelfde check hoeven uit te voeren
	$show_watchlist_button = ($currentSession['user']['prefs']['keep_watchlist'] && $tplHelper->allowed(SpotSecurity::spotsec_keep_own_watchlist, ''));
	$show_comments = ($settings->get('retrieve_comments') && $tplHelper->allowed(SpotSecurity::spotsec_view_comments, ''));
	$show_filesize = $currentSession['user']['prefs']['show_filesize'];
	$show_spamreports = $currentSession['user']['prefs']['show_reportcount'];
	$show_nzb_button = ($tplHelper->allowed(SpotSecurity::spotsec_retrieve_nzb, '') && ($currentSession['user']['prefs']['show_nzbbutton']));
	$show_multinzb_checkbox = ($tplHelper->allowed(SpotSecurity::spotsec_retrieve_nzb, '') && ($currentSession['user']['prefs']['show_multinzb']));
	$show_mouseover_subcats = ($currentSession['user']['prefs']['mouseover_subcats']);
	
	echo '<div id="spots_thumbnails" class="clearfix" summary="Spots">';
	
	foreach($spots as $spot) {
		
		# Format the spot header
		$spot = $tplHelper->formatSpotHeader($spot);
		
		$newSpotClass = ($tplHelper->isSpotNew($spot)) ? 'new' : '';
		
        $tipTipClass = $show_mouseover_subcats ? 'showTipTip' : '';
		
		//print_r($spot);
		
		$catMap = array();
		foreach($spot['subcatlist'] as $sub) {
			$subcatType = substr($sub, 0, 1);
			$subCatDesc = SpotCategories::SubcatDescription($spot['category'], $subcatType);
			$catDesc = SpotCategories::Cat2Desc($spot['category'], $sub);

			if (isset($catMap[$subCatDesc])) {
				$catMap[$subCatDesc] .= ', ' . $catDesc;
			} else {
				$catMap[$subCatDesc] = $catDesc;
			} # else
		} # foreach
		$catData = json_encode($catMap);
	
		if($spot['rating'] == 0) {
			$rating = '';
		} elseif($spot['rating'] > 0) {
			$rating = '<span class="rating" title="' . sprintf(ngettext('This spot has %d star', 'This spot has %d stars', $spot['rating']), $spot['rating']) . '"><span style="width:' . $spot['rating'] * 4 . 'px;"></span></span>';
		}

		if($tplHelper->isModerated($spot)) { 
			$markSpot = '<span class="markSpot">!</span>';
		} else {
			$markSpot = '';
		}
		
		if($spot['idtype'] == 2) {
			$markSpot = '<span class="markGreen">W</span>' . $markSpot;
		}
		
		if($spot['idtype'] == 1) {
			$markSpot = '<span class="markSpot">B</span>' . $markSpot;
		}
		
		$reportSpam = '';
		if ($show_spamreports && $spot['reportcount'] != 0) {
			if($spot['reportcount'] == 1) {
				$reportSpamClass = ' grey';
			} elseif ($spot['reportcount'] >= 2 && $spot['reportcount'] < 4) {
				$reportSpamClass = ' orange';
			} elseif ($spot['reportcount'] >= 4 && $spot['reportcount'] < 6) {
				$reportSpamClass = ' darkorange';
			} elseif ($spot['reportcount'] >= 6) {
				$reportSpamClass = ' red';
			}

			$reportSpam = '<span class="reportedSpam'.$reportSpamClass.'" title="' . sprintf(ngettext('There is %d spamreport found for this spot', 'There are %d spamreports found for this spot', $spot['reportcount']), $spot['reportcount']) . '"><span>'.$spot['reportcount'].'</span></span>';
		}
		
		$fullSpot = $this->_tplHelper->getFullSpot($spot['messageid'], false);
		//print_r($spot);
		?>
		
		
		<div class="spot_thumb_view spotlink <?php echo $newSpotClass ?>" id="spot_<?php echo $spot['id'] ?>" data-cats="<?php echo $catData ?>">
		  
		  <div class="cover" onclick="openSpot('spot_<?php echo $spot['id'] ?>','<?php echo $spot['spoturl'] ?>')" href="<?php echo $spot['spoturl'] ?>">
<?php

if(file_exists( 'templates/splendid/imagecache/' . $spot['messageid'] )) {
	
	$size	= @GetImageSize( 'templates/splendid/imagecache/' . $spot['messageid'] );
	
	if($size[0] > 0) echo '		    <img src="templates/splendid/view_chached_image.php?image='.$spot['messageid'].'" alt="'.$spot['title'].'" style="display: block" />';
	  else echo '		    <img src="templates/splendid/resize_image.php?width=160&height=200&imgid='.$spot['messageid'].'&image=http://splendidnas/spotweb/?page=getimage%26messageid='.$spot['messageid'].'" alt="'.$spot['title'].'" style="display: block">';
	
} else {
	
	echo '		    <img src="templates/splendid/resize_image.php?width=160&height=200&imgid='.$spot['messageid'].'&image=http://splendidnas/spotweb/?page=getimage%26messageid='.$spot['messageid'].'" alt="'.$spot['title'].'" style="display: block">';
	
}

?>
		    <div class="spotinfo">
		      
		      <h1><?php echo $spot['title'] ?></h1><br />
		      
<?php

	if (!empty($spot['subcatlist'])) {
		$i=1;
		echo '<table>';
		foreach($spot['subcatlist'] as $sub) {
			
			if($i < 4) {
			
				$subcatType = substr($sub, 0, 1);
			
				$cat = SpotCategories::SubcatDescription($spot['category'], $subcatType);
			
				if($cat != 'Typen' AND $cat != '-' AND $cat != 'Taal') {
			
					echo '<tr><td>'.$cat . ':</td>';
					echo "<td>" . SpotCategories::Cat2Desc($spot['category'], $sub) . "</td></tr>";
					
					$i++;
					
				}
			
			}
			
		} # foreach
		echo '<tr><td>Omvang:</td><td>'.$tplHelper->format_size($spot['filesize']).'</td></tr>';
		echo '</table>';
	} # if
?>
		      
		    </div>
		    
		  </div>
		  
		  <div class="footer">
		    
		    <?php
		    
		    //echo 'rating: '.$rating;
		    
		    # only display the NZB button from 24 nov or later
			if ($spot['stamp'] > 1290578400 ) {
				if ($show_nzb_button) {
					echo "<span class='nzb'><a href='" . $tplHelper->makeNzbUrl($spot) . "' title ='" . _('Download NZB (n)') . "' class='nzb'>NZB";
					
					if ($spot['hasbeendownloaded']) {
						echo '*';
					} # if
					
					echo "</a></span>";
				} # if
				
				if ($show_multinzb_checkbox) {
					$multispotid = htmlspecialchars($spot['messageid']);
					echo "<span class='multinzb'>";
					echo "<input onclick='multinzb()' type='checkbox' name='".htmlspecialchars('messageid[]')."' value='".$multispotid."'>";
					echo "</span>";
				} # if
	
				# display the SABnzbd button
				if (!empty($spot['sabnzbdurl'])) {
					if ($spot['hasbeendownloaded']) {
						echo "<span class='sabnzbd'><a onclick=\"downloadSabnzbd('".$spot['id']."','".$spot['sabnzbdurl']."')\" class='sab_".$spot['id']." sabnzbd-button succes' title='" . _('Add NZB to SABnzbd queue (you already downloaded this spot) (s)') . "'> </a></span>";
					} else {
						echo "<span class='sabnzbd'><a onclick=\"downloadSabnzbd('".$spot['id']."','".$spot['sabnzbdurl']."')\" class='sab_".$spot['id']." sabnzbd-button' title='" . _('Add NZB to SABnzbd queue (s)'). "'> </a></span>";
					} # else
				} # if
			}
		      
		      
		    if ($show_watchlist_button) {
			  	echo "<span class='watch'>";
				echo "<a class='remove watchremove_".$spot['id']."' onclick=\"toggleWatchSpot('".$spot['messageid']."','remove',".$spot['id'].")\""; if(!$spot['isbeingwatched']) { echo " style='display: none;'"; } echo " title='" . _('Delete from watchlist (w)') . "'> </a>";
				echo "<a class='add watchadd_".$spot['id']."' onclick=\"toggleWatchSpot('".$spot['messageid']."','add',".$spot['id'].")\""; if($spot['isbeingwatched']) { echo " style='display: none;'"; } echo " title='" . _('Position in watchlist (w)') . "'> </a>";
				echo "</span>";
			}
		      
		    ?>
		    
		    
		    
		  </div>
		  
		  
		</div>
		
		
		
		<?php
	}
		
	echo '</div>';
	
	?>
	
	<?php if ($prevPage >= 0 || $nextPage > 0) { ?>
				<table class="footer" summary="Footer">
					<tbody>
						<tr>
<?php if ($prevPage >= 0) { ?> 
							<td class="prev"><a href="?direction=prev&amp;pagenr=<?php echo $prevPage . $tplHelper->convertSortToQueryParams() . $tplHelper->convertFilterToQueryParams(); ?>">&lt;&lt;</a></td>
<?php }?> 
							<td class="button<?php if ($nextPage <= 0) {echo " last";} ?>"></td>
<?php if ($nextPage > 0) { ?> 
							<td class="next"><a href="?direction=next&amp;pagenr=<?php echo $nextPage . $tplHelper->convertSortToQueryParams() . $tplHelper->convertFilterToQueryParams(); ?>">&gt;&gt;</a></td>
<?php } ?>
						</tr>
					</tbody>
				</table>
				
				<input type="hidden" id="perPage" value="<?php echo $currentSession['user']['prefs']['perpage'] ?>">
				<input type="hidden" id="nextPage" value="<?php echo $nextPage; ?>">
				<input type="hidden" id="getURL" value="<?php echo $tplHelper->convertSortToQueryParams() . $tplHelper->convertFilterToQueryParams(); ?>">
	
	<?php
	}
	
	/* Render de header en filter templates */
	if (!isset($data['spotsonly'])) {
		/* Render de footer template */
		require_once "includes/footer.inc.php";
	} # if
