<?php
/**
 * http://www.elisdn.ru/blog/39/yii-based-multilanguage-site-interface-and-urls
 */
class DLanguageUrlManager extends CUrlManager
{
	public function createUrl($route, $params=array(), $ampersand='&')
	{
		$url = parent::createUrl($route, $params, $ampersand);
		return DMultilangHelper::addLangToUrl($url);
	}
}