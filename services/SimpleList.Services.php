<?php

// You can add $wgLinkServiceSimpleList, but your module can initialized before extensions LinkService.
// Example: 
// require_once("$IP/extensions/YourExtension/YourExtension.php");
// require_once("$IP/extensions/LinkService/LinkService.php");

global $wgLinkServiceSimpleList;

$wgLinkServiceSimpleList['campus-myvideo'] = array(
	'services' => 'k.psu.ru',
	'pattern' => '/^myvideo\/node\/([\d]{1,})/',
	'url' => 'http://k.psu.ru/myvideo/myvideo/embed/html/$1',
	'extern' => '<iframe class="embed" src="http://k.psu.ru/myvideo/myvideo/embed/html/$1?width=640&amp;height=416" width="640" height="416" style="border: 0; margin: 0; overflow: hidden;"></iframe>',
	);

$wgLinkServiceSimpleList['campus-docs'] = array(
        'services' => 'k.psu.ru',
        'pattern' => "/^docs\/node\/(\d+)/",
	'url' => 'http://k.psu.ru/docs/presentations/view/player/$1',
	'extern' => '<iframe class="embed" src="http://k.psu.ru/docs/presentations/view/player/$1" width="640" height="380" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" allowfullscreen="1" mozallowfullscreen="1" webkitallowfullscreen="1"></iframe>',
        );

$wgLinkServiceSimpleList['campus-ebooks'] = array(
        'services' => 'k.psu.ru',
        'pattern' => "/^library\/node\/(\d+)/",
	'url' => 'http://k.psu.ru/library/ebooks/embed/$1',
        'extern' => '<iframe class="embed" src="http://k.psu.ru/library/ebooks/embed/$1" width="640" height="1040" frameborder="0" allowfullscreen="1" mozallowfullscreen="1" webkitallowfullscreen="1"></iframe>',
        );

/* jsonp включать на сайте голосования нельзя т.к. возможна накрутка голосов
$wgLinkServiceSimpleList['campus-poll'] = array(
        'services' => 'k.psu.ru',
        'pattern' => "/^poll\/node\/(\d+)/",
        'url' => 'http://k.psu.ru/poll/node/$1',
        'extern' => '<div onclick="location.href=\'http://k.psu.ru/poll/node/$1\'"><div data-campus-poll="$1"><script>jQuery.getJSON("http://k.psu.ru/poll/oembed/endpoint?callback=?", {format: "jsonp", url: "http://k.psu.ru/poll/node/$1"},function(data) { console.log(data); console.log(this); if (data.html) { jQuery("div[data-campus-poll=$1]").html(data.html); } })</script></div></div>',
        );
*/

$wgLinkServiceSimpleList['campus-poll'] = array(
        'services' => 'k.psu.ru',
        'pattern' => "/^poll\/node\/(\d+)/",
        'url' => 'http://k.psu.ru/poll/node/$1',
        'extern' => '<div class="embed" data-campus-poll="$1"><script>jQuery("div[data-campus-poll=$1]").load("http://k.psu.ru/poll/node/$1 #node-$1 > form");</script></div>',
        );


$wgLinkServiceSimpleList['google-docs-document'] = array(
        'services' => 'docs.google.com',
        'pattern' => "/^document\/d\/([\-\_\!\w\d]+)\//",
	'url' => 'https://docs.google.com/document/d/$1/pub?embedded=true',
	'extern' => '<iframe class="embed" src="https://docs.google.com/document/d/$1/pub?embedded=true" width="640" height="480"></iframe>',
        );

$wgLinkServiceSimpleList['google-docs-presentation'] = array(
        'services' => 'docs.google.com',
        'pattern' => "/^presentation\/d\/([\-\_\!\w\d]+)\//",
	'url' => 'https://docs.google.com/presentation/d/$1/embed?start=false&loop=false&delayms=3000',
	'extern' => '<iframe class="embed" src="https://docs.google.com/presentation/d/$1/embed?start=false&loop=false&delayms=3000" frameborder="0" width="640" height="509" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>',
	);



/* не получается расшарить
$wgLinkServiceSimpleList['google-docs-spreadsheet'] = array(
        'services' => 'docs.google.com',
        'pattern' => "/^spreadsheet\/pub\?key\=([\-\_\!\w\d]+)\&/",
	'extern' => 'https://docs.google.com/spreadsheet/pub?key=0Ai_T0F4NamBadHA1WEdzMFlKcXlZZkQxYVVPQ3E3cHc&output=html',
	
*/

// Embed Video
$wgLinkServiceSimpleList['rutube'] = array(
        'services' => 'rutube.ru',
        'pattern' => "/^video\/([\w\d]+)\//",
        'url' => 'http://rutube.ru/video/embed/$1',
        'extern' => '<iframe class="embed" width="640" height="360" src="http://rutube.ru/video/embed/$1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>',
	);
$wgLinkServiceSimpleList['ustream-tv-recorded'] = array(
        'services' => 'www.ustream.tv',
        'pattern' => "/^recorded\/([\d]+)/",
        'url' => 'http://www.ustream.tv/recorded/$1',
	'extern' => '<iframe class="embed" width="680" height="415" src="http://www.ustream.tv/embed/recorded/$1?v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0px none transparent;">    </iframe><br /><a href="http://www.ustream.tv/" style="padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;" target="_blank">Video streaming by Ustream</a>',
        );
