<?
/* Ce modèle définit une zone de code syntaxhighlight
 * 
 */
?>

<a href="#" id="cacher-<?=$id;?>">Plier / Déplier</a> 
<pre id="<?=$id;?>" class="brush: <?=$lang;?>">
	<enfants/>
</pre>
<js>
$(document).ready(function(){
	$("#cacher-<?=$id;?>").click(function(){
		$("#<?=$id;?>").slideToggle("slow");
	});
});
</js>
