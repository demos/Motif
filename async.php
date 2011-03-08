<?
/* Ce fichier génère un script de substitution à un modèle permettant de 
 * le charger de manière asynchrone
 * 
 * 
 */
function attrUrl($attributs) {
	// Convertit un tableau php représentatnt des attributs xml en chaine de variables url
	$liste = array();
	foreach ($attributs as $clé => $val) {
		if( $clé == "async" ) continue;
		$liste[] = $clé."=".urlencode($val);
	}
	return implode("&", $liste);
}

$attributs = attrUrl($attributs);
//$nom="tinymce";

$identifiant = rand();
if($nom == "app") {
	ob_start();
	?>
	<script type='text/javascript' id='test<?=$identifiant?>'>
	(function(){
		window.addEventListener( "load",
			function(e) {
				var t = $('test<?=$identifiant?>').parentNode;
				t.action<?=$identifiant?> = function(){
					//alert(this.parentNode);
					this.ajtEmtsDist( '?cible=modèle', 'GET', "nom=<?=$nom?>&<?=$attributs?>", null, null );
				}
				t.action<?=$identifiant?>();
			},
			false
		);
	})()
	</script>
	<?
	$chaineXML = ob_get_contents();
	ob_end_clean();
} else {
	ob_start();
	?>
	<script type='text/javascript' id='test<?=$identifiant?>'>
	(function(){
		var t = $('test<?=$identifiant?>');
		t.action = function(){
			//alert(this.parentNode);
			this.parentNode.ajtEmtsDist( '?cible=modèle', 'GET', "nom=<?=$nom?>&<?=$attributs?>", null, null );
		}
		t.action();
	})()
	</script>
	<?
	$chaineXML = ob_get_contents();
	ob_end_clean();
}

?>
