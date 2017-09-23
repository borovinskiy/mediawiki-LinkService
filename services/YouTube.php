<?php
class LinkServiceYouTube extends LinkServiceImpl {

        private static $youtubeIdRegexp = '[\d\w\_\-\!\#]*';
        private static $youtubeTimeRegexp = 't=[\dhms]+';
        private static $youtubeStartRegexp = 'start=[\d]+';

        public static function parse($url,$service,$path,$hash=false) {
                if ($service == 'www.youtube.com' || $service == 'youtube.com') {
                        if ( preg_match("/^watch\?([\d\w\_\-\!\=\&]*\&)?v=(" . self::$youtubeIdRegexp . ")(&|$)/",$path,$matches) ) {
                                $id = $matches[2];
                                $t = self::getYoutubeTime($path);
                                return self::getYouTubeVideo($id,$url,$service,$t);
                        }
                        return false;
                }
                if ($service == 'youtu.be') {
                        $t = preg_match();
                        if (preg_match("/^(" . self::$youtubeIdRegexp . ")(\?|&|$)/",$path,$matches)) {
                                $id = $matches[1];
                                $t = self::getYoutubeTime($path);
                                return self::getYouTubeVideo($id,$url,$service,$t);
                        }
                }
        }
        public static function getYouTubeVideo($id,$url,$service,$t=false) {
                $result = false;
                $time = ($t !== false) ? '&' . $t : '';
                $youtubeUrl =  $youtubeUrl = 'https://www.youtube.com/embed/' . $id . '?feautre=player_detailpage' . $time;
                if (strlen($id)>0) {
                        $result = '<iframe class="embed" width="640" height="360" src="' . $youtubeUrl . '" frameborder="0" allowfullscreen></iframe>';
                }
                return $result;
        }
        private static function getYoutubeTime($path) {
                $t = false;
                if (preg_match("/(" . self::$youtubeTimeRegexp . ")(&|$)/",$path,$matches)) {
                        $t = $matches[1];
                        $s = 0;
                        if (preg_match("/(\d+)s/",$t,$sec_match)) {
                                $s += $sec_match[1];
                        }
                        if (preg_match("/(\d+)m/",$t,$min_match)) {
                                $s += $min_match[1] * 60;
                        }
                        if (preg_match("/(\d+)h/",$t,$hour_match)) {
                                $s += $hour_match[1] * 3600;
                        }
                        if ($s > 0) {
                                $t = 'start=' . $s;
                        }
                }
                if (preg_match("/(" . self::$youtubeStartRegexp . ")(&|$)/",$path,$matches)) {
                        $t = $matches[1];
                }
                return $t;
        }
}
