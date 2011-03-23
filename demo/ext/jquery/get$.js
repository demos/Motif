(function($) {
	// retourne l'identifiant css le plus précis possible
	$.fn.$ = function() {
		// ajouter identifieur css ou xpath
		
		var rtr = this.attr('tagName');
		rtr += "#"+this.attr('id');
		rtr += "."+this.attr('class');
		
		//return rtr;
		return "";
	}
})(jQuery);