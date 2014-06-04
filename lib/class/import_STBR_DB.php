<?php
/**
 * Created by PhpStorm.
 * User: Wellington
 * Date: 04/06/14
 * Time: 01:06
 */

require_once "import_STBR.php";

class import_STBR_DB extends import_STBR{

    public static function insertToDB(){

        echo "<pre>";

        $cxPDO = self::getInstance();

        foreach (self::$arAgenda as $field => $item) {

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

        unset($cxPDO);
    }
} 