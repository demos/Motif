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

/**
 * Simplification de style
 * 
 * voir le motif js
 */


if( !isset($base) ) $base="";
if( isset($src) )
	$srcs = $this->attrListePhp( $src );
else $srcs = array();

if( $final ) { 
	foreach( $srcs as $uri => $bool ) { 
		?><link type="text/css" rel="stylesheet" href="<?=$base.$src;?>"/><?
	}
} else {
	foreach( $srcs as $uri => $bool ) { 
		?><link type="text/css" rel="stylesheet" href="<?=$base.$src;?>"/><?
	}
	?>
		<style type="text/css">
			<enfants type="cdata"/> 
		</style>
	<?
}



?>

