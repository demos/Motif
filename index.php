<?
/**
 * 
 * 
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

// VALEURS
define("sdl", "<br/>\n");	// Saut de ligne


function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}


// Vérifie si un fichier se trouve dans les includepaths
// retourne le chemin absolu du fichier s'il est trouvé
// retourne false sinon
function incluable( $nom=false ){
	if( !$nom || $nom == "") return false;
	$dossiers = explode(":", get_include_path());
	foreach( $dossiers as $dossier ) {
		//echo "incluable $dossier/$nom".sdl;
		if( file_exists("$dossier/$nom") )
			return "$dossier/$nom";
	}
	//echo "incluable ".$nom." ".count($dossiers).sdl;
	return false;
}

$conf = array(
	"dossiers" => array(".", "motifs communs", "demo", "demo/motifs"),
	"motifs" => array(
		"onglets",
		"onglet",
		"demo",
		"contenu",
		"logo",
		"fichier",
		"ctrl",
		"menu",
		"bouton_menu",
		"menu-deroulant",
		"item-menu-deroulant",
		"code",
		"rss",
		"js",
		"css")
);

include "motif.php";
$motif = new Motif($conf);
echo $motif->lit("demo");

/* Explications :
 * $motif va chercher "demo" dans "." puis "motifs".
 * Il le trouve dans "." et l'évalue.
 * Il affiche le résultat.
 * Allez voir demo.php pour voir la structure du site.
 * 
 */



?>
