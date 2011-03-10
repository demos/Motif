<?
/* Ce modèle définit une zone de code syntaxhighlight
 * 
 */
?>

<a href="#" id="cacher-<?=$id;?>">Plier / Déplier</a> 
<div id="<?=$id;?>">
<pre class="brush: <?=$lang;?>">
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
