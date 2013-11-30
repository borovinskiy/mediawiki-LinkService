<?php

class LinkServiceExtensionList extends LinkServiceImpl {

	private static $isListConnected = false;
	
	private static function init() {
		if (!(self::$isListConnected)) {
			require_once("ExtensionList.Services.php");	
			self::$isListConnected = true;	
		}
	}

        public static function parse($url,$service,$path,$hash=false) {
		global $wgLinkServiceExtensionList;
		self::init();		// include list of services. It is static constructor

		$url = trim($url);

		if (!self::isValidUrl($url)) return false;

                $file = wfParseUrl($url);
                if (!$file) {
                        return false;
                }

                $ext = self::getFileExtension($url,$file);
                if (!$ext || strlen($ext)==0) {
                        return false;
                }

		if (!self::checkHttpUrlStatus($url)) { return; }		// Файл должен быть доступен

		//$service - здесь название сервера, нам это название не нужно. 
		//нужно из url достать расширение и пройтись по всему списку модулей и у тех, у которых указано нужное расширение - попробовать провести замену ссылки


		foreach ($wgLinkServiceExtensionList as $module) {

			foreach ($module['ext'] as $extension) {	//Перебор всех расширений у одного из модулей

				if ($extension == strtolower($ext)) {	// Если расширение совпало, сразу возвращаем код вставк

					return self::getHtmlCode($url,$module['extern']);				
				}
			}
		}
		return false;
        }

	private static function getHtmlCode($url,$pattern) {
		return wfMsgReplaceArgs($pattern, array($url));		// change $1 in pattern to $id
	}


        private static function isValidFileUrl($file=array()) {
                if (strlen($file['path']) > 0 && strlen($file['host']) > 0 && strlen($file['scheme']) > 0) {
                        return true;
                }
                return false;
        }


	/* 
	 * Проверяет валидность url
	 */
        private static function isValidUrl($url,$absolute = FALSE) {
                if ($absolute) {
                        return (bool) preg_match("
                                /^                                                      # Start at the beginning of the text
                                (?:ftp|https?|feed):\/\/                                # Look for ftp, http, https or feed schemes
                                (?:                                                     # Userinfo (optional) which is typically
                                        (?:(?:[\w\.\-\+!$&'\(\)*\+,;=]|%[0-9a-f]{2})+:)*      # a username or a username and password
                                        (?:[\w\.\-\+%!$&'\(\)*\+,;=]|%[0-9a-f]{2})+@          # combination
                                )?
                                (?:
                                        (?:[a-z0-9\-\.]|%[0-9a-f]{2})+                        # A domain name or a IPv4 address
                                        |(?:\[(?:[0-9a-f]{0,4}:)*(?:[0-9a-f]{0,4})\])         # or a well formed IPv6 address
                                )
                                (?::[0-9]+)?                                            # Server port number (optional)
                                        (?:[\/|\?]
                                        (?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})   # The path and query (optional)
                                *)?
                                $/xi", $url);
                }
                else {
                        return (bool) preg_match("/^(?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})+$/i", $url);
                }
        }

	/*
	 * Получает расширение файла из url
	 */
        private static function getFileExtension($url,$file) {
                if (self::isValidFileUrl($file) && self::isValidUrl($url)) {
                        $path_parts = pathinfo($url);
                        if (isset($path_parts['extension'])) {
                                return $path_parts['extension'];
                        }
                        else {
                                return false;
                        }
                }
                return false;
        }
	
	
}
