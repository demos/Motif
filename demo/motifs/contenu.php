<?
/* Décrit le cadre d'affichage du contenu
 * 
 */
if( !isset($css) ) $css="";

?>

<style>
	#<?=$id?> {
		overflow: auto;
	}
</style>

<div id="<?=$id?>" class="<?=$css?>">
	<div style="width:80%; margin-left:10%; text-align: left;">
		<enfants/>
	</div>
</div>

