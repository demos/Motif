<?
/*
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
 * 
 *  
 * Le contrôleur de modèle permet d'enchâsser différents documents html les uns dans les autres très facilement
 * A faire :
 * + segmenter en fonctions plus courtes
 * + options : cacher/grouper script ou styles, ...
 * + Gestion fine de l'encodage
 */

/*
function erreurs($no, $msg, $fichier, $ligne, $context) {
	print_r( $context );
	
	//throw new DomException($msg);
}
set_error_handler("erreurs");
//*/

class Motif {
	var $dbg = false;
	var $conf;
	var $motifs;
	
	function Motif( $conf=false ) {										$t = $this;
		$t->conf = $conf;
		$t->motifs = $t->chargeMotifs($conf["dossiers"]);
		//print_r($t->motifs);
		// lier le parametre initial à la conf
	}
	
	
	// Lance la lecture d'un motif
	function lit( $motif, $attributs=array() ) {						$t = $this; $conf = $t->conf;
		header( 'Content-type: text/html; charset=utf-8' );
		$dom = $t->charge($motif, $attributs);							if( !$dom ) { $t->log("le motif $motif n'a pas été trouvé ");return;}
		$t->scane($dom);
		$rtr = $dom->ownerDocument->saveXML( $dom );					if( !$rtr ) { $t->log("Le document xml n'a pas été transformé en chaine : $motif"); return;}
		$rtr = $t->retireCdata( $rtr );
		// on vire manuellement l'encapsulation
		$rtr = substr( $rtr, 8, strlen($rtr)-17 );//*/
		$rtr = htmlspecialchars_decode( $rtr );
		return $rtr;
	}
	
	function cherche( $nom ) {											$t = $this; $conf = $t->conf;
		// cherche un modèle dans les dossiers référencés.
		$dossiers = $conf["dossiers"];									if( !$dossiers ) {$t->log("pas de dossiers");return;}
		foreach( $dossiers as $dossier ) {								$t->log( "cherche $nom dans $dossier" );
			$tmp = incluable("$dossier/$nom.php");
			if( $tmp ) return $tmp;
		}
		// Si non trouvé, cherche 
		return incluable("$nom.php");
	}
	
	function chargeMotifs($dossier){									$t = $this; $conf = $t->conf;
		$dossiers = $conf["dossiers"];									if( !$dossiers ) {$t->log("pas de dossiers de motifs");return;}
		$motifs = array();
		foreach( $dossiers as $dossier ) {								$t->log( "charge les motifs de dans $dossier" );
			$rtr = $t->chargeDossierMotifs($dossier);
			$motifs = array_merge( $motifs, $rtr);
		}
		return $motifs;
	}
	
	function chargeDossierMotifs($dossier){								$t = $this; $conf = $t->conf;
		$rtr = array();
		$monDossier = opendir($dossier)									or $t->err( "cherche $nom dans $dossier" );
		while($entrée = @readdir($monDossier)) {
			if( $entrée == '.' || $entrée == '..' );
			else if( is_dir($dossier.'/'.$entrée) );
				// Pas de traitement récursif pour l'instant
			else {
				$tmp = explode(".", $entrée);
				if( $tmp[count($tmp)-1] == "php" && $tmp[0] != "motif" )
					$rtr[] = $tmp[0];
			}
		}
		closedir($monDossier);
		return $rtr;
	}


	function charge( $modèle, $attributs=array() ) {					$t = $this; $conf = $t->conf;
		//$_SERVER['INCLUDE_SCRIPT_NAME'] = "http://".$_SERVER['HTTP_HOST']."/".$conf["racine"]."/modèles/".$modèle.".php";
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
			//$fichier = incluable("$modèle.php");
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
			//$dom->validateOnParse = true;
			//$dom->substituteEntities = true;
			//$dom->strictErrorChecking = false;
			$tmp = $dom->loadXML($xml);
			if( !$tmp ) {
				echo "<pre>";
				echo "$modèle\n";
				echo $xml;
				echo "</pre>";
				$xml = $t->cdataEnfants( "style", $xml);
				$xml = $t->cdataEnfants( "script", $xml);
				$dom->loadXML($xml);
			}
			$t->scane($dom);
		}
		$dom = $dom->getElementsByTagName("motif")->item(0);
		return $dom;
	}



	function scane( $noeud ) {											$t = $this; $conf = $t->conf;
																		if( !$noeud ) { $t->log( "scane : pas de motifs" );return;}
		// 
		if( is_a($noeud, 'DOMDocument') ) 	$dom = $noeud;
		else  								$dom = $noeud->ownerDocument;
		
		$modèles = $t->motifs;											if( !$modèles ) {$t->log( "scane : pas de motifs" );return;}
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
		//$chaineXML = $t->cdataEnfants( "pre", $chaineXML);			// sur la sellette
		$chaineXML = $t->cdataEnfants( "textarea", $chaineXML);
		$chaineXML = $t->preserveEntités( $chaineXML );
		//$chaineXML = $t->cdataEnfants( "style", $chaineXML);
		//$chaineXML = $t->cdataEnfants( "script", $chaineXML);
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		//$xml .= "<!DOCTYPE motif PUBLIC \"-//W3C//DTD MOTIF 1.1//EN\" \"test.dtd\">\n";
		$xml .= "<motif>\n";
		$xml .= "<!-- ".strtoupper($modèle)." : ".$id." -->\n";
		$xml .= $chaineXML;
		$xml .= "\n<!-- FIN ".strtoupper($modèle)." : ".$id." -->\n";
		$xml .= "</motif>\n";
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
		// Passe le contenus des elements de type $nom en cdata
		$modèle = '/(<'.$nom.'[^>]*>)/i';
		$nouveau = '$1<![CDATA[';
		$chaineXML = preg_replace($modèle, $nouveau, $chaineXML);
		$modèle = '/(<\/'.$nom.'>)/i';
		$nouveau = ']]>$1';
		$chaineXML = preg_replace($modèle, $nouveau, $chaineXML);
		return $chaineXML;
	}

	// Echappe les caractères clés html (a finir)
	function htmlEnfants( $nom, $chaineXML ) {
		// Passe le contenus des elements de type $nom en cdata
		$modèle = '/(<'.$nom.'[^>]*>)(.*)(<\/'.$nom.'>)/i';
		$nouveau = '$1'.'$2'.'$3';
		$chaineXML = preg_replace($modèle, $nouveau, $chaineXML);
		return $chaineXML;
	}//*/
	
	
	function cdataDoctype( $chaineXML ) {
		// Protège les doctypes du traitement xml (inclusion dans un cdata)
		$modèle = '/(<!DOCTYPE [^>]*>)/i';
		$nouveau = '<![CDATA[$1]]>';
		$chaineXML = preg_replace($modèle, $nouveau, $chaineXML);
		return $chaineXML;
	}

	function preserveEntités( $chaineXML ) {
		// remplace les & pour ne pas cause de soucis d'entités avec xml
		$chaineXML = str_replace( "&", "&amp;", $chaineXML );
		return $chaineXML;
	}
	
	function retireCdata( $chaineXML ) {
		// retrait des cdata de tout le document
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
		$reste = $dom->getElementsByTagName($nom)->length;				if( $reste != 0 ) $t->log("vireElements -> reste ".$reste." éléments ".$nom);
	}
	
	// Fonctions de debeug
	function log( $msg ) {
		if( $this->dbg ) echo "LOG : ".$msg.sdl;
	}
	
	function err( $msg ) {
		echo "ERR : ".$msg.sdl;
		die();
	}
	
}
?>
