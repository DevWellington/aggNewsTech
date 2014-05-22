<!DOCTYPE html>
<?php 

require_once "../../lib/conexao.pdo.php";
require_once "../../lib/twitter.class.php";

$arReturn = array();

$linkRSS = "https://news.google.com/news/feeds?cf=all&ned=pt-BR_br&hl=pt-BR&topic=t&output=rss&num=30";
$xmlFile = simplexml_load_file($linkRSS);

foreach($xmlFile->channel->item as $item) {

    try {

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

        array_push($arReturn, array(
            'title' => (string) $item->title,
            'link' => $link,
            'guid' => (string) $item->guid,
            'category' => (string) $item->category,
            'site' => $site,
            'pubDate' => (string) $item->pubDate,
            'linkImg' => $linkImg,
            'pubDateServer' => $pubDate_MySQL,
            'descriptionNew' => $descriptionNew,
            'description' => (string) $item->description
        ));

	} catch ( PDOException $e ) {
	    echo $e->getMessage ();
	}	

}

echo "<pre>";
// var_dump($arReturn);
$cxPDO = connPDO::getInstance();

foreach ($arReturn as $field => $item) {

    $obj = (object) $item;

    $stmt = $cxPDO->prepare("INSERT INTO tbl_newsTech (title, link, guid, category, site, 
                                                        pubDate, description, pubDateServer,
                                                        linkImg, descriptionNew, dt_import) 

                             VALUES (:title, :link, :guid, :category, :site, 
                                     :pubDate, :description, :pubDateServer, 
                                     :linkImg, :descriptionNew, now())");

    $stmt->bindParam(':title', $obj->title);
    $stmt->bindParam(':link', $obj->link);
    $stmt->bindParam(':guid', $obj->guid);
    $stmt->bindParam(':category', $obj->category);
    $stmt->bindParam(':site', $obj->site);
    $stmt->bindParam(':pubDate', $obj->pubDate);
    $stmt->bindParam(':description', $obj->description);
    $stmt->bindParam(':pubDateServer', $obj->pubDateServer);
    $stmt->bindParam(':linkImg', $obj->linkImg);
    $stmt->bindParam(':descriptionNew', $obj->descriptionNew);

    $return = $stmt->execute();

    if ($return){
        echo $obj->title.PHP_EOL;

        $reply = Twitter::sendTweet($obj);
        echo "\t\t<strong> ".$reply."</strong>\n";


        $lastID = $cxPDO->lastInsertId('title');

        $st = $cxPDO->prepare("INSERT INTO logTweets (user, idtbl_newsTech, dtSendTweet) 
                                 VALUES ('DevWellington', :idtbl_newsTech, now())");

        $st->bindParam(':idtbl_newsTech', $lastID);
        $st->execute();

        $rInsLog = $st->errorInfo();
        if ($rInsLog[2] !== NULL){
            echo "Erro ao gravar o Log! \n";
        }

    } else {

        $arError = $stmt->errorInfo();
        echo "ERROR - ".$arError[2].PHP_EOL;
    }

    flush();
    ob_flush();

}
echo "</pre>";
// fecho o banco
$cxPDO = null;

