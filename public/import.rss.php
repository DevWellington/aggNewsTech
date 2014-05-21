<?php 

require_once "../../lib/conexao.pdo.php";
require_once "../lib/conexao.pdo.php";



$linkRSS = "https://news.google.com/news/feeds?cf=all&ned=pt-BR_br&hl=pt-BR&topic=t&output=rss&num=30";
$xmlFile = simplexml_load_file($linkRSS);

$cxPDO = connPDO::getInstance();

foreach($xmlFile->channel->item as $item) {

	try {
	    // $stmt = $cxPDO->prepare("INSERT INTO news (title, link, guid, category, pubDate, description) 
	    						 // VALUES (:title, :link, :guid, :category, :pubDate, :description)");

    	$auxPubDate = substr($item->pubDate, 5);
    	$auxPubDate = explode(' ', $auxPubDate);
	 	$monthInt = date_parse($auxPubDate[1]);

    	$pubDate_MySQL = $auxPubDate[2]."-".$monthInt['month']."-".$auxPubDate[0]." ".$auxPubDate[3];


		$sql = "INSERT INTO news (title, link, guid, category, pubDate, description, pubDateServer) 
	    						  VALUES ('".$item->title."', '".$item->link."', '".$item->guid."', 
	    						  		  '".$item->category."', '".$pubDate_MySQL."', '".$item->description."', now())";

		$stmt = $cxPDO->prepare($sql);

	    $return = $stmt->execute();

	} catch ( PDOException $e ) {
	    echo $e->getMessage ();
	}	

}

// fecho o banco
$cxPDO = null;


