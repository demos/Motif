<?php
//chdir("../../../");
//include "demo/ext/feedcreator/include/convertflux.php";

class rssReader{
	public $url;
	function __construct(){
		$this->url = $url;
	}
	public function loadRssDomaine($url){
		
		//header('content-type: application/atom+xml');
		return file_get_contents($url);
	}
}
print rssReader::loadRssDomaine('https://github.com/demos/Motif/commits/master.atom');
//print rssReader::loadRssDomaine('http://www.rssreader.magix-cjquery.com/class.rssReader.php');

?>