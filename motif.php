<?
/* 
 * Le contrôleur de modèle permet d'enchâsser différents documents html les uns dans les autres très facilement
 * A faire :
 * + lier à la configuration : dossiers
 * + segmenter en fonctions plus courtes
 * + options : cacher/grouper script ou styles, ...
 * + Gestion fine de l'encodage
 */


class Motif {
	var $app;
	var $dbg = false;
	
	function Motif( $app=false ) {										if( !$app ) { echo "erreur"; return; }
		$this->app = $app;
		
		// lier le parametre initial à la conf
	}
	
	
	// Lance la lecture d'un motif
	function lit( $motif, $attributs=array() ) {
		header( 'Content-type: text/html; charset=utf-8' );
		$dom = $this->charge($motif, $attributs);						if( !$dom ) {echo "le motif $motif n'a pas été trouvé ".sdl;return;}
		$this->scane($dom);
		$rtr = $dom->ownerDocument->saveXML( $dom );					if( !$rtr ) {echo "Le document xml n'a pas été transformé en chaine : $motif".sdl;return;}
		$rtr = $this->retireCdata( $rtr );
		// on vire manuellement l'encapsulation
		$rtr = substr( $rtr, 9, strlen($rtr)-19 );//*/
		return $rtr;
	}
	
	function cherche( $nom ) {											$t = $this; $conf = $t->app->conf;
		// cherche un modèle dans les dossiers référencés.
		$dossiers = $conf["ctrl"]["modèles"]["dossiers"];				if( !$dossiers ) {echo "pas de dossiers".sdl;return;}
		foreach( $dossiers as $dossier ) {								if( $t->dbg ) echo "cherche $nom dans $dossier".sdl;
			$tmp = incluable("$dossier/$nom.php");
			if( $tmp ) return $tmp;
		}
		// Si non trouvé, cherche 
		return incluable("$nom.php");
	}

	function charge( $modèle, $attributs=array() ) {
		global $bdd;
		$t = $this;
		$conf = $t->app->conf;
		$_SERVER['INCLUDE_SCRIPT_NAME'] = "http://".$_SERVER['HTTP_HOST']."/".$conf["racine"]."/modèles/".$modèle.".php";
		$id = "anonyme";
		// Transformation des attributs en variables php
		if( is_a( $attributs, 'DOMNamedNodeMap') )
			$attributs = $t->attrPhp($attributs);
		foreach ( $attributs as $clé => $val) {
			if( $clé == "params")
				$params = $t->attrListePhp($val);
			else
				eval("$".$clé."=\"".$val."\";");
		}
		// Le modèle doit-il être chargé de manière asynchrone ou non?
		if( isset($async) && $async == "basique") {
			// chargement asynchrone du modèle
			$id = (isset($id))? $id : "anonyme";
			$xml = $t->async( $modèle, $attributs );
			//$xml = prépareXML( $xml, $id, $modèle);
			$dom = new DomDocument('1.0', 'UTF-8');
			$dom->formatOutput = true;
			$dom->loadXML($xml);
			
		}
		else {//*/
			// chargement synchrone
			// On récupère le contenu du fichier si on a pas de code donné
			$fichier = $t->cherche($modèle);
			if( !$fichier ) return;
			// Cette opération ne peut se faire dans une fonction
			ob_start();
			include $fichier;
			$ctn = ob_get_contents();
			ob_end_clean();
			// Préparation du xml
			$xml = $t->prépareXML( $ctn, $id, $modèle);
			//echo $xml;
			$dom = new DomDocument('1.0', 'UTF-8');
			$dom->formatOutput = true;
			$dom->loadXML($xml);
			$t->scane($dom);
		}
		$dom = $dom->getElementsByTagName("modèle")->item(0);
		return $dom;
	}



	function scane( $noeud ) {
		$t = $this;
		$conf = $t->app->conf;
		if( !$noeud ) {
			echo "scane : pas de motifs".sdl;return;}
			
		if( is_a($noeud, 'DOMDocument') ) 	$dom = $noeud;
		else  								$dom = $noeud->ownerDocument;
		$conf = $this->app->conf;
		$modèles = $conf["ctrl"]["modèles"]["modèles"];					if( !$modèles ) {echo "scane : pas de motifs".sdl;return;}
		//print_r($modèles);
		foreach( $modèles as $modèle) {
			$occurences = $noeud->getElementsByTagName($modèle);
			//echo $modèle." : ".$occurences->length."\n";
			for ($j = $occurences->length-1; $j>=0 ; $j--) {
				$element = $occurences->item($j);
				// préparation du noeud à insérer
				// L'insertion se fait
				$racineModèle = $t->charge($element->nodeName, $element->attributes);
				//echo "scane\n";
				//scane($racineModèle);

				
				if( $racineModèle == null ) {
					echo "Impossible de charger ".$element->nodeName."\n";
					continue;
				}
				$racineModèle = $dom->importNode($racineModèle, true);

				// Mise en place des enfants
				$enfants = $racineModèle->getElementsByTagName("enfants")->item(0);
				if( $enfants ) {
					while( $element->childNodes->length != 0 ) {
						$enfant = $element->childNodes->item(0);
						$enfants->parentNode->insertBefore( $enfant, $enfants);
					}
					$enfants->parentNode->removeChild($enfants);						// suppression de la balise enfants
				}//*/
				
				// Insertion des noeuds contenus dans le document
				$reference = $element;
				for ($i = $racineModèle->childNodes->length-1; $i >= 0 ; $i--) {
					$tmp = $racineModèle->childNodes->item($i);
					$element->parentNode->insertBefore( $tmp, $reference );
					$reference = $tmp;
				}

				$element->parentNode->removeChild($element);						// suppression de la balise modèle
			}
		}
	}
	
	function prépareXML( $chaineXML, $id, $modèle ) {
		$t = $this;
		if( !isset($id) ) $id = "anonyme";
		$chaineXML = $t->cdataDoctype( $chaineXML);
		$chaineXML = $t->cdataEnfants( "pre", $chaineXML);
		$chaineXML = $t->cdataEnfants( "textarea", $chaineXML);
		$chaineXML = $t->cdataEnfants( "style", $chaineXML);
		$chaineXML = $t->cdataEnfants( "script", $chaineXML);
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$xml .= "<modèle>\n";
		$xml .= "<!-- ".strtoupper($modèle)." : ".$id." -->\n";
		$xml .= $chaineXML;
		$xml .= "\n<!-- FIN ".strtoupper($modèle)." : ".$id." -->\n";
		$xml .= "</modèle>\n";
		return $xml;
	}

	// Prepare un crochet xhr vers le motif voulu
	function async( $nom, $attributs) {
		// voir le sattributs en post

		include("async.php");
		$chaineXML = $t->prépareXML( $chaineXML, "async", $nom );
		//echo $chaineXML."\n";
		// $ctn .= "</modèle>\n";
		return $chaineXML;
	}


	function attrPhp($attributs) {
		// Convertit des attributs DOM en liste php.
		$rtr = array();
		foreach ($attributs as $attr)
			$rtr[$attr->nodeName] = $attr->nodeValue;
		return $rtr;
	}

	function attrListePhp( $chaineAttr ) {
		// Convertit un attribut type "border:0;width:100%;..." en liste php
		$chaines = explode( ";", $chaineAttr);
		$rtr = array();
		for ( $i = 0; $i<count($chaines); $i++) {
			if( $chaines[$i] == "" ) continue;
			$chaine = explode(":",$chaines[$i]);
			$clé = $chaine[0];
			$val = $chaine[1];
			$rtr[$clé] = $val;
		}
		return $rtr;
	}

	
	function cdataEnfants( $nom, $chaineXML ) {
		// cherche un modèle dans les dossiers référencés.
		$modèle = '/(<'.$nom.'[^>]*>)/i';
		$nouveau = '$1<![CDATA[';
		$chaineXML = preg_replace($modèle, $nouveau, $chaineXML);
		$modèle = '/(<\/'.$nom.'>)/i';
		$nouveau = ']]>$1';
		$chaineXML = preg_replace($modèle, $nouveau, $chaineXML);
		return $chaineXML;
	}
	
	
	function cdataDoctype( $chaineXML ) {
		// Protège les doctypes du traitement xml
		$modèle = '/(<!DOCTYPE [^>]*>)/i';
		$nouveau = '<![CDATA[$1]]>';
		$chaineXML = preg_replace($modèle, $nouveau, $chaineXML);
		return $chaineXML;
	}

	function retireCdata( $chaineXML ) {
		// retrait des cdata de protection (pour style et script)
		$chaineXML = str_replace( "<![CDATA[", "", $chaineXML );
		$chaineXML = str_replace( "]]>", "", $chaineXML );
		return $chaineXML;
	}

	function vireElements( $dom, $nom ) {
		$liste = $dom->getElementsByTagName($nom);
		for ($i = $liste->length-1; $i >=0; $i--) {
			$tmp = $liste->item($i);
			$tmp->parentNode->removeChild($tmp);						// suppression de la balise enfants
		}//*/
		if( $this->dbg ) {
			$liste = $dom->getElementsByTagName($nom);
			if( $liste->length != 0 ) echo "ERREUR : vireElements -> reste ".$liste->length." éléments ".$nom."\n";
		}
	}
}
?>
