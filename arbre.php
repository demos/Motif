<style>
.dhtmlgoodies_tree img {
	position : relative;
}
#dragDropIndicatorImage {
	position : static;
}

#arbre-flèche {
	font-size: 12px;
	line-height: 18px;
}
</style>
<form>
	<input type="button" onclick="saveMyTree()" value="Save"/>
</form>
<onglets id="test" css="test" params="depart:/admin/contenu/modèles/;"/>
<a href="#" onclick="treeObj.collapseAll()">Tout plier</a> | 
<a href="#" onclick="treeObj.expandAll()">Tout déplier</a> | 
<ul id="dhtmlgoodies_tree2" class="dhtmlgoodies_tree">
	<li id="node0" noDrag="true" noSiblings="true" noDelete="true" noRename="true"><a href="#">#</a>
		<ul>
			<li id="node1"><a href="#">Actualité</a></li>
			<li id="node2"><a href="#">Projets</a></li>
			<li id="node3"><a href="#">Agence</a></li>
			<li id="node4"><a href="#">Publications</a></li>
			<li id="node5"><a href="#">Contact</a></li>
			<li id="node6"><a href="#">Admin</a>
				<ul>
					<li id="node7" noDelete="true"><a href="#">Contenu</a>
						<ul>
							<li id="node8" noRename="true"><a href="#">Document 1</a></li>
							<li id="node9"><a href="#">Document 2</a></li>
							<li id="node10"><a href="#">Document 3</a></li>
						</ul>
					</li>
					<li id="node11"><a href="#">Rôles</a></li>
					<li id="node12"><a href="#">Configuration</a></li>
					<li id="node13"><a href="#">Aide</a></li>
				</ul>
			</li>
			<li id="node24" noChildren="true"><a href="#">Ne peut avoir d'enfant</a></li>
			<li id="node25" noDrag="true"><a href="#">Ne peut être déplacé</a></li>
		</ul>
	</li>
</ul>
<script type="text/javascript">
(function(){

//<a href="" onclick="test()">Lance</a>

	try {
		$("test").ajoute("test", "test");
		
		
		window.treeObj = new JSDragDropTree();
		treeObj.setTreeId('dhtmlgoodies_tree2');
		treeObj.setImageFolder('../../images/arbre/');
		treeObj.setMaximumDepth(7);
		treeObj.setMessageMaximumDepthReached('Maximum depth reached'); // If you want to show a message when maximum depth is reached, i.e. on drop.
		treeObj.initTree();
		treeObj.expandAll();
			
			
		
	}
	catch( e ) {
		//erreur(e, "modèles/arbre.php");
	}
})()// Ne pas mettre de ";" ici sinon webkit trouve une erreur de syntaxe
</script>

<script type="text/javascript">
</script>
