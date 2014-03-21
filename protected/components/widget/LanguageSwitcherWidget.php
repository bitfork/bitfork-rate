<?php
class LanguageSwitcherWidget extends CWidget
{
	public function run()
	{
		$currentUrl = ltrim(Yii::app()->request->url, '/');
		$links = array();
		foreach (DMultilangHelper::suffixList() as $suffix => $name){
			$url = '/' . ($suffix ? trim($suffix, '_') . '/' : '') . $currentUrl;
			$links[] = CHtml::tag('li', array('class'=>$suffix), CHtml::link($name, $url));
		}
		$this->render('languages',array('links'=>$links));
	}
}