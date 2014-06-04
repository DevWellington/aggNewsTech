<?php
/**
 * Created by PhpStorm.
 * User: Wellington
 * Date: 03/06/14
 * Time: 22:58
 */

class cURL {

    private static $url;
    private static $cURL;

    public function __construct(){
    }

    public function __destruct(){
        curl_close(self::$cURL);
    }

    public static function exec_cURL($url){

        self::$url = $url;

        self::$cURL = curl_init(self::$url);
        curl_setopt(self::$cURL, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec(self::$cURL) or die(curl_error(self::$cURL));

        return $html;
    }
}





