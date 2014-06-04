<!doctype html>
    <head>
        <meta charset="utf-8">
    </head>
<?php

require_once "../lib/external/phpQuery.php";
require_once "../lib/conexao.pdo.php";
require_once "../lib/class/cURL.php";
require_once "../lib/class/import_STBR.php";
require_once "../lib/class/import_STBR_DB.php";

$html = cURL::exec_cURL("http://www.startupbrasil.org.br/agenda/");

import_STBR::getArrayData($html);
import_STBR_DB::insertToDB();
