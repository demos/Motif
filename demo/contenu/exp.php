<style>
	#menu-exemple {
		font-size: 13px;
		font-weight: bold;
		border-bottom: 1px solid #1D1D1B;
		height: 20px;
		line-height: 20px;
	}

	#menu-exemple a {
		color: #1D1D1B;
		text-decoration : none;
	}
</style>

<menu id="menu-exemple">
	<bouton_menu href="?ctn=exp&p=pre" label=" PRÉSENTATION"/>
	<bouton_menu href="?ctn=exp&p=src" label=" CONTENU"/>
	<bouton_menu href="?ctn=exp&p=mtf" label=" MOTIFS"/>
	<bouton_menu href="?ctn=exp&p=com" label=" MOTIFS COMMUNS"/>
</menu>

<br/>
<br/>

<ctrl defaut="ctn=exp$" ereg="ctn=exp&p=pre">
	<h1>Démonstration</h1>
	Le site de démonstration est contenu dans le dossier demo.<br/>
	Il contient un fichier <a href="?ctn=exp&p=src#demo.php">demo.php</a> qui correspond au motif élémentaire du site : <br/>
	Doctype, structure html basique plus description des grandes lignes du site.<br/>
	<br/>
	Respectivement, les sous-dossiers de demo contiennent :<br/>
	+ contenu : Les pages de contenu du site (les noeuds du plan de site).<br/>
	+ motifs : Les motifs propre au site demo uniquement.<br/>
	+ ext : les librairies externes utilisées (syntaxhighlighter, jquery et rssreader).<br/>
	+ images : les images du site demo.<br/>
	<br/>
	Il existe aussi un dossiers "motifs communs" au même niveau que le dossier demo. Il concentre les motifs <br/>
	génériques partageables entre plusieurs applis.<br/>
	
	
</ctrl>

<ctrl ereg="ctn=exp&p=src">
	<h1>Sources du site de démonstration</h1>
	L'intégralité de la sémantique du site se trouve dans ces 300 lignes de code.<br/>
	Il n'y a pas une ligne de PHP. Tout n'est que html/motif.<br/><br/>
	
	<a href="#demo.php">demo.php</a><br/>
	<a href="#projet.php">projet.php</a><br/>
	<a href="#exp.php">exp.php</a><br/>
	La page License n'est pas listée car il s'agit du texte fourni par GNU tel quel.<br/>
	
	<a name="demo.php"></a><br/>
	<h2>demo.php</h2>
	<code id="demophp" lang="php; html-script: true;">
		<fichier src="demo/demo.php" type="txt"/>
	</code>
	
	<a name="projet.php"></a><br/>
	<h2>projet.php</h2>
	<code id="projetphp" lang="php; html-script: true;">
		<fichier src="demo/contenu/projet.php" type="txt"/>
	</code>
	
	<a name="exp.php"></a><br/>
	<h2>exp.php</h2>
	<code id="expphp" lang="php; html-script: true;">
		<fichier src="demo/contenu/exp.php" type="txt"/>
	</code>
	
</ctrl>

<ctrl ereg="ctn=exp&p=mtf">
	<h1>Motifs du site de démonstration</h1>
	Ces motifs sont rangés dans "/demo/motifs".<br/>
	<a href="#code.php">code.php</a><br/>
	<a href="#contenu.php">contenu.php</a><br/>
	<a href="#menu.php">menu.php</a><br/>
	
	
	<a name="code.php"></a><br/>
	<h2>code.php</h2>
	<code id="codephp" lang="php; html-script: true;">
		<fichier src="demo/motifs/code.php" type="txt"/>
	</code>

	<a name="contenu.php"></a><br/>
	<h2>contenu.php</h2>
	<code id="ctnphp" lang="php; html-script: true;">
		<fichier src="demo/motifs/contenu.php" type="txt"/>
	</code>

	<a name="menu.php"></a><br/>
	<h2>menu.php</h2>
	<code id="menuphp" lang="php; html-script: true;">
		<fichier src="demo/motifs/menu.php" type="txt"/>
	</code>
</ctrl>


<ctrl ereg="ctn=exp&p=com">
	<h1>Motifs communs</h1>
	Ces motifs sont dans "/motifs communs"<br/>
	<a href="#logo.php">logo.php</a><br/>
	<a href="#js.php">js.php</a><br/>
	<a href="#css.php">css.php</a><br/>
	
	
	<a name="logo.php"></a><br/>
	<h2>logo.php</h2>
	<code id="logophp" lang="php; html-script: true;">
		<fichier src="motifs communs/logo.php" type="txt"/>
	</code>

	<a name="js.php"></a><br/>
	<h2>js.php</h2>
	<code id="jsphp" lang="php; html-script: true;">
		<fichier src="motifs communs/js.php" type="txt"/>
	</code>
	
	<a name="css.php"></a><br/>
	<h2>css.php</h2>
	<code id="cssphp" lang="php; html-script: true;">
		<fichier src="motifs communs/css.php" type="txt"/>
	</code>

</ctrl>




