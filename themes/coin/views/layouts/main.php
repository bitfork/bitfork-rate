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

	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-50693483-1', 'bitfork-rate.com');
		ga('send', 'pageview');

	</script>
</head>

<body>
<div id="wrapper">
	<header role="banner">
		<div class="main-setWidth main-clearfix">
			<section class="main-left">
					<a class="logo" href="<?php echo $this->createUrl('/'); ?>"><img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/bitfork-rate-logo.svg" onerror="this.onerror=null; this.src='<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/bitfork-rate-logo.jpg'"/></a>
					<?php $this->widget('MyMenu',array(
						'items'=>array(
							array('label'=>Yii::t('main', 'Формула расчета'), 'url'=>array('/site/formula')),
							array('label'=>Yii::t('main', 'Free API'), 'url'=>array('/site/api')),
							array('label'=>Yii::t('main', 'GitHub'), 'url'=>'https://github.com/bitfork/bitfork-rate','linkOptions'=>array('target'=>'_blank')),
						),
						'id'=>'header-nav',
					)); ?>
				</section>

				<section class="main-right">
					<select id="source" class="main-inlineBlock" name="pair">
						<?php foreach (Pair::model()->findAll() as $pair) { ?>
							<option
								value="<?php echo $this->createUrl('/course/index', array('from'=>$pair->currency_from->name,'to'=>$pair->currency->name)); ?>"
								<?php echo (isset($_GET['from'],$_GET['to']) and $pair->currency_from->name == $_GET['from'] and $pair->currency->name == $_GET['to']) ? ' selected="selectd"': ''; ?>
							><?php echo $pair->currency_from->name .' / '. $pair->currency->name; ?></option>
						<?php } ?>
					</select>
					<script language="javascript">
						$( document ).ready(function() {
							$('select[id=source]').change(function(){
								window.location = $(this).find('option:selected').val();
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
			<a class="fancybox fancybox.ajax" href="/integration/create" data-fancybox-type="ajax"><?php echo Yii::t('main', 'Связаться с нами'); ?></a>
			<div class="main-right">
				<a href="<?php echo $this->createUrl('/site/map'); ?>"><?php echo Yii::t('main', 'Site map'); ?></a>
			</div>
		</div>
	</footer>
</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
	(function (d, w, c) {
		(w[c] = w[c] || []).push(function() {
			try {
				w.yaCounter24896327 = new Ya.Metrika({id:24896327,
					webvisor:true,
					clickmap:true,
					trackLinks:true,
					accurateTrackBounce:true});
			} catch(e) { }
		});

		var n = d.getElementsByTagName("script")[0],
				s = d.createElement("script"),
				f = function () { n.parentNode.insertBefore(s, n); };
		s.type = "text/javascript";
		s.async = true;
		s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		if (w.opera == "[object Opera]") {
			d.addEventListener("DOMContentLoaded", f, false);
		} else { f(); }
	})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/24896327" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-50693483-1', 'bitfork-rate.com');
	ga('send', 'pageview');

</script>

</body>
</html>