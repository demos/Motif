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
		<!-- syntaxhighlighter -->
		<css src="demo/ext/syntaxhighlighter/styles/shCoreDefault.css"/>
		<js src="demo/ext/syntaxhighlighter/scripts/shCore.js"/>
		<js src="demo/ext/syntaxhighlighter/scripts/shBrushJScript.js"/>
		<js src="demo/ext/syntaxhighlighter/scripts/shBrushXml.js"/>
		<js src="demo/ext/syntaxhighlighter/scripts/shBrushPhp.js"/>
		<js> SyntaxHighlighter.all(); </js>
		<!-- JQuery -->
		<js src="demo/ext/jquery/jquery-1.5.1.min.js"/>
		<js src="demo/ext/jquery/jquery.tools.min.js"/>
		<js src="demo/ext/jquery/ui.core-1.7.2.js"/>
		<js src="demo/ext/jquery/ui.draggable-1.7.2.js"/>
		<js src="demo/ext/jquery/jquery.mousewheel.min.js"/>
		<!--<js src="demo/ext/jquery/plugin.scrollbar-min.js"/>
		<js src="demo/ext/jquery/plugin.scrollbar.js"/>-->
		<!--<js src="demo/ext/jquery-1.2.6.min.js"/>-->
		<js src="demo/ext/rssreader/rssReader-src.js"/>
		<style>
			html, body {
				width: 100%;
				height: 100%;
				margin: 0;
				font-family: arial;
				font-size: 12px;
				background-color: #f6f6f6;
			}
			
			img { border: 0; }
			a { color: #000; }
			
			a:hover { color: #BE7A40; }
			
			#logo {
				left: 5%;
				margin-top: -40px;
				top: 10%;
				position : absolute;
			}
			
			#contenu {
				position : absolute;
				border-bottom: 1px solid #1D1D1B;
				height: 76%;
				width: 90%;
				left: 5%;
				top: 14%;
				color: #666;
			}
			
			#c277 {
				position : absolute;
				top : 92%;
				margin: 1%;
				right: 0;
			}
			
			#menus {
				border-top: 1px solid #1D1D1B;
				position: absolute;
				width: 90%;
				top : 10%;
				left: 5%;
				text-align:center;
			}
			
			.menu {
				font-family: arial;
				font-size: 16px;
				margin: 0;
				margin-left:30px;
				margin-right:30px;
				display: inline;
				width: 150px;
			}
			.menu a {
				text-decoration: none;
			}
			
			
			#menudemo ul {
				text-align: left;
				width: 300px;
			}
			
			#menuprojet ul {
				text-align: left;
				width: 300px;
			}


		</style>
	</head>
	<body>
		<logo href="/motif" src="demo/images/logo.png" txt="Motif" id="logo"/>
		<contenu id="contenu">
<js>
$(document).ready(function(){
	//$("#contenu").scrollbar();
});
</js>

			<fichier src="demo/contenu/projet.php" type="html" ctrl="(ctn=projet)|(^\/motif\/$)"/>
			<fichier id="demonstration" src="demo/contenu/exp.php" type="html" ctrl="ctn=exp"/>
			<fichier src="demo/contenu/GPL.php" type="html" ctrl="ctn=GPL"/>
		</contenu>
		<img src="demo/images/trois-tiret-droite.png" style="position : absolute; top: 10%; margin-top: -10px; right: 8%;"/>
		<div id="menus">
			<menu-deroulant id="menuprojet" css="menu" titre="Projet" href="?ctn=projet">
				<li>&nbsp;</li>
				<item-menu-deroulant href="?ctn=projet&p=pyt" label="Python"/>
				<item-menu-deroulant href="?ctn=projet&p=com" label="Motifs Communs"/>
				<li>&nbsp;</li>
			</menu-deroulant>
			<img src="demo/images/tiret-menu.png" style="position: absolute; margin-top: -5px; margin-left: -5px;"/>
			<menu-deroulant id="menudemo" css="menu" titre="Exemple" href="?ctn=exp">
				<li>&nbsp;</li>
				<item-menu-deroulant href="?ctn=exp&p=pre" label="Présentation"/>
				<item-menu-deroulant href="?ctn=exp&p=src" label="Contenu"/>
				<item-menu-deroulant href="?ctn=exp&p=mtf" label="Motifs"/>
				<li>&nbsp;</li>
			</menu-deroulant>
			<img src="demo/images/tiret-menu.png" style="position: absolute; margin-top: -5px; margin-left: -5px;"/>
			<menu-deroulant id="menulicense" css="menu" titre="License" href="?ctn=GPL"/>
		</div>
		<img src="demo/images/ombre.png" style="height: 60px; width: 80%; margin-left: 10%; top: 90%; position:absolute"/>
		<logo href="http://www.collectif277.fr" src="demo/images/c277.png" txt="Collectif 277" id="c277"/>
	</body>
</html>
