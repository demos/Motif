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



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Exemple Simple Motif</title>
		<style>
			html, body {
				width: 100%;
				height: 100%;
				margin: 0;
				font-family: arial;
			}
		</style>
	</head>
	<body>
		<img src="images/logo.png" alt="" style="margin-left: 20px; margin-top: 5px;"/>
		<menu id="menu">
			<li><a href="?ctn=projet">Projet</a></li>
			<li><a href="?ctn=page">Exemple</a></li>
			<li><a href="?ctn=GPL">License</a></li>
		</menu>
		<contenu id="ctn"><?
			if( incluable("ctn/".$_GET['ctn'].".php") )
				include "ctn/".$_GET['ctn'].".php";
			else
				echo sdl."La page ".$_GET['ctn']." est introuvable";
		?></contenu>
	</body>
</html>
