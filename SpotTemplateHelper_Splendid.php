<?php
class SpotTemplateHelper_Splendid extends SpotTemplateHelper {

	function cat2color($spot) {
		switch( (int) $spot['category']) {
			case 0: return 'blue'; break;
			case 1: return 'orange'; break;
			case 2: return 'green'; break;
			case 3: return 'red'; break;
		} # switch
		
		return '-';
	} # cat2color
	
	function filter2cat($s) {
		$cat = 0;
		if (stripos($s, 'cat0') !== false) {
			return "blue";
		} elseif (stripos($s, 'cat1') !== false) {
			return "orange";
		} elseif (stripos($s, 'cat2') !== false) {
			return "green";
		} elseif (stripos($s, 'cat3') !== false) {
			return "red";
		} # else
	} # filter2cat

	function getFilterIcons() {
		return array(
					'application'		=> _('Application'),
					'bluray'			=> _('Blu-Ray'),
					'book'				=> _('Book'),
					'controller'		=> _('Game'),
					'custom'			=> _('Plain'),
					'divx'				=> _('DivX'),
					'female'			=> _('Erotica'),
					'film'				=> _('Movie'),
					'hd'				=> _('HD'),
					'ipod'				=> _('iPod'),
					'linux'				=> _('Linux'),
					'apple'				=> _('Apple'),
					'mpg'				=> _('MPEG'),
					'music'				=> _('Music'),
					'nintendo_ds'		=> _('Nintendo DS'),
					'nintendo_wii'		=> _('Nintendo Wii'),
					'phone'				=> _('Phone'),
					'picture'			=> _('Picture'),
					'playstation'		=> _('Playstation'),
					'tv'				=> _('TV'),
					'vista'				=> _('Vista'),
					'windows'			=> _('Windows'),
					'wmv'				=> _('WMV'),
					'xbox'				=> _('Xbox'),
					'dvd'				=> _('DVD'),
					'pda'				=> _('PDA')
		);
	} # getFilterIconList

	function getSmileyList() {
		return array('biggrin' => 'templates/splendid/smileys/biggrin.gif',
				'bloos' => 'templates/splendid/smileys/bloos.gif',
				'buigen' => 'templates/splendid/smileys/buigen.gif',
				'censored' => 'templates/splendid/smileys/censored.gif',
				'clown' => 'templates/splendid/smileys/clown.gif',
				'confused' => 'templates/splendid/smileys/confused.gif',
				'cool' => 'templates/splendid/smileys/cool.gif',
				'exactly' => 'templates/splendid/smileys/exactly.gif',
				'frown' => 'templates/splendid/smileys/frown.gif',
				'grijns' => 'templates/splendid/smileys/grijns.gif',
				'heh' => 'templates/splendid/smileys/heh.gif',
				'huh' => 'templates/splendid/smileys/huh.gif',
				'klappen' => 'templates/splendid/smileys/klappen.gif',
				'knipoog' => 'templates/splendid/smileys/knipoog.gif',
				'kwijl' => 'templates/splendid/smileys/kwijl.gif',
				'lollig' => 'templates/splendid/smileys/lollig.gif',
				'maf' => 'templates/splendid/smileys/maf.gif',
				'ogen' => 'templates/splendid/smileys/ogen.gif',
				'oops' => 'templates/splendid/smileys/oops.gif',
				'pijl' => 'templates/splendid/smileys/pijl.gif',
				'redface' => 'templates/splendid/smileys/redface.gif',
				'respekt' => 'templates/splendid/smileys/respekt.gif',
				'schater' => 'templates/splendid/smileys/schater.gif',
				'shiny' => 'templates/splendid/smileys/shiny.gif',
				'sleephappy' => 'templates/splendid/smileys/sleephappy.gif',
				'smile' => 'templates/splendid/smileys/smile.gif',
				'uitroepteken' => 'templates/splendid/smileys/uitroepteken.gif',
				'vlag' => 'templates/splendid/smileys/vlag.gif',
				'vraagteken' => 'templates/splendid/smileys/vraagteken.gif',
				'wink' => 'templates/splendid/smileys/wink.gif');
	} # getSmileyList
	
	# Geeft een lijst van onze static files terug die door de static page gelezen wordt
	function getStaticFiles($type) {
		switch($type) {
			case 'js'	: {
				return array('js/jquery/jquery.min.js', 
								'js/jquery/jquery-ui.custom.min.js',
								'js/jquery/jquery.cookie.js',
								'js/jquery/jquery.hotkeys.js',
								'js/jquery/jquery.form.js',
								'js/jquery-json/jquery.json-2.3.js',
								'js/sha1/jquery.sha1.js',
								'js/posting/posting.js',
								'js/dynatree/jquery.dynatree.min.js',
								'templates/splendid/js/jquery.address.js',
								'templates/splendid/js/scripts.js',
								'templates/splendid/js/we1rdopost.js',
								'templates/splendid/js/treehelper.js',
								'templates/splendid/js/jquery.ui.nestedSortable.js',
								'templates/splendid/js/jquery.tipTip.minified.js'
								);
				break;
			} # case js
			
			case 'css'	: {
				return array('js/dynatree/skin-vista/ui.dynatree.css',
							 'templates/splendid/css/jquery-ui-1.8.13.custom.css',
							 'templates/splendid/css/spoticons.css',
							 'templates/splendid/css/style.css',
							 'templates/splendid/css/tipTip.css'
							 );
				break;
			} # case css
							 
			case 'ico'	: {
				return array('images/favicon.ico');
				break;
			} # case 'ico'
		} # switch
		
		return array();
	} # getStaticFiles 
	
	
	# Geneer een cover van een beschikbare afbeelding of een 'noimg' afbeelding
	function get_thumbnail($mssg_id, $maxWidth=140, $maxHeight=200, $crop='') {
		
		// Check if there is a imagecache in DB
		
		SpotTiming::start(__FUNCTION__);
		$img_data = $this->_db->getCache($mssg_id, 1);
		SpotTiming::stop(__FUNCTION__, array($img_data));
		
		if($img_data['metadata']['width'] > 0) {
			
			$cached = true;
			
		} else {
		
			$settings_nntp_hdr = $this->_settings->get('nntp_hdr');
			$settings_nntp_nzb = $this->_settings->get('nntp_nzb');
			
			$fullSpot = $this->getFullSpot($mssg_id, false);
			
			$spotsOverview = new SpotsOverview($this->_db, $this->_settings);
			$hdr_spotnntp = new SpotNntp($settings_nntp_hdr);
	
			/* Als de HDR en de NZB host hetzelfde zijn, zet geen tweede verbinding op */
			if ($settings_nntp_hdr['host'] == $settings_nntp_nzb['host']) {
				$nzb_spotnntp = $hdr_spotnntp;
			} else {
				$nzb_spotnntp = new SpotNntp($this->_settings->get('nntp_nzb'));
			} # else
			
			$img_data = @$spotsOverview->getImage($fullSpot, $nzb_spotnntp);
			
		}
		
		// Make sure that the requested file is actually an image
		if (!is_numeric($img_data['metadata']['imagetype'])) {
			
			$thumb_info = 'noimg';
			
		} else {
			
			// Location and name of cached file
			$cache_dir 		= 'templates/splendid/imagecache/';
			$resized 		= $cache_dir.$mssg_id;
			
			// Resize image and cache resize image
			
			$width			= $img_data['metadata']['width'];
			$height			= $img_data['metadata']['height'];
			
			// Ratio cropping
			$offsetX		= 0;
			$offsetY		= 0;
			
			// Determine the quality of the output image
			$quality		= 70;
			
			if (isset($crop)) {
				
				$cropRatio		= explode(':', (string) $crop);
				if (count($cropRatio) == 2) {
					
					$ratioComputed		= $width / $height;
					$cropRatioComputed	= (float) $cropRatio[0] / (float) $cropRatio[1];
					
					if ($ratioComputed < $cropRatioComputed) {
						
						// Image is too tall so we will crop the top and bottom
						
						$origHeight	= $height;
						$height		= $width / $cropRatioComputed;
						$offsetY	= ($origHeight - $height) / 2;
						
					}
					else if ($ratioComputed > $cropRatioComputed) { 
						
						// Image is too wide so we will crop off the left and right sides
						
						$origWidth	= $width;
						$width		= $height * $cropRatioComputed;
						$offsetX	= ($origWidth - $width) / 2;
						
					}
				}
			}
			
			// Setting up the ratios needed for resizing. We will compare these below to determine how to
			// resize the image (based on height or based on width)
			$xRatio		= $maxWidth / $width;
			$yRatio		= $maxHeight / $height;
			
			if ($xRatio * $height < $maxHeight) {
				
				// Resize the image based on width
				$tnHeight	= ceil($xRatio * $height);
				$tnWidth	= $maxWidth;
				
			}
			else {
				
				// Resize the image based on height
				$tnWidth	= ceil($yRatio * $width);
				$tnHeight	= $maxHeight;
			}
			
			
			// We don't want to run out of memory
			ini_set('memory_limit', '100M');
			
			// Set up a blank canvas for our resized image (destination)
			$dst 	= imagecreatetruecolor($tnWidth, $tnHeight);
			
			// Create imageholder from data string
			$src	= imagecreatefromstring($img_data['content']);
			
			// Set up the appropriate image handling functions based on the original image's mime type
			switch ($img_data['metadata']['imagetype']) {
				
				case 1:
				case 3:
					$outputFunction		= 'ImagePng';
					$doSharpen			= FALSE;
					$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
					
					// If this is a GIF or a PNG, we need to set up transparency
					imagealphablending($dst, false);
					imagesavealpha($dst, true);
				break;
				
				default:
					$outputFunction	 	= 'ImageJpeg';
					$doSharpen			= TRUE;
				break;
			}
			
			// Resample the original image into the resized canvas we set up earlier
			ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);
			
			if ($doSharpen) {
				
				// Sharpen the image based on two things:
				//	(1) the difference between the original size and the final size
				//	(2) the final size
				$sharpness	= $this->findSharp($width, $tnWidth);
				
				$sharpenMatrix	= array(
					array(-1, -2, -1),
					array(-2, $sharpness + 12, -2),
					array(-1, -2, -1)
				);
				$divisor		= $sharpness;
				$offset			= 0;
				
			}
			
			// Make sure the cache exists. If it doesn't, then create it
			if (!file_exists($cache_dir))
				mkdir('imagecache', 0755);
			
			// Make sure we can read and write the cache directory
			if (!is_readable($cache_dir)) {
				
				$thumb_info = 'noimg';
				
			}
			else if (!is_writable($cache_dir)) {
				
				$thumb_info = 'noimg';
				
			} else {
			
				// Write the resized image to the cache
				$outputFunction($dst, $resized, $quality);
				
				// Put the data of the resized image into a variable
				ob_start();
				$outputFunction($dst, null, $quality);
				$data	= ob_get_contents();
				ob_end_clean();
				
				// Clean up the memory
				ImageDestroy($src);
				ImageDestroy($dst);
				
				$thumb_info = 'cached';
			
			}
			
			
			switch($thumb_info) {
			
				case 'cached':
					return 'templates/splendid/imagecache/'.$mssg_id;
					break;
					
				default:
					
					if(isset($_GET['search']) && stristr($_GET['search']['tree'], 'cat1')) return 'templates/splendid/img/noimg_140.png';
						else return 'templates/splendid/img/noimg.png';
					break;

			}
			
			
		}
		
		
	}
	
	function findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
	{
		$final	= $final * (750.0 / $orig);
		$a		= 52;
		$b		= -0.27810650887573124;
		$c		= .00047337278106508946;
		
		$result = $a + $b * $final + $c * $final * $final;
		
		return max(round($result), 0);
	} // findSharp()
	
	function yt($text) {
   
		$text = ' '.$text.' ';
		//Modified!  to auto embed youtube links
		$text = preg_replace("/<a href=\"\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)\">\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)<\/a>/i"," <object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1&hl=en&fs=1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><embed src=\"http://www.youtube.com/v/$1&hl=en&fs=1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>",$text);
		
		return substr($text, 1, -1);
	}
	
	
} # class SplendidTemplateHelper
