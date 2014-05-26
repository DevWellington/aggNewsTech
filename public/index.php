<!DOCTYPE html>
<meta http-equiv="refresh" content="600">
<?php 

require_once "../../lib/conexao.pdo.php";

// todo organizar o codigo e gerar POO - class generate {


try {

	$cxPDO = connPDO::getInstance();


    $stmt = $cxPDO->prepare("SELECT * FROM tbl_newsTech INNER JOIN defaultImage_Link ORDER BY pubDateServer DESC limit 20");
 	// $stmt->bindParam(':lmt', $var, PDO::PARAM_STR); 

    if ($stmt->execute()){

	    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)){

            /*
            * TODO:
            *   - Implementar Slim framework;
            *   - Implementar Twing para tratar esse feioso aqui em baixo :)
            *
            */

            echo "<div style='width: 300px; /* height: 300px;float: left;*/ margin: 10px; border: 1px solid silver; padding: 8px'>";
            echo "<h3 style='font-family: arial, helvetica, serif; font-size: 15px; margin: 2px; text-align: center;' >Site: ".$obj->site." </h3>";
            echo "<div style='margin: 10px 0;'>";
            echo "<a href='".$obj->link."'>";
            echo $obj->title."<br />";

            if (substr($obj->linkImg, 0, 2) == "//"){
                echo "<img src=".$obj->linkImg." alt=".$obj->title." title=".$obj->title." style='float: left; margin: 10px 10px 10px 0;' />";
            } else {
                echo "<img src='".$obj->defaultImage_Link."' height='80' width='80' style='float: left; margin: 10px 10px 10px 0;'  alt=".$obj->title." title=".$obj->title." />";
            }

	    	echo "</a>";
            echo "</div>";
	    	echo "<span>".$obj->descriptionNew."</span>";
            echo "<br /><br /><span style='font-size: 10px; float: right'><strong>Data Publicacao: </strong>".$obj->pubDateServer."</span><br />";
            echo "</div>";

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
