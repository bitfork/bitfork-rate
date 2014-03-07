<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8" />
	<?php if (!empty($this->pageKeywords))
	echo '<meta name="keywords" content="' . $this->pageKeywords . '" />';
	?>
	<?php if (!empty($this->pageDescription))
	echo '<meta name="description" content="' . $this->pageDescription . '" />';
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

	<!-- BEGIN PLUGIN CSS -->
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet" type="text/css" media="screen"/>
	<!-- END PLUGIN CSS -->
	<!-- BEGIN CORE CSS FRAMEWORK -->
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
	<!-- END CORE CSS FRAMEWORK -->
	<!-- BEGIN CSS TEMPLATE -->
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
	<!-- END CSS TEMPLATE -->
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse ">
	<div class="navbar-inner">
		<div class="header-seperation">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.png" style="max-height: 50px; margin-top: 5px; margin-left: 20px;">
		</div>
		<div class="header-quick-nav">
			<div class="pull-left">
				<ul class="nav quick-section">
					<li class="quicklinks">
						<a id="layout-condensed-toggle" class="" href="#">
							<div class="iconset top-menu-toggle-dark"></div>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
	<div class="page-sidebar" id="main-menu">
		<!-- BEGIN MINI-PROFILE -->
		<div class="page-sidebar-wrapper" id="main-menu-wrapper">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'<i class="icon-custom-home"></i><span class="title">Главная</span>', 'url'=>array('/course/index')),
					array('label'=>'<i class="fa fa-cog"></i><span class="title">API</span>', 'url'=>array('/course/index')),
					array('label'=>'<i class="fa fa-book"></i><span class="title">Гайд</span>', 'url'=>array('/course/index')),
					array('label'=>'<i class="fa fa-question"></i><span class="title">Помощь</span>', 'url'=>array('/course/index')),
					array('label'=>'<i class="fa fa-user"></i><span class="title">О разработчиках</span>', 'url'=>array('/course/index')),
					//array('label'=>'<i class="fa fa-folder-open"></i><span class="title">Собрать</span>', 'url'=>array('/course/parse')),
					/*array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest)*/
				),
				'encodeLabel' => false,
				//'linkLabelWrapper' => 'span',
				//'linkLabelWrapperHtmlOptions'=>array('class'=>'title')
			)); ?>
		</div>
	</div>
	<a href="#" class="scrollup">Scroll</a>
	<div class="page-content">
		<div class="content">
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
			<?php endif?>

			<?php echo $content; ?>
		</div>
	</div>
</div>

<!-- BEGIN CORE JS FRAMEWORK-->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/breakpoints.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<!-- END CORE JS FRAMEWORK -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/core.js" type="text/javascript"></script>
</body>
</html>