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
	
} # class SplendidTemplateHelper
