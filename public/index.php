<meta http-equiv="refresh" content="600">

<?php 

require_once "../lib/conexao.pdo.php";


// class generate {

function html_to_obj($html) {
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    return element_to_obj($dom->documentElement);
}

function element_to_obj($element) {
    $obj = array("tag" => $element->tagName);
    foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
    }
    foreach ($element->childNodes as $subElement) {
        if ($subElement->nodeType == XML_TEXT_NODE) {
            $obj["html"] = $subElement->wholeText;
        }
        else {
            $obj["children"][] = element_to_obj($subElement);
        }
    }
    return $obj;
}
	

 $arReturn = array(
 	'ID' => array(),
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


try {

	$cxPDO = connPDO::getInstance();


    $stmt = $cxPDO->prepare("SELECT * FROM news ORDER BY pubDate desc limit 20");
 	// $stmt->bindParam(':lmt', $var, PDO::PARAM_STR); 

    if ($stmt->execute()){

	    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)){

	    	$ar = explode(' - ', $obj->title);
	    	$site = $ar[count($ar) - 1];

	    	$link = substr($obj->link, strrpos($obj->link, 'url=') + 4);

	    	$auxImg = substr($obj->description, strrpos($obj->description, '<img src="') + 10);
	    	$linkImg = substr($auxImg, 0, strrpos($auxImg, '" alt'));

	    	$auxDN = substr($obj->description, strrpos($obj->description, '</b></font><br /><font size="-1">') + 33);
	    	$descriptionNew = substr($auxDN, 0, strrpos($auxDN, '.</font>'));

	    	$description = html_to_obj($obj->description);

	    	array_push($arReturn['ID'], $obj->ID);
	    	array_push($arReturn['title'], $obj->title);
	    	array_push($arReturn['link'], $link);
	    	array_push($arReturn['guid'], $obj->guid);
	    	array_push($arReturn['category'], $obj->category);
	    	array_push($arReturn['site'], $site);
	    	array_push($arReturn['pubDate'], $obj->pubDate);
	    	array_push($arReturn['description'], $obj->description);
	    	array_push($arReturn['pubDateServer'], $obj->pubDateServer);
	    	array_push($arReturn['linkImg'], $linkImg);
	    	array_push($arReturn['descriptionNew'], $descriptionNew);
	    	

	    	echo "<h3>Site: ".$site." </h3>";
	    	echo "<p>Data Publicacao: ".$obj->pubDate." - ".$obj->pubDateServer."<br />";
	    	echo "<a href='".$link."'>";

	    	if (substr($linkImg, 0, 2) == "//"){
		    	echo "<img src=".$linkImg." alt=".$obj->title." title=".$obj->title." />";
	    	} else {
		    	echo "<img src='https://lh3.googleusercontent.com/-iu5z8baXPus/UVXP4hqWMrI/AAAAAAAAAFM/RE4JyPWiYEs/s300-no/banner+RunFast.png' height='80' width='80'  alt=".$obj->title." title=".$obj->title." />";
	    	}
	    	echo "<strong>" . $obj->title . "</strong></a><br /><br />";
	    	echo "<p>".$descriptionNew."</p>";
	    	// echo "<p>".$obj->description."</p>";

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

require_once "../lib/twitter.class.php";

$twitter = new Twitter();
$reply = $twitter->sendTweet($arReturn);

var_dump($reply);


// echo "<table>";
// foreach ($arReturn as $row) {
//    echo "<tr>";
//    foreach ($row as $column) {
//       echo "<td>$column</td>";
//    }
//    echo "</tr>";
// }    
// echo "</table>";