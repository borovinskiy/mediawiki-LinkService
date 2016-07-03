<?php

class LinkServiceVimeo extends LinkServiceImpl {
        public static function parse($url,$service,$path,$hash=false) {
                if ($service == 'vimeo.com') {
                        if ( preg_match("/^([\d]{1,})(&|$)/",$path,$matches) ) {
                                $id = $matches[1];

                                $result = self::getVimeoVideo($id,$url);
                                if ($result) {
                                        return $result;
                                }
                        }
                        //return "Вызван фильтр вКонтакте";
                        return false;
                }
        }

	public static function getVimeoVideo($id,$url) {
		$result = false;
		if (strlen($id)>0) {
			$result = '<iframe class="embed" src="https://player.vimeo.com/video/'.$id.'" width="640" height="425" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		}		
		return $result;
	}
}
