<?php
/**
 * http://www.elisdn.ru/blog/39/yii-based-multilanguage-site-interface-and-urls
 */
class DLanguageUrlManager extends CUrlManager
{
	public function createUrl($route, $params=array(), $ampersand='&')
	{
		$domains = explode('/', ltrim($route, '/'));
		$lang = null;
		$isHasLang = in_array($domains[0], array_keys(Yii::app()->params['translatedLanguages']));
		if ($isHasLang) {
			$lang = $domains[0];
			array_shift($domains);
		}
		$route = '/' . implode('/', $domains);

		$url = parent::createUrl($route, $params, $ampersand);
		return DMultilangHelper::addLangToUrl($url, $lang);
	}
}