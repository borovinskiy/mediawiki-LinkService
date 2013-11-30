<?php

// You can add $wgLinkServiceSimpleList, but your module can initialized before extensions LinkService.
// Example: 
// require_once("$IP/extensions/YourExtension/YourExtension.php");
// require_once("$IP/extensions/LinkService/LinkService.php");

global $wgLinkServiceExtensionList;

$wgLinkServiceExtensionList['image'] = array(
        'ext' => array('png','jpeg','bmp','gif','svg','webp','jpg'),
        'extern' => '<div style="display:inline-block; max-width: 640px;"><a class="img-link" href="$1" target="_blank"><img src="$1" style="max-width: 100%; width: none;"/></a></div>',
        );

$wgLinkServiceExtensionList['video'] = array(
	'ext' => array('mp4','webm','ogv'),
	'extern' => '<video src="$1" class="embed" controls></video>',
	);

$wgLinkServiceExtensionList['audio'] = array(
        'ext' => array('mp3','ogg','wmv'),
        'extern' => '<audio src="$1" class="embed" controls></audio>',
        );

