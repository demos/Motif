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
?>
<style>
ul#<?=$id?> {
    font: bold 11px arial, sans-serif;
    list-style-type: none;
    padding-bottom: 22px;
    border-bottom: 1px solid #000;
    margin: 0;
    padding-left: 230px;
}

ul#<?=$id?> li {
    float: left;
    height: 21px;
    background-color: #000;
    margin-top: 0;
    margin-bottom: 0;
    margin-left: 2px;
    margin-right: 2px;
    border: 1px solid #000;
}

ul#<?=$id?> li.active {
    border-bottom: 1px solid #535353;
    background-color: #535353;
}

ul#<?=$id?> li.active a {
    color: #ccc;
}

#<?=$id?> a {
    float: left;
    display: block;
    color: #666;
    text-decoration: none;
    padding-top: 4px;
    padding-bottom: 4px;
    padding-left: 20px;
    padding-right: 20px;
}

#<?=$id?> a:hover {
	color: #BE7A40;
}
</style>


<ul id="<?=$id?>">
	<enfants/>
</ul>