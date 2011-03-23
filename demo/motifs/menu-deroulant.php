<style>

#titre-<?=$id?> {
	width: 150px;
}

#corps-<?=$id?> {
	width: 300px;
	padding: 0;
	position : absolute;
}

#corps-<?=$id?> li {
	list-style: none;
	padding: 0;
}

</style>
<div id="<?=$id?>" class="<?=$css?>">
	<a href="<?=$href?>" id="titre-<?=$id?>"><?=$titre?></a>
	<ul id="corps-<?=$id?>">
		<enfants/>
	</ul>
</div>
<js>

$(function(){
	var menus = $('#menus');
	var menu = $('#<?=$id;?>');
	var titre = $('#titre-<?=$id;?>');
	var corps = $('#corps-<?=$id?>');
	
	jQuery.fn.isChildOf = function( parent ) {
		var enfant = this;
		$(this).parents().each( function(i) {
			if ( this === parent[0] ) {
				//console.debug(parent[0]+" : "+this+" EST parent de "+enfant[0]);
				return true;
			}
			//console.debug(parent[0]+" : "+this+" n'est pas parent de "+enfant[0]);
		});
		return false;
	}
	
	titre.mouseover( function() {
		//corps[0].style.left = (menu[0].offsetLeft - 2/3*menu[0].offsetWidth)+"px";	//bidouille
		corps[0].style.left = menu[0].offsetLeft+"px";
		corps[0].style.top = (menu[0].offsetTop)+"px";
		$(this).css("color", "#BE7A40");
		corps.slideDown('medium'); 
	});
	
	/*menu[0].addEventListener(
		"mouseover",
		function (e) {
			e.stopPropagation();
			e.preventDefault();
			return false;
		},
		false);//*/
	menu.mouseover(
		function (e) {
			e.stopPropagation();
			e.preventDefault();
			return false;
		},
		false);//*/
	
	menus.parent().mouseover(function (e) {
		//console.log(e.target);
		//console.log(e.currentTarget);
		corps.slideUp('medium'); 
		titre.css("color", "#000");
	});

	//corps[0].style.left = (menu[0].offsetLeft - 2/3*menu[0].offsetWidth)+"px";	//bidouille
	corps[0].style.left = menu[0].offsetLeft+"px";
	corps[0].style.top = (menu[0].offsetTop)+"px";
	
});

</js>