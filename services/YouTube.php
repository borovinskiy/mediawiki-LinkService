<?php

class LinkServiceYouTube extends LinkServiceImpl {
        public static function parse($url,$service,$path,$hash=false) {
                if ($service == 'www.youtube.com' || $service == 'youtube.com') {
                        if ( preg_match("/^watch\?([\d\w\_\-\!\=\&]*\&)?v=([\d\w\_\-\!\#]*)(&|$)/",$path,$matches) ) {
                                $id = $matches[2];
                                $result = self::getYouTubeVideo($id,$url);
                                if ($result) {
                                        return $result;
                                }
                        }
                        //return "Вызван фильтр вКонтакте";
                        return false;
                }
        }

	public static function getYouTubeVideo($id,$url) {
		$result = false;
		if (strlen($id)>0) {
			$result = '<iframe class="embed" width="640" height="360" src="http://www.youtube.com/embed/'.$id.'?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>';
		}		
		return $result;
	}
}
