<?php 

/**
* Classe de envio de tweets
*
*/
class Twitter {
	
	function __construct() {
	}

	public static function sendTweet($obj){

		$cb = self::setConnectionTwitterAPI();

		$twett = self::trataTwett($obj);

		if (strlen($twett) > 10){
	
			$params = array(
			    'status' => $twett
			);

			$reply = $cb->statuses_update($params);
			if ($reply->id_str > 0){
				$return = PHP_EOL."\n<strong>Tweet Enviado com Sucesso !!!</strong>\n".PHP_EOL;
			} else {
				$return = $reply->errors[0]->message;
			}

		} else {
			echo "Tweet nao enviado: (" . $twett . ")";
		}

		return $return;
	}


	private static function setConnectionTwitterAPI(){

		require_once('codebird-php/codebird.php');

		try {

			\Codebird\Codebird::setConsumerKey(self::getTwitterAcess()->yourKey, self::getTwitterAcess()->yourSecret);
			$cb = \Codebird\Codebird::getInstance();

			$cb->setToken(self::getTwitterAcess()->yourToken, self::getTwitterAcess()->yourTokenSecret);

			return $cb;
		
		} catch (Exception $e) {

			echo "Error on connection on Twitter API: \n" . $e->getMessage();	
		}

	}

	private static function getTwitterAcess(){

		$arReturn = array(
			"yourKey" => null,
			"yourSecret" => null,
			"yourToken" => null,
			"yourTokenSecret" => null,
			"UserName" => null
		);

		return (object) $arReturn;
	}

	private static function trataTwett($obj){

		$site = $obj->site;
		$title = str_replace($site, '', $obj->title);

		$link = $obj->link;
		$descriptionNew = $obj->descriptionNew;

		$lenTweet = strlen($title) + 20;
		$tmDescricao = 140 - $lenTweet;

		if ($tmDescricao > 0) 
			$descriptionNew = substr($descriptionNew, 0, $tmDescricao - 8);

		$sTweet = $title . $descriptionNew . "... " . $link;

		return $sTweet;
	}

}