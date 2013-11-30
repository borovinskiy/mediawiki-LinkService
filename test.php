<?php

return;  // comment this for allow test
 
require_once("LinkService.php");
require_once("LinkService.body.php");
require_once("LinkService.i18n.php");
require_once("services/Vkontakte.php");
require_once("services/YouTube.php");
require_once("services/Vimeo.php");
require_once("services/SimpleList.php");

/*
$text = '<p><a rel="nofollow" class="external free" href="http://vk.com/video25427005_165598829">http://vk.com/video25427005_165598829</a>
</p>';

LinkService::parserDone(array(),$text);



print "Итоговый результат: \n";
print $text;
*/


$text = '<a rel="nofollow" class="external free" href="http://www.youtube.com/watch?v=4DO34OZfo0k&amp;list=UULpct_e7Av32f3IfbvOgZNg">http://www.youtube.com/watch?v=4DO34OZfo0k&amp;list=UULpct_e7Av32f3IfbvOgZNg</a>';

LinkService::parserDone(array(),$text);

print "Итоговый результат: \n";
print $text;
