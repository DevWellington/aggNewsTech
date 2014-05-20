	<meta http-equiv="refresh" content="600">

<?php 

require_once "../lib/conexao.pdo.php";


$linkRSS = "https://news.google.com/news/feeds?cf=all&ned=pt-BR_br&hl=pt-BR&topic=t&output=rss";
$xmlFile = simplexml_load_file($linkRSS);

foreach($xmlFile->channel->item as $item) {


	$cxPDO = connPDO::getInstance();

	try {

	    // $stmt = $cxPDO->prepare("INSERT INTO news (title, link, guid, category, pubDate, description) 
	    						 // VALUES (:title, :link, :guid, :category, :pubDate, :description)");
		$sql = "INSERT INTO news (title, link, guid, category, pubDate, description) 
	    						  VALUES ('".$item->title."', '".$item->link."', '".$item->guid."', 
	    						  		  '".$item->category."', '".$item->pubDate."', '".$item->description."')";

		$stmt = $cxPDO->prepare($sql);

		// $stmt->bindParam(':title', $item->title);
		// $stmt->bindParam(':link', $item->link);
		// $stmt->bindParam(':guid', $item->guid);
		// $stmt->bindParam(':category', $item->category);
		// $stmt->bindParam(':pubDate', $item->pubDate);
		// $stmt->bindParam(':description', $item->description);

	    $stmt->execute();
	    // fecho o banco
	    $cxPDO = null;
	    // tratamento da exeção
	} catch ( PDOException $e ) {
	    echo $e->getMessage ();
	}	


// 	echo $item->title . PHP_EOL;
// 	echo $item->link . PHP_EOL;
// 	echo $item->guid . PHP_EOL;
// 	echo $item->category . PHP_EOL;
// 	echo $item->pubDate . PHP_EOL;
// 	echo $item->description . PHP_EOL;

}


$cxPDO = connPDO::getInstance();

try {

    $stmt = $cxPDO->prepare("select * from gnewstech.news order by pubDate desc");
 	// $stmt->bindParam(':lmt', $var, PDO::PARAM_STR); 

    if ($stmt->execute()){

	    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)){

	    	$ar = explode(' - ', $obj->title);
	    	$site = $ar[count($ar) - 1];

	    	echo "<h3>Site: ".$site." </h3>";
	    	echo "<p>Data Publicacao: ".$obj->pubDate."<br />";
	    	echo "<a href='".$obj->link."'>";
	    	echo "<strong>" . $obj->title . "</strong></a><br /><br />";
	    	// echo "<p>".$obj->description;

	        // echo "<b>Title:</b> " . $obj->title . " - <b>link:</b> " . $obj->link."</br>";
	    }
	} else{

		var_dump('Falha ao Obter os Dados !');
	}
    // fecho o banco
    $cxPDO = null;
    // tratamento da exeção
} catch ( PDOException $e ) {
    echo $e->getMessage ();
}	
