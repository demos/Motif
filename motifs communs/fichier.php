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
 * Le motif fichier permet d'inclure un fichier externe.
 * Son type : html ou txt, definit s'il doit être encerclé par
 * un cdata ou non.
 * La valeur ctrl est une expression régulière définissant son contrôleur.
 * 
 * nom : fichier
 * Attributs : src, type, ctrl
 * 
 * Ajouter vauleurs par défaut
 */

// Si le contrôleur ne correspond pas à l'uri, le motif ne doit pas être affiché
if( isset($ctrl) && !preg_match( "/$ctrl/", $_SERVER['REQUEST_URI'] ) ) return;

// Selon le type :
if( $type == "txt" ) {
	echo "<![CDATA[";
	//echo htmlentities(file_get_contents($src));
	echo htmlspecialchars(file_get_contents($src));
	echo "]]>"; 
	}
else include($src);

?>
