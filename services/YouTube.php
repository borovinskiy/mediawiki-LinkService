<?php

class LinkServiceYouTube extends LinkServiceImpl {
	
	private static $youtubeIdRegexp = '[\d\w\_\-\!\#]*';
	
        public static function parse($url,$service,$path,$hash=false) {
                if ($service == 'www.youtube.com' || $service == 'youtube.com') {
                        if ( preg_match("/^watch\?([\d\w\_\-\!\=\&]*\&)?v=(" . self::$youtubeIdRegexp . ")(&|$)/",$path,$matches) ) {
                                $id = $matches[2];
                                return self::getYouTubeVideo($id,$url);
                        }
                        return false;
                }
                if ($service == 'youtu.be') {
                        if (preg_match("/^(" . self::$youtubeIdRegexp . ")(&|$)/",$path,$matches)) {
                                $id = $matches[1];
                                return self::getYouTubeVideo($id,$url);
                        }
                }
        }

	public static function getYouTubeVideo($id,$url) {
		$result = false;
		if (strlen($id)>0) {
			$result = '<iframe class="embed" width="640" height="360" src="https://www.youtube.com/embed/'.$id.'?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>';
		}		
		return $result;
	}
}
