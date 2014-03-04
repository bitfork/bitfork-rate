<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<div class="bl-login bl-margin bl-opacity">
	<h2><?php echo UserModule::t("Login"); ?></h2>
	<?php echo CHtml::beginForm('','post',array('id'=>'form-enter','class'=>'bl-bordered')); ?>
		<?php echo CHtml::errorSummary($model); ?>
		<?php echo CHtml::activeTextField($model,'username',array('placeholder'=>'Ваш логин','required'=>'required','class'=>'placeholder')) ?>
		<?php echo CHtml::activePasswordField($model,'password',array('placeholder'=>'Пароль','required'=>'required','class'=>'placeholder')) ?>
		<?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl,array('class'=>'lk-reset')); ?>
		<div class="center"><?php echo CHtml::submitButton(UserModule::t("Login")); ?></div>
		<p class="center"><?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl,array('class'=>'lk-reset')); ?></p>

	<?php echo CHtml::endForm(); ?>
</div>