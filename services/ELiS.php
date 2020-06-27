<?php

class LinkServiceELiS extends LinkServiceImpl {

        private static $maxwidth = 1280;

        public static function parse($url,$service,$path,$hash=false) {
                if ( preg_match("/^node\/(\d+)\/embed$/",$path,$matches) ) {
                        preg_match("/^(https?\:\/\/.*)\/node\/(\d+)/", $url, $url_matches);
                        $baseUrl = $url_matches[1];

                        $oembedHtml = self::getOEmbed($baseUrl, $path); // use oembed if module oembedder is enabled
                        if ($oembedHtml !== false) {
                                $result = $oembedHtml;
                        } else {
                                $result = self::getIframeHtml($url,$path);
                        }
                        if ($result) {
                                return $result;
                        }
                }
                return false;
        }


        private static function getIframeHtml($url,$path) { // as iframe

                $out = '<iframe src="' . filter_var($url, FILTER_VALIDATE_URL) . '" style="width: 100%; max-width:' . self::$maxwidth . 'px; height:480px; height: 80vh;" sandbox="allow-scripts allow-popups allow-forms allow-same-origin allow-modals allow-orientation-lock allow-pointer-lock" allowfullscreen/>';
                return $out;
        }

        private static function getOEmbed($baseUrl,$path) {     // as oembed code
                $oembed_url = self::getOEmbedUrl($baseUrl, $path);
                $context = stream_context_create();
                stream_set_timeout($context, 2);
                $oembed_row = @file_get_contents($oembed_url,false,$context);
                $oembed = json_decode($oembed_row);

                if (isset($oembed->html) && strlen($oembed->html)>0) {
                        return $oembed->html;
                }

                return false;
        }

        private static function getOEmbedUrl($baseUrl, $url) {
                return self::getOEmbedEndpoint($baseUrl) .  "?url=" . $url . "&format=json&maxwidth=" . self::$maxwidth;
        }

        private static function getOEmbedEndpoint($baseUrl) {
                return $baseUrl . '/oembedder';
        }

}
