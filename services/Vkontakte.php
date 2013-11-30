<?php

class LinkServiceVkontakte extends LinkServiceImpl {

	public static function parse($url,$service,$path,$hash=false) {
		if ($service == 'vk.com') {
			if ( preg_match("/^video(\d{1,})_(\d{1,})/",$path,$matches) ) {
				$vk_oid = $matches[1];
				$vk_id = $matches[2];
				$result = self::getVkVideo($vk_oid,$vk_id,$url);
				if ($result) {
					return $result;
				} 
			}
			//return "Вызван фильтр вКонтакте";
			return false;
		}
	}

	public static function getVkVideoByMetaTag($vk_oid,$vk_id,$url) {
		$page = self::getPage("http://vk.com/video".$vk_oid."_".$vk_id);
		if (preg_match("@<meta property=\"og:video\" content=\"http:\/\/vk\.com\/video\?act=get_swf&oid=".$vk_oid."&vid=".$vk_id."&embed_hash=([\w\d]*)\" \/\>@",$page,$matches)) {
			$hash2 = $matches[1];
			$embed_code = '<iframe class="embed" src="http://vk.com/video_ext.php?oid='.$vk_oid.'&id='.$vk_id.'&hash='.$hash.'&hd=1" width="607" height="360" frameborder="0"></iframe>';
			return $embed_code;
		}
		return false;
	}

	public static function getVkVideo($vk_oid,$vk_id,$url) {
		$mp4_count = 0;
		$result = array(
			"vk_hash" => false,
			"mp4" => array(
				"240" => false,
				"360" => false,
				"480" => false,
				"720" => false,
				"1080" => false,
			),
		);
		$page = self::getPage("http://vk.com/video".$vk_oid."_".$vk_id);
//var_dump($page);
		// ,\"hash2\":\"4b34c16dcb7529bc\", - такую строку надо извлечь, т.к. нам нужен хеш
		$page_for_hash = preg_replace("/\\\/","",$page);         // Удаляем лишние \\\
		if (preg_match("@,\"hash2\":\"([\w\d]*)\",@",$page_for_hash,$matches)) {
			$result["vk_hash"] = $matches[1];		
			return '<iframe src="http://vk.com/video_ext.php?oid='.$vk_oid.'&id='.$vk_id.'&hash='.$result['vk_hash'].'&hd=1" width="607" height="360" frameborder="0"></iframe>';
		}

		foreach ($result['mp4'] as $key => $value) {
			// we must parse text: \"url240\":\"http:\\\/\\\/cs504317v4.vk.me\\\/u25427005\\\/videos\\\/385b920bb8.240.mp4\"
			$page = preg_replace("/\\\/","",$page);		// Удаляем лишние \\\

			if (preg_match("@,\"url".$key."\":\"(http:[^\"]*\.".$key."\.mp4)\"@",$page,$matches)) {


				$link_escaped = $matches[1];
				$link = preg_replace("@\/\/\/@","",$link_escaped);
				if ($link && strlen($link)>0) {
					$result['mp4'][$key] = $link;
					$mp4_count++;
				}
			}
		}

		// Массив с видео $result['mp4'] сформирован и пора выводить результать
		if ($mp4_count) {
			$mp4_best_video;
			foreach ($result['mp4'] as $key=>$value) {	// Найдем наибольшее разрешение
				if ($value != false) {
					$mp4_best_video = $value;
				}
			}
			return '<video src="'.$mp4_best_video.'" controls><a href="'.$url.'">Your browser does not support HTML5 Video</a></video>';
		}

		
				

		return $result;
	}
}
