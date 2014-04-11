<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
	<?php if (!empty($this->pageKeywords))
		echo '<meta name="keywords" content="' . $this->pageKeywords . '" />';
	?>
	<?php if (!empty($this->pageDescription))
		echo '<meta name="description" content="' . $this->pageDescription . '" />';
	?>

	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,400,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,400italic,500,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/fancyBox/source/jquery.fancybox.css" rel="stylesheet"/>
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bitforkrate.min.css" rel="stylesheet"/>

	<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery-1.10.1.min.js"></script>
	<?php Yii::app()->clientScript->registerPackage('app'); ?>

	<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/html5shiv-printshiv.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/selectivizr-1.0.2/selectivizr-min.js"></script>
	<![endif]-->

	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="wrapper">
	<header role="banner">
		<div class="main-setWidth main-clearfix">
			<a id="header-top" href="/"><img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/logo.jpg"/></a>

			<?php $this->widget('MyMenu',array(
				'items'=>array(
					array('label'=>Yii::t('main', 'Формула расчета'), 'url'=>array('/course/index')),
					array('label'=>Yii::t('main', 'API'), 'url'=>array('/course/index')),
					array('label'=>Yii::t('main', 'О нас'), 'url'=>array('/course/index')),
				),
				'id'=>'header-nav',
			)); ?>


			<section class="main-right">
				<select id="source" class="main-inlineBlock" name="pair">
					<?php foreach (Pair::model()->findAll() as $pair) { ?>
					<option value="<?php echo $pair->id; ?>"<?php echo (isset($_GET['pair']) and $pair->id == $_GET['pair']) ? ' selected="selectd"': ''; ?>><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></option>
					<?php } ?>
				</select>
				<script language="javascript">
					$( document ).ready(function() {
						$('select[id=source]').change(function(){
							window.location = '<?php echo $this->createUrl('/course/index', array('pair'=>'')); ?>'+$(this).find('option:selected').val();
						});
					});
				</script>

				<span class="main-inlineBlock text-light"><?php echo Yii::t('main', 'индекс криптовалют'); ?></span>

				<?php $this->widget('LanguageSwitcherWidget'); ?>
			</section>
		</div>
	</header>

	<section role="main">
		<?php echo $content; ?>
	</section>

	<footer role="contentinfo">
		<div class="main-setWidth">
			<span>@2014</span>
			<a href="http://bitfork-develop.com" target="_blank">Bitfork-develop.com</a>
			<a href="#"><?php echo Yii::t('main', 'Связаться с нами'); ?></a>
		</div>
	</footer>
</div>

</body>
</html>