<?php

/**
 * LinkFilter - change any url to same services
 * @author - Arsen I. Borovinskiy
*/

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'LinkService',
	'version' => '0.1',
	'author' => 'Arsen Borovinskiy',
	'url' => 'https://github.com/borovinskiy/LinkFilter',
	'descriptionmsg' => 'linkservice-desc',
);

$wgHooks['ParserAfterTidy'][] = 'linkservice_postParsing';

$wgExtensionMessagesFiles['LinkService'] = __DIR__ . '/LinkService.i18n.php';

$wgAutoloadClasses['LinkService'] = __DIR__ . '/LinkService.body.php';

//$wgExtensionFunctions[] = array('LinkService','initFromGlobals');


global $wgLinkService;

$wgLinkService[]['class'] = 'LinkServiceSimpleList';
$wgAutoloadClasses['LinkServiceSimpleList'] = __DIR__ . '/services/SimpleList.php';

$wgLinkService[]['class'] = 'LinkServiceELiS';
$wgAutoloadClasses['LinkServiceELiS'] = __DIR__ .       '/services/ELiS.php';

$wgLinkService[]['class'] = 'LinkServiceVkontakte'; 
$wgAutoloadClasses['LinkServiceVkontakte'] = __DIR__ . 	'/services/Vkontakte.php';

$wgLinkService[]['class'] = 'LinkServiceYouTube';
$wgAutoloadClasses['LinkServiceYouTube'] = __DIR__ . 	'/services/YouTube.php';

$wgLinkService[]['class'] = 'LinkServiceVimeo';
$wgAutoloadClasses['LinkServiceVimeo'] = __DIR__ . 	'/services/Vimeo.php';

$wgLinkService[]['class'] = 'LinkServiceSlideShare';
$wgAutoloadClasses['LinkServiceSlideShare'] = __DIR__ .      '/services/SlideShare.php';

// INSERT HERE


$wgLinkService[]['class'] = 'LinkServiceExtensionList';
$wgAutoloadClasses['LinkServiceExtensionList'] = __DIR__ . '/services/ExtensionList.php';




function linkservice_postParsing( $parser, &$text ) {
	return LinkService::parserDone( $parser, $text );
}
