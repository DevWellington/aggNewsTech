<?php
/**
 * Created by PhpStorm.
 * User: Wellington
 * Date: 04/06/14
 * Time: 00:21
 */

class import_STBR extends connPDO {

    protected static $arAgenda = array();

    public static function getArrayData($html){

        $pq = phpQuery::newDocumentHTML($html);

        $qtde = pq("div#conteudo_agenda")->size();

        for ($i = 0; $i < $qtde; $i++){

            $dtEvent = pq("div#conteudo_agenda #data_wrap #agenda_data:eq(".$i.")")->html() . " " .
                       pq("div#conteudo_agenda #data_wrap #agenda_hora:eq(".$i.")")->html();

            $dtEvent = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$dtEvent)));

            $title = pq("div#conteudo_agenda #content_wrap #agenda_tit:not(.so-para-versao-mobile):eq(".$i.")")->text();
            $title = trim($title);
            $title = substr($title, 10);
            $title = trim($title);

            $linkImg = pq("div#conteudo_agenda #content_wrap #agenda_img img:eq(".$i.")")->attr('src');

            $location = pq("div#conteudo_agenda #content_wrap #agenda_txt:eq(".$i.")")->text();
            $location = explode('Local:', $location);
            $location = (is_array($location)) ? trim($location[1]) : null;
            $location = str_replace('Saiba mais','',$location);

            $linkReadMore = pq("div#conteudo_agenda #content_wrap #agenda_txt a:eq(".$i.")")->attr('href');

            array_push(self::$arAgenda, array(
                'title' => $title,
                'linkImg' => $linkImg,
                'location' => $location,
                'linkReadMore' => $linkReadMore,
                'dtEvent' => $dtEvent
            ));

        }

        phpQuery::unloadDocuments();

        return self::$arAgenda;

    }

} 