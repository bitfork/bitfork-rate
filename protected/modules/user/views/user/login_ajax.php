<?php if (Yii::app()->user->isGuest) : ?>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'form-enter',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			//'htmlOptions' => (($model->getError('username') or $model->getError('password')) ? array('style'=>'display:none;') : array('style'=>'display:none;'))
		)); ?>

			<?php echo $form->textField($model,'username',array('class'=>($model->getError('username')?'inp-err':''),'placeholder'=>'Ваш логин','required'=>'required')); ?>
			<?php /*<div style="display:none;"><?php echo $form->error($model,'username'); ?></div>*/ ?>

			<?php echo $form->passwordField($model,'password',array('class'=>($model->getError('password')?'inp-err':''),'placeholder'=>'Пароль','required'=>'required')); ?>
			<?php /*<div style="display:none;"><?php echo $form->error($model,'password'); ?></div>*/ ?>

			<a class="lk-reset" href="<?php echo Yii::app()->createUrl('/user/recovery'); ?>">Забыли пароль?</a>
			<div class="center">
				<p class="btn-orange">
					<?php echo CHtml::submitButton('Войти'); ?>
				</p>
			</div>
			<p class="center"><a class="lk-reset" href="<?php echo Yii::app()->createUrl('/user/default/registration'); ?>">Зарегистрироваться</a></p>

		<?php $this->endWidget(); ?>
<?php endif; ?>