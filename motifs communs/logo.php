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
 * Classiquement, un logo est une image/lien vers la
 * page d'accueil.
 * 
 * nom : logo
 * Attributs : href, id, css, txt, src
 * 
 * Ajouter vauleurs par défaut
 * 
 * si href n'est pas défini, aucun lien n'est mis en place
 * 
 */
if( !isset($css) ) $css="";

if( isset($href) ) {
	// les liens distants sont en _blank
	$cible = ( $href && substr($href, 0, 4) == "http" )? "target=\"_blank\"" : "";
	?>
	<a href="<?=$href?>" <?=$cible?> >
		<img id="<?=$id?>" src="<?=$src?>" class="<?=$css?>" alt="<?=$txt?>" style="border:0;"/>
	</a>
	<?
} else {
	?>
	<img id="<?=$id?>" src="<?=$src?>" class="<?=$css?>" alt="<?=$txt?>" style="border:0;"/>
	<?
}
