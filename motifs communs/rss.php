<?/**
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
 
 // http://www.rssreader.magix-cjquery.com/

/**
 * Classiquement, un logo est une image/lien vers la
 * page d'accueil.
 * 
 * nom : logo
 * Attributs : href, id, css, txt, src
 * 
 * Ajouter vauleurs par défaut
 */

// les liens distants sont en _blank
?>

<style>
#<?=$id?> a {
	color:#BE7A40;
	font-size:12px;
}
#<?=$id?> .date {
	width: 100%;
	margin:0;
	color:#999999;
	font-size:x-small;
	letter-spacing:0.2em;
}
#<?=$id?> .description{
	width: 100%;
 	margin:0;
 	padding:0;
}
#<?=$id?> .description p{
	font-size:10px;
}
#loading{
	margin-top: 30%;
	margin-left: 40%;
	float:left;
}
</style>


<div id="<?=$id?>">&nbsp;
</div>
<js><!--

$(function(){
	var conteneur = $('#<?=$id?>');
	
    var o = function (a, b) {
        var c = a.split(/\s/);
        if (c.length <= b) return a;
        var d = '';
        for (var i = 0; i < b; i++) {
            d += c[i] + ' '
        }
        return d
    }
    
    var avant = function () {
		conteneur.css({
			//backgroundColor: '#ccc',
			'z-index': 90,
			'opacity': 0.4
		});
		$('<img id="loading" src="' + 'demo/ext/rssreader/chargement.gif' + '" alt="Traitement en cours ..." />').css({
			'opacity': 1
		}).appendTo(conteneur);
	}
    
	var affiche = function( titre, date, lien, texte) {
		conteneur.css({
			//backgroundColor: '#fff',
			'opacity': 1
		});
		$('#<?=$id?> img').remove();
		
		return '<a target="_blank" href="' + lien + '">' + titre + '</a>' +
				'<div class="date">' + date + '</div>' +
				'<div class="description">' + o(texte, 80) + '...</div>';
	}
	
	conteneur.rssReader({
			targeturl: 'demo/ext/rssreader/rss.php',
			max: 3,
			init : avant,
			succes : affiche
	});
});
//*/
--></js>

