<?

function listeDossier($dossier){
	$rtr = array();
	$monDossier = opendir($dossier) or die('Erreur');
	while($entrée = @readdir($monDossier)) {
		if( $entrée == '.' || $entrée == '..' ){;}
		else if( is_dir($dossier.'/'.$entrée) ) {
            //echo '<ul>'.$dossier;
			//listeDossier($dossier.'/'.$entrée);
            //echo '</ul>';
		}
		else 
			$rtr[] = $entrée;
	}
	closedir($monDossier);
	return $rtr;
}



?>
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

<br/>
<logo src="demo/images/logo-gris.png" txt="Motif"/>


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
	<titre label="demo.php"/>
	<code id="demophp" lang="php; html-script: true;" params="caché;">
		<fichier src="demo/demo.php" type="txt"/>
	</code>
	
	<a name="projet.php"></a><br/>
	<titre label="projet.php"/>
	<code id="projetphp" lang="php; html-script: true;" params="caché;">
		<fichier src="demo/contenu/projet.php" type="txt"/>
	</code>
	
	<a name="exp.php"></a><br/>
	<titre label="exp.php"/>
	<code id="expphp" lang="php; html-script: true;" params="caché;">
		<fichier src="demo/contenu/exp.php" type="txt"/>
	</code>
	
</ctrl>

<ctrl ereg="ctn=exp&p=mtf">
	<h1>Motifs du site de démonstration</h1>
	Ces motifs sont rangés dans "/demo/motifs".<br/>
	<a href="#code.php">code.php</a><br/>
	<a href="#contenu.php">contenu.php</a><br/>
	<a href="#menu.php">menu.php</a><br/>
	<?
	$motifs = listeDossier("demo/motifs");
	foreach( $motifs as $fichier ) {
		$tmp = str_replace( ".", "", $fichier); ?>
		<a name="<?=$fichier?>"></a><br/>
		<titre label="<?=$fichier?>"/>
		<code id="<?=$tmp?>" lang="php; html-script: true;" params="caché;">
			<fichier src="demo/motifs/<?=$fichier?>" type="txt"/>
		</code>
	<?}?>
	<br/>
	<br/>
</ctrl>







