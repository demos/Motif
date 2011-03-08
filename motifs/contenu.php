<?
/* Ce modèle définit une div activable ou non selon l'url
 * 
 */
?>

<style>

#<?=$id?> {
	border-bottom: 1px solid #000;
	height: 80%;
	text-align: center;
	background-color: #bbb;
	overflow: auto;
}

</style>

<div id="<?=$id?>" class="<?=$css?>">
	<div style="width:80%; margin-left:10%; text-align: left;">
		<enfants/>
	</div>
</div>

