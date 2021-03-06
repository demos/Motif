	<br/>
	<logo src="demo/images/logo-gris.png" txt="Motif"/>
	<br/>
	<br/>
<ctrl ereg="ctn=projet&p=pyt$">
		<pre><![CDATA[<? 
		$test = "texte (variable php)";
		$code = <<<END
texte = ['Ce', '$test','est', 'affiché ', 'en', 'Python!!']
for mot in texte:
	print mot

END;
		if( function_exists('python_exec') ) python_exec($code);
		else echo "PIP n'est pas activé";
		?>]]></pre>
		<code id="code" lang="php">
		$test = "texte (variable php)";
		$code = &lt;&lt;&lt;END
texte = ['Ce', '$test','est', 'affiché ', 'en', 'Python!!']
for mot in texte:
	print mot

END;
		python_exec($code);
		</code>
		
		<br/>
		Les fonction python_eval, python_exec et python_call sont disponibles. La doc est obsolète 
		donc je ne sais pas exactement comment elles tournent.<br/>
</ctrl>
<ctrl defaut="^\/motif\/$" ereg="ctn=projet$">
	<b>Motif</b> est un projet opensource d'assemblage de segments html (ou autre langage basé sur xml).<br/>
	<br/>
	Un premier design a été établi par Jean Claveau en PHP dont ce site illustre l'utilisation.<br/>
	Avec la participation d'Alexandre Dubreuil, nous cherchons maintenant à permettre l'utilisation de Python dans les motifs.<br/>
	<br/>
	Merci à Hugues Faipoux pour le logo et le design.
	<br/>
	<br/>

	<style>
	#fluxrss {
		margin:0;
		padding:5px;
		float:left;
		width:40%;
		height: 200px;
		font-size:10px;
		background-color: none;
		overflow: auto;
		overflow-x: hidden;
	}
	.clear{
		clear:both;
		display:block;
		height: 0;
		font-size: 1px;
		line-height: 0px;
	} 
	#liens {
		float: right;
		width: 55%;
	}
	</style>

	<titre label="Suivi du projet"/>
	<rss id="fluxrss"/>
	<js><![CDATA[
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
				'max-height':'25px'
			},
			debug:false,
			bord:"gauche"
		};
		$("#fluxrss").scrollbar( params );
		//$("#contenu").scrollbar();
	});
	]]></js>


	<div id="liens">
		<h3>Liens</h3>
		<a href="https://github.com/demos/Motif" target="blank">Motif sur GitHub</a>
		<a href="http://www.indelible.org/php/python/guide.html" target="blank">Manuel PIP</a>
		<br/>
		<br/>
		<h3>Bugs remarqués</h3>
		+ Problème d'interprétation des éléments vides qui ne devraient pas l'être comme &lt;div/&gt;<br/>
		Si l'analyseur en trouve, il faut les transformer en &lt;div&gt;&lt;/div&gt;<br/>
		+ PIP fait beuguer Apache sur Maverick Server et lucid.<br/>
		
		
		<h3>Feuille de route</h3>
		+ Appliquer thème préparé par Hugues sur le site de démo (presque fini).<br/>
		+ Gérer l'héritage css<br/>
		+ Protéger motif contre les dépassements de pile (motifs identiques imbriqués)<br/>
		+ Faire évoluer l'API de log<br/>
		+ Reflexion sur les paramètres de lecture de motif : DTD, dossiers sources...<br/>
		+ Définir une architecture orientée pour l'optimisation (actuellement il s'agit d'un simple design fonctionnel rangé dans une classe).<br/>
		+ Integration de motifs écrits en Python via PIP => bug de PIP<br/>
		<br/>

	</div>



	<br class="clear" /> 
	<br/>
	<br/>



	<titre label="Classe Motif"/>
	Il s'agit du coeur du système. Ce script intègre les motifs les uns dans les autres.<br/>
	<code id="codeclassemotif" lang="php">
		<fichier id="code" src="motif.php" type="txt"/>
	</code>
	<br/>
	<br/>
</ctrl>


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

<ctrl ereg="ctn=projet&p=com" >
	<h1>Motifs communs</h1>
	Ces motifs sont dans "/motifs communs"<br/>
	<a href="#logo.php">logo.php</a><br/>
	<a href="#js.php">js.php</a><br/>
	<a href="#css.php">css.php</a><br/>
	
	<?
	$motifs = listeDossier("motifs communs");
	foreach( $motifs as $fichier ) {
		$tmp = str_replace( ".", "", $fichier); ?>
		<a name="<?=$fichier?>"></a><br/>
		<titre label="<?=$fichier?>"/>
		<code id="<?=$tmp?>" lang="php; html-script: true;" params="caché;">
			<fichier src="motifs communs/<?=$fichier?>" type="txt"/>
		</code>
	<?}?>
	<br/>
	<br/>
</ctrl>
