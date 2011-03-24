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
		<js src="ext/firebug-lite/build/firebug-lite.js"/>
		<!-- syntaxhighlighter -->
		<css src="demo/ext/syntaxhighlighter/styles/shCoreDefault.css"/>
		<js base="demo/ext/syntaxhighlighter/scripts/"
			src="shCore.js; shBrushJScript.js; shBrushXml.js; shBrushPhp.js; ">
			SyntaxHighlighter.all();
		</js>
		<!-- JQuery -->
		<js base="demo/ext/jquery/" 
			src="jquery-1.5.1.js; jquery.debug.js; get$.js;">
			// jquery.tools.min.js
			$(document).ready(function(){
				$.debug(true);
				$.log("plain debug message");
				$('#test1').log();
				$('#test2').log("with message");
			});
		</js>
		<!-- Barre de défilement -->
		<js base="demo/ext/jquery/"
			src="ui.core-1.7.2.js; ui.draggable-1.7.2.js; jquery.mousewheel.js; plugin.scrollbar.js; "/>
		<!-- Lecteur RSS -->
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
			
			.btn-scrollbar {
				border-collapse: collapse;
				padding:0;
				margin:0;
			}

			.btn-scrollbar tbody tr td img {
			/*	max-height: 50px;	/* pour webkit*/
			}
			
			.btn-scrollbar td {
				padding:0;
				margin:0;
				line-height:1px;
			}
			
			.btn-scrollbar img {
				width:100%;
				height:100%;
			}

		</style>
	</head>
	<body>
		<logo href="/motif" src="demo/images/logo.png" txt="Motif" id="logo"/>
		<js>
		$(document).ready(function(){
			var params = {
				bouton:'<table class="btn-scrollbar"><tr><td style="height:7px;"><img src="demo/images/haut-btn-barre.png"/></td></tr><tr><td style="height:100%"><img src="demo/images/milieu-btn-barre.png"/></td></tr><tr><td style="height:7px"><img src="demo/images/bas-btn-barre.png"/></td></tr></table>',
				scrollbar:'<div><img style="position:absolute; left:5px; width:1px;height:100%;" src="demo/images/gris.png"/></div>',
				style_barre:{
					'width':'10px',
					'margin-left':'-10px'
				},
				style_bouton:{
					'width':'100%',
					'max-height':'50px'
				},
				debug:false,
				bord:"gauche"
			};
			$("#contenu").scrollbar( params );
			//$("#contenu").scrollbar();
		});
		</js>
		<contenu id="contenu">
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
