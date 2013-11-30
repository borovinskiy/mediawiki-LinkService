<?php

class LinkServiceSlideShare extends LinkServiceImpl {

	private static $maxwidth = 640;
	public static function parse($url,$service,$path,$hash=false) {
		if ($service == 'www.slideshare.net') {
			if ( preg_match("/^[\w\d\-\_\.]+\/[\w\d\-\_\.]+$/",$path,$matches) ) {
				$result = self::getOEmbed($url,$path);
				if ($result) {
					return $result;
				} 
			}
			//return "Вызван фильтр вКонтакте";
			return false;
		}
	}


	public static function getOEmbed($url,$path) {
		$oembed_url = "http://www.slideshare.net/api/oembed/2?url=".$url."&format=json&maxwidth=".self::getMaxWidth();
		$context = stream_context_create();
		stream_set_timeout($context, 2);
		$oembed_row = file_get_contents($oembed_url,false,$context);
		$oembed = json_decode($oembed_row);		

		if (isset($oembed->slideshow_id) && isset($oembed->html) && strlen($oembed->html)>0) {
			return $oembed->html;
		}
				
		return false;
	}
	
	public static function getMaxWidth() {
		return self::$maxwidth;
	}

}
