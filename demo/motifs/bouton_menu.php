<?

if( !function_exists('activitéMenu') ) {
	function activitéMenu( $href ) {
		if( isset($href) && !preg_match( "/.*$href.*/", $_SERVER['REQUEST_URI'] ) )
			return "";
		return "actif";
	}
}

// le style se trouve dans menu.

?>

<a class="menu <?=activitéMenu($href)?>" href="<?=$href?>" style=""><?=$label?></a>
