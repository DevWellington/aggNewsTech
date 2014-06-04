<!doctype html>
    <head>
        <meta charset="utf-8">
    </head>
<?php

require_once "../lib/external/phpQuery.php";
require_once "../lib/conexao.pdo.php";
require_once "../lib/class/cURL.php";
require_once "../lib/class/import_STBR.php";

$html = cURL::exec_cURL("http://www.startupbrasil.org.br/agenda/");
$arAgenda = Import_STBR::getArrayData($html);

echo "<pre>";

$cxPDO = connPDO::getInstance();

foreach ($arAgenda as $field => $item) {

    $obj = (object) $item;

    $stmt = $cxPDO->prepare("INSERT INTO tbl_newsStartUP (title, linkImg, location, linkReadMore, dtEvent, dt_Insert)
                             VALUES (:title, :linkImg, :location, :linkReadMore, :dtEvent, now())");

    $stmt->bindParam(':title', $obj->title);
    $stmt->bindParam(':linkImg', $obj->linkImg);
    $stmt->bindParam(':location', $obj->location);
    $stmt->bindParam(':linkReadMore', $obj->linkReadMore);
    $stmt->bindParam(':dtEvent', $obj->dtEvent);

    $return = $stmt->execute();

    if ($return){
        echo $obj->title.PHP_EOL;
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