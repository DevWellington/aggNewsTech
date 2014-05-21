<?php 

/**
* Classe de envio de tweets
*
*/
class Twitter {
	
	private static $yourKey;
	private static $yourSecret;
	private static $yourToken;
	private static $yourTokenSecret;


	function __construct() {
		require_once('codebird-php/codebird.php');

		self::$yourKey = null;
		self::$yourSecret = null;
		self::$yourToken = null;
		self::$yourTokenSecret = null;
	}

	public static function sendTweet(array $arReturn){

		\Codebird\Codebird::setConsumerKey(self::$yourKey, self::$yourSecret);
		$cb = \Codebird\Codebird::getInstance();

		$cb->setToken(self::$yourToken, self::$yourTokenSecret);


		$site = $arReturn['site'][0];
		$title = str_replace($site, '', $arReturn['title'][0]);

		$link = $arReturn['link'][0];
		$descriptionNew = $arReturn['descriptionNew'][0];

		$lenTweet = strlen($title) + 20;
		$tmDescricao = 140 - $lenTweet;

		if ($tmDescricao > 0) 
			$descriptionNew = substr($descriptionNew, 0, $tmDescricao - 8);

		$sTweet = $title.$descriptionNew."... ".$link;
		 
		$params = array(
		    'status' => $sTweet
		);

		$reply = $cb->statuses_update($params);

		if ($reply->id_str > 0){
			$return = 'Tweet Enviado com Sucesso !!!';
		} else {

			$return = $reply->errors[0]->message;
		}

		return $return;
	}

}