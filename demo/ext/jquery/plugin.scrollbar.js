/* ********** Plugin JQuery ************* */
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
 */
/* ******** NECESSITE *********** */
/* ******************************** 
jquery-1.4.2.min.js
ui.core-1.7.2.js
ui.draggable-1.7.2.js
jquery.mousewheel.min.js
******************************** */

(function($) {
	$.fn.scrollbar = function(params) {
		/*
		 * A faire
		 * + desactiver selection
		 * + focus sur curseur textuel
		 * + axes x et y
		 * + sortir le thème de l'abstraction
		 * + Modification de la barre si changement du contenu
		 * + compatibilité avec barres natives
		 * 
		 * + optimiser blocage scroll si block avec barres en enfant
		 * + marges sur la barre
		 */
		// Fusionner les paramètres par défaut et ceux de l'utilisateur
		params = $.extend( {
			axe : 'x',
			bouton:'<div>&nbsp;</div>',
			scrollbar:'<div></div>',
			style_bouton:{
				'background':'#cda042',
				'cursor':'pointer',
				'height':'50%',
				'width':'100%',
				//'max-height':'30px',
				'min-height':'5px'
			},
			style_barre:{
				'background':'#ebd9b3',
				'width':'5px'
			},
			pas:30,										//Pas du scroll molette - /!\ Doit être un nombre ou 'auto'
			molette: true,								//Détection du scroll molette - /!\ true ou false
			drag: true,									//Bouton de la scrollbar déplacable à la souris - /!\ true ou false
			debug: true,								//Afficher la console de debug - /!\ true ou false
			bord:'droite',								//
			orientation: 'vertical'						//Orientation du contenu, 'vertical' ou 'horizontal'
		}, params);
		
		var pos = 0;
		
		
		return this.each(function(i) {
			var $$ = $(this);
			var scrollbar = null;
			var bouton = null;
			var conteneur = this;
            var hauteur_contenu = this.scrollHeight;
			var hauteur_conteneur = this.offsetHeight;
			var ratio = 0;
			var intervale = this.offsetHeight;
			
			var style_base_barre = {
				'position':'absolute',
				'overflow':'hidden'
			};
			var style_base_bouton = {
				'top':0+'px'
			};
			var style_base_conteneur = {
				'overflow':'hidden'
			}
			
			
			$$.css( style_base_conteneur );
			
			var dbg = function( id, val ){
				if( !id ) alert(val);
				if( params.debug ) $("#"+id).html( val );
			}
			
			var verifie = function( ){
			//	if( hauteur_contenu != conteneur.scrollHeight )
					init();
				
			}
			
			
			//Fonction de calcul du déplacement du bouton
			var place = function( ){
				verifie();
				conteneur.scrollTop = ratio * (hauteur_contenu - hauteur_conteneur);
				bouton.css({'top': ratio * intervale + "px"});
				dbg("hauteurscrollbar", 'Hauteur du scroll : '+ conteneur.scrollTop);
				dbg("conteneur",  'Conteneur : '+ conteneur.id );
				dbg("intervale",  'Intervale : '+ intervale );
				dbg("hauteurcontenu",  'Hauteur du contenu : '+ hauteur_contenu );
				dbg("hauteurenglobe", 'Hauteur du conteneur : '+ hauteur_conteneur );
			}

			var cree_barre = function() {
				hauteur_contenu = conteneur.scrollHeight;
				intervale = hauteur_conteneur = conteneur.offsetHeight;
				// Création des éléments
				scrollbar = $(params.scrollbar);
				bouton = $(params.bouton);
				bouton.appendTo(scrollbar);
				$(conteneur).after( scrollbar );
				// Style permanent de la barre
				scrollbar.css( style_base_barre );
				scrollbar.css( params.style_barre );
				// Style permanent du bouton
				bouton.css( style_base_bouton );
				bouton.css( params.style_bouton );
			}

			
			var init = function() {
				hauteur_contenu = conteneur.scrollHeight;
				intervale = hauteur_conteneur = conteneur.offsetHeight;
				dbg("intervale",  'Intervale : '+ intervale );
				dbg("hauteurcontenu",  'Hauteur du contenu : '+ hauteur_contenu );
				dbg("largeurcontenu",  'Largeur du contenu : '+ conteneur.offsetWidth );
				dbg("hauteurenglobe", 'Hauteur du conteneur : '+ hauteur_conteneur );
				scrollbar.css( {
					'top': conteneur.offsetTop + 'px',
					'height': hauteur_conteneur
				} );
				bouton.css( {
					'height': hauteur_conteneur*hauteur_conteneur/hauteur_contenu+"px"
				} );
				if ( params.axe == 'x' ){
					switch ( params.bord ) {
						case 'droite':
							scrollbar.css({
								'left': ( conteneur.offsetLeft + conteneur.offsetWidth ) + 'px'
							});
						break;
						case 'gauche':
							scrollbar.css({
								'left': conteneur.offsetLeft + 'px'
							});
						break;
					}
				}
				intervale -= bouton[0].offsetHeight;
			}
			
			//Au redimensionnement de la fenetre
			$(window).resize (function( e ) {
				//init();
				place();
			});
			
			/*conteneur.onchange = function( e ) {
				init();
				place();
			};//*/
			
			//On construit la scrollBar
			cree_barre();
			init();
			
			
			conteneur.onmousemove = function( e ) {
				//alert('plop');
				//var cible = getSelection().focusNode;
				
				//$("#tmp").html( 'Temp : '+ cible );
				
			}
			
			bouton.mousedown(function( e ) {
				//var sel = getSelection();
				//sel.setSelectionRange(0,0);
			});
			
			// Glisser/déposer
			if(params.drag){
				bouton.draggable({ 
					containment: 'parent',
					axis: 'y',
					start:function(){},
					drag: function(event, ui) {
						//ui.position.top est la valeur renvoyé par le plugin JQuery UI
						ratio = ui.position.top / intervale;
						place();
						dbg('ratio', 'Ratio : '+ ratio );
					},
					stop: function(){}
				});
			}
			
			var scrollable = function( emt, pas ) {
				if( $(emt).css("overflow") == 'visible' )				// sous chrome, certains blocs non scrollables peuvent avoir
					return false;										// scrollHeight > offsetHeight
				if( emt.scrollHeight > emt.offsetHeight ) {
					if( pas > 0 && emt.scrollTop == 0 ) return false;
					if( pas < 0 && emt.scrollTop == emt.scrollHeight - emt.offsetHeight )
						return false;
					return true;
				}
				return false;
			}
			
			// Molette
			if(params.molette){
				var molette = function( e, delta) {
					//dbg( 'tmp', 'Cible : '+ e.target.tagName + " " + e.target.id );
					dbg( 'tmp', 'Delta : '+ delta );

					var rtr = $( e.target ).parents().map(function(){
						if( scrollable(this) ) {
							return this;
						}
					}).get();
					var cible = rtr[0];
					//$("#tmp")[0].innerHTML = rtr.length;
					dbg( 'cible', 'Cible : '+ $(cible).$() );

					// Si le bloc courant (conteneur) continet des blocs scrollables
					// on ne faut rien
					// prendre en compte la molette sur la barre
					if( e.target == conteneur );
					else if( e.target != conteneur && scrollable( e.target, delta ) )
						return false;
					else if( cible != conteneur && scrollable( cible, delta ) )
						return false;
					
					// Si ce n'est pas le cas, on annule le scroll normal
					// et on effectue le notre
					e.preventDefault();
					
					ratio -= delta * params.pas / conteneur.scrollHeight;
					ratio = ( ratio < 0 )? 0 : ratio;
					ratio = ( ratio > 1 )? 1 : ratio;
					place();
					dbg('ratio', 'Ratio : '+ ratio );
				};
				$$.mousewheel ( molette );
				scrollbar.mousewheel ( molette );
			}
			
			
			//Affiche la console de debug
			if(params.debug && !$("#ratio")[0] ){
				$(this).after('<div id="debug"></div>');
				$('#debug').css({'position':'fixed','top':'200px','right':'100px', 'border':'2px solid #EF9700','background':'#FFDC9F','padding':'0px'})				
				.append('<p id="tmp">Temp : </p>')
				.append('<p id="ratio">Ratio : ' + ratio + '</p>')
				.append('<p id="intervale">Intervale : ' + intervale + '</p>')
				.append('<p id="conteneur">Conteneur : ' + conteneur.id + '</p>')
				.append('<p id="cible">Cible : </p>')
				.append('<p id="largeurcontenu">Largeur du contenu : '+conteneur.offsetWidth+'</p>')
				.append('<p id="hauteurcontenu">Hauteur du contenu : ' + hauteur_contenu + '</p>')
				.append('<p id="hauteurenglobe">Hauteur du conteneur : '+ hauteur_conteneur +'</p>')
				.append('<p id="hauteurscrollbar">Hauteur du scroll : '+this.scrollTop+'</p>')
				.append('<p id="hauteurbouton">Hauteur du bouton:'+params.taille_bouton+'</p>')
				.append('<p id="topbouton">Top du bouton:'+$('#bouton').css('top')+'</p>')
				.children().css({'margin':'0','padding':'5px'});
				
				//Fonction de mise à jour des infos de la console de debug
				function affiche_position(){
					$("#ratio").html( 'Ratio : '+ ratio );
					$("#hauteurbouton").html('Hauteur du bouton:'+ params.taille_bouton );
					$("#topbouton").html('Top du bouton:'+$('#bouton').css('top'));
				}
			}	
			//*/
        });
	}
})(jQuery);
