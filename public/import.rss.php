<!DOCTYPE html>
<?php 

require_once "../lib/conexao.pdo.php";


 $arReturn = array(
 	// 'ID' => array(),
 	'title' => array(),
 	'link' => array(),
 	'guid' => array(), 
 	'category' => array(), 
 	'site' => array(), 
 	'pubDate' => array(),
 	'linkImg' => array(),
 	'pubDateServer' => array(),
 	'descriptionNew' => array(),
 	'description' => array()
);


$linkRSS = "https://news.google.com/news/feeds?cf=all&ned=pt-BR_br&hl=pt-BR&topic=t&output=rss&num=30";
$xmlFile = simplexml_load_file($linkRSS);

// $cxPDO = connPDO::getInstance();

foreach($xmlFile->channel->item as $item) {

	try {
	    // $stmt = $cxPDO->prepare("INSERT INTO news (title, link, guid, category, pubDate, description) 
	    						 // VALUES (:title, :link, :guid, :category, :pubDate, :description)");


    	$ar = explode(' - ', $item->title);
    	$site = $ar[count($ar) - 1];

    	$link = substr($item->link, strrpos($item->link, 'url=') + 4);

    	$auxImg = substr($item->description, strrpos($item->description, '<img src="') + 10);
    	$linkImg = substr($auxImg, 0, strrpos($auxImg, '" alt'));

    	$auxDN = substr($item->description, strrpos($item->description, '</b></font><br /><font size="-1">') + 33);
    	$descriptionNew = substr($auxDN, 0, strrpos($auxDN, '.</font>'));

    	$auxPubDate = substr($item->pubDate, 5);
    	$auxPubDate = explode(' ', $auxPubDate);
	 	$monthInt = date_parse($auxPubDate[1]);

    	$pubDate_MySQL = $auxPubDate[2]."-".$monthInt['month']."-".$auxPubDate[0]." ".$auxPubDate[3];


    	array_push($arReturn['title'], (string) $item->title);
    	array_push($arReturn['link'], $link);
    	array_push($arReturn['guid'], (string) $item->guid);
    	array_push($arReturn['category'], (string) $item->category);
    	array_push($arReturn['site'], $site);
    	array_push($arReturn['pubDate'], (string) $item->pubDate);
    	array_push($arReturn['description'], (string) $item->description);
    	array_push($arReturn['pubDateServer'], $pubDate_MySQL);
    	array_push($arReturn['linkImg'], $linkImg);
    	array_push($arReturn['descriptionNew'], $descriptionNew);


    	// var_dump($item->title);
    	// echo $item->title;



		// $sql = "INSERT INTO news (title, link, guid, category, pubDate, description, pubDateServer) 
	 //    						  VALUES ('".$item->title."', '".$item->link."', '".$item->guid."', 
	 //    						  		  '".$item->category."', '".$pubDate_MySQL."', '".$item->description."', now())";

		// $stmt = $cxPDO->prepare($sql);

	 //    $return = $stmt->execute();

	} catch ( PDOException $e ) {
	    echo $e->getMessage ();
	}	

}

// fecho o banco
$cxPDO = null;


var_dump($arReturn);