<?php
/** 
 * LinkFilter Class
 * @author Arsen Borovinskiy
 */

class LinkService {
	public static function parserDone( $parser, &$text ) {
		global $wgLinkService;
		$original_text = $text;
//		preg_match_all("#^|\n|\shttps?:\/\/([\w\.\d\-\_]{1,})\/([\=\.\w\d\_\-\?\&\%\^\#\!]*)\s|\n|$#",$text,$text_matches);
                preg_match_all("#<a rel=\"nofollow\" class=\"external free\" href=\"(https?:\/\/([\w\.\d\-\_]{1,})\/([\:\=\.\;\w\d\_\-\?\&\%\^\/\#\!]*))\">(.*)<\/a>#",$text,$text_matches);
		for ($k=0; $k < count($text_matches['0']); $k++) {
			$pos = strpos($text, $text_matches['0'][$k]);
			$service = $text_matches['2'][$k];   
			$url = $text_matches['1'][$k];
			$path = $text_matches['3'][$k];

			foreach ($wgLinkService as $class) {

				//if (class_exists($class['class'])) {
				try {
					$invoked_text = $class['class']::parse($url,$service,$path);
					if ($invoked_text) {
						$text =  substr_replace($text, $invoked_text, $pos, strlen($text_matches['0'][$k]));
						break;
					}
				}
				catch (Exception $e) {
				}
			}
		}
		
		return true;
	} 





}


// этот класс должны унаследовать все классы, которые решать реализовать сервис
class LinkServiceImpl {
	public static function parse($url,$service,$path) {
		return $url;
	}
	
	/* 
	 * return text page by url with curl
	 */
	public static function getPage($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);		
		$res = curl_exec($ch);
		curl_close($ch);
		if ($res) {
			return $res;
		}
		return false;
	}

        /*
         * Получает http_status код для запрошенного url
         */
        protected static function getHttpUrlStatus($url) {
                $ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "HEAD");
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, false);
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                return $http_status;

        }

        protected static function checkHttpUrlStatus($url) {
                $http_status = self::getHttpUrlStatus($url);
                if ($http_status == "200") {
                        return true;
                }
                return false;
        }


}

?>
