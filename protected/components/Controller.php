<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public $pageTitle = '';
	public $pageKeywords = '';
	public $pageDescription = '';

	public function init()
	{
		parent::init();

		$this->pageTitle = Yii::t('main', 'Битфорк индекс курса криптовалют. Курс bitcoin, litecoin и других криптовалют.');
		$this->pageKeywords = '';
		$this->pageDescription = Yii::t('main', 'Битфорк индекс курса криптовалют. Курс биткоин (bitcoin) к доллару USD, курс litecoin к доллару USD.  Бесплатное API для сторонних интернет сайтов. Настраиваемые параметры курса криптовалют.');
	}

	/*public function filters()
	{
		return array(
			'rights'
		);
	}*/
}