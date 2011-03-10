<?/**
 * Copyright 2011 Jean Claveau
 * This file is part of Motif.
 * 
 * Motif is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Motif is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Motif.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Elements à ionclure dans onglets
 * 
 */


if( !function_exists('activitéOnglet') ) {
	function activitéOnglet( $href ) {
		if( isset($href) && !preg_match( "/.*$href.*/", $_SERVER['REQUEST_URI'] ) )
			return "";
		return "active";
	}
}


?>


<li id="<?=$id?>" class="<?=activitéOnglet($href);?>">
	<a href="<?=$href?>"><?=$label;?></a>
</li>
