<?
/* Ce modèle définit une zone de code syntaxhighlight
 * 
 */

if( isset($params) && isset($params["caché"]) && $params["caché"] == true )
	$style = "style=\"display:none;\"";
else
	$style = "";
?>

<a href="#" id="cacher-<?=$id;?>">Plier / Déplier</a> 
<div id="<?=$id;?>" <?=$style?> >
	<pre class="brush: <?=$lang?>">
		<enfants/>
	</pre>
</div>
<js>
$(document).ready(function(){
	$("#cacher-<?=$id;?>").click(function(){
		$("#<?=$id;?>").slideToggle("slow");
	});
});
</js>
