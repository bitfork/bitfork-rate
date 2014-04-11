<?php
class LanguageSwitcherWidget extends CWidget
{
	public function run()
	{
		$currentUrl = ltrim(Yii::app()->request->url, '/');
		$links = array();
		foreach (DMultilangHelper::suffixList() as $suffix => $name){
			$url = '/' . ($suffix ? trim($suffix, '_') . '/' : '') . $currentUrl;
			if (empty($suffix)) {
				$suffix = Yii::app()->params['defaultLanguage'];
			}
			if (Yii::app()->language!=trim($suffix, '_')) {
				$links[] = CHtml::link('<span class="ico-lang'. mb_strtoupper(trim($suffix, '_'), 'utf-8') .'"></span> '.$name, $url);
			}
		}
		$this->render('languages',array('links'=>$links));
	}
}