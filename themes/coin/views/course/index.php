<div class="page-title"> <i class="icon-custom-left"></i>
	<h3>Главная страница</h3>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="grid simple">
			<div class="grid-title no-border">
			</div>
			<div class="grid-body no-border">
				<div class="row">

					<div class="col-md-6">
						<div class="p-l-20 p-r-20 p-b-10 b-b b-grey">
							<h3 class="text-error bold inline no-margin">
								<?php echo ViewPrice::GetResult($index); ?>
							</h3>
						</div>

						<div class="btn-group m-b-10 m-t-10">
							<?php
							echo CHtml::link('1ч', array('course/index', 'period'=>1), array('class'=>($period==1)?'btn btn-primary active':'btn btn-primary'));
							echo CHtml::link('24ч', array('course/index', 'period'=>24), array('class'=>($period==24)?'btn btn-primary active':'btn btn-primary'));
							echo CHtml::link('7д', array('course/index', 'period'=>168), array('class'=>($period==168)?'btn btn-primary active':'btn btn-primary'));
							?>
						</div>
						<table class="table no-more-tables">
							<thead>
							<tr>
								<th>Сервис</th>
								<th>Последняя цена</th>
								<th>Объем</th>
							</tr>
							</thead>
							<?php foreach ($data as $row) { ?>
							<tr>
								<td><?php echo $row['name_service']; ?></td>
								<td class="bold text-success"><?php echo ViewPrice::GetResult($row['avg_price']); ?></td>
								<td class="bold text-info"><?php echo ViewPrice::GetResult($row['avg_volume'], false, '', 'BTC', 6); ?></td>
							</tr>
							<?php } ?>
						</table>

						<?php /*
	bter.com - api есть но не понятно есть ли usd
	cryptsy.com - api есть но не понятно, и есть ли там usd да и вообще валюты не особо понятные
	vircurex.com - https://api.vircurex.com/api/get_info_for_1_currency.json?base=BTC&alt=USD только не понятно почему объем маленький
	upbit.org - закрыта
	https://poloniex.com api есть но не понятно

 	https://api.bitfinex.com/v1/today/btcusd + https://api.bitfinex.com/v1/ticker/btcusd


 */ ?>
					</div>

					<div class="col-md-6">

						<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'login-form',
							'enableClientValidation'=>true,
							'clientOptions'=>array(
								'validateOnSubmit'=>true,
							),
						)); ?>


								<div class="form-group">
									<div class="controls">


										<?php echo $form->checkBoxList(
											$modelForm,
											'services',
											$servicesList,
											array(
												'separator'=>'',
												'template'=>'<div class="checkbox check-default">{input}{label}</div>'
											)
										); ?>



									</div>
									<?php echo $form->error($modelForm,'services'); ?>
									<div class="controls">
										<?php echo CHtml::submitButton('Выбрать',array('class'=>'btn btn-success btn-cons')); ?>
									</div>
								</div>





							<?php $this->endWidget(); ?>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>