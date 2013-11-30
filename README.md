mediawiki-LinkService
=====================

## Problem

Usage wiki markup is very hard for any people. Ok! Simple don't use wiki markup! Embeding any resources by simple url-link! 

May be it not customazable, but very simple.

## LinkService extension

Allow change same url-link on external resources to any embed code.

Example: 
  
 http://www.youtube.com/watch?v=Jn4dbySjj3Y can changed on YouTube player.

Also you can define any url extensions for change to any html code. 

Example: 

 http://example.com/file.mp4 replace to ```<video src="http://example.com/file.mp4"></video>```

You can simple extend this modules for any online services.

Many services include in modules.

## Install

Your must copy extension from github to extensions folder and added require_once( "$IP/extensions/LinkService/LinkService.php" ); in LocalSettings.php.

## Extend

### Replace by url-extension

You can add any extension from url in extensions/LinkService/services/ExtensionList.Services.php 

### Replace by hostname and replace pattern

You can replace url-link by any preg_replace pattern by extend global array $wgLinkServiceSimpleLink. See extensions/LinkService/service/SimpleLiset.Services.php 

### Define class for change any url with your class helper.

Define url-extension or replace pattern is very small functionality? Your can define class for replace link in extensions/LinkService/LinkService.php. 

Replace by extension and hostname + pattern is my defined classes. So, you can add class to. Good idea usage ```$wgLinkService[]['class'] = 'LinkServiceYourClassExample';``` for this. Also your can add your class in autoloading.
