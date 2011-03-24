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
 * Simplification de script
 * 
 * + ajoute un prefixe d'uri via l'attribut base
 * + permet de charger plusieurs source en ecrivant l'attribut sous la forme :
 *     src="fichier1.js; fichier2.js; ... "
 * + Permet l'execution directe d'un script enfant après le chargement des sources
 * 
 * bugs :
 * les elements js incluant des > et < génèrent des erreurs d'interpretation du xml côté php
 * 
 */

if( !isset($base) ) $base="";
if( isset($src) )
	$srcs = $this->attrListePhp( $src );
else $srcs = array();

if( $final ) { 
	foreach( $srcs as $uri => $bool ) { 
		?><script type="text/javascript" src="<?=$base.$uri;?>" > </script><?
	}
} else {
	foreach( $srcs as $uri => $bool ) { 
		?><script type="text/javascript" src="<?=$base.$uri;?>" > </script><?
	}
	?>
		<script type="text/javascript">
			<enfants type="cdata"/> 
		</script>
	<?
}



?>