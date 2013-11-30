<?php

class LinkServiceSimpleList extends LinkServiceImpl {

	private static $isListConnected = false;
	
	private static function init() {
		if (!(self::$isListConnected)) {
			require_once("SimpleList.Services.php");	
			self::$isListConnected = true;	
		}
	}

        public static function parse($url,$service,$path,$hash=false) {
		global $wgLinkServiceSimpleList;
		self::init();		// include list of services. It is static constructor

		foreach ($wgLinkServiceSimpleList as $module) {
			if ($module['services'] == $service) {
				if (preg_match($module['pattern'],$path,$matches)) {
					$id = $matches[1];
					$url = self::getUrl($id, $module);
					if ($url !== false) {		//если задан url у сервиса, то пройдем по нему и проверим что нам ответят 200 кодом
						if (!self::checkHttpUrlStatus($url)) {
							continue;	//Модуль совпал, но код не 200, тогда просто считаем что модуль не подошел.
						}
					}
					if (strlen($id)>0) {
						return self::getHtmlCode($id,$module['extern']);
					}
				}

			}
		}
		return false;
        }

	private static function getHtmlCode($id,$pattern) {
		return wfMsgReplaceArgs($pattern, array($id));		// change $1 in pattern to $id
	}

	/* 
	 * Если определен url у конкретного модуля, то заменяем в нем $id и возвращаем результат url. Иначе false
	 */
	private static function getUrl($id, $service) {
		if (isset($service['url'])) {	
			return wfMsgReplaceArgs($service['url'], array($id));
		}
		return false;
	}
	
	
}
