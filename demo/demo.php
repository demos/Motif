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
		<js src="demo/ext/jquery-1.5.1.min.js"/>
		<!--<js src="demo/ext/jquery-1.2.6.min.js"/>-->
		<js src="demo/ext/rssreader/rssReader-src.js"/>
		<style>
			html, body {
				width: 100%;
				height: 100%;
				margin: 0;
				font-family: arial;
				font-size: 12px;
			}
			
			a {
				color: #000;
			}
			
			a:hover {
				color: #BE7A40;
			}
			
			#logo {
				margin-left: 20px;
				margin-top: 5px;
				position : absolute;
				top: 0;
			}
			
			#ctn {
				border-bottom: 1px solid #1D1D1B;
				height: 80%;
				background-color: #bbb;
			}
			
			#c277 {
				float: right;
				margin: 1%;
			}
			
			#menu {
				margin: 0;
				margin-top: 4%;
			}

		</style>
	</head>
	<body>
		<logo href="/motif" src="demo/images/logo.png" txt="Motif" id="logo"/>
		<onglets id="menu">
			<onglet href="?ctn=projet"  ctrl="(ctn=projet)|(^\/motif\/$)" label="Projet"/>
			<onglet href="?ctn=exp" label="Exemple"/>
			<onglet href="?ctn=GPL" label="License"/>
		</onglets>
		<contenu id="ctn">
			<fichier src="demo/contenu/projet.php" type="html" ctrl="(ctn=projet)|(^\/motif\/$)"/>
			<fichier id="demonstration" src="demo/contenu/exp.php" type="html" ctrl="ctn=exp"/>
			<pre>
				<fichier src="demo/contenu/GPL.php" type="txt" ctrl="ctn=GPL"/>
			</pre>
		</contenu>
		<logo href="http://www.collectif277.fr" src="demo/images/c277.png" txt="Collectif 277" id="c277"/>
	</body>
</html>
