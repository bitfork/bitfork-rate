<?php Yii::app()->clientScript->registerPackage('chart'); ?>
<?php $id_chart = 'chart-container-'. rand(0,9999); ?>

<script type="text/javascript">
	var ChartMain = (function(){
		var $this;
		var chart;
		var id_chart = 0;
		var id_pair = 0;
		var max_limit = 0;
		var min_limit = 0;

		return {
			init: function(id_chart, id_pair){
				$this = this;
				$this.id_chart = id_chart;
				$this.id_pair = id_pair;

				$.getJSON('/index.php?r=chart/index&id_pair='+ $this.id_pair +'&period=0', function(data) {

					$this.max_limit = data[1];
					$this.min_limit = data[2];

					// create the chart
					$('#'+ $this.id_chart).highcharts('StockChart', {
						global: {
							useUTC: true
						},
						navigation: {
							buttonOptions: {
								enabled: false
							}
						},
						rangeSelector: {
							enabled: false
						},
						navigator: {
							enabled: false
						},
						scrollbar: {
							enabled: false
						},
						exporting: {
							enabled: false
						},
						/*title: {
							text: 'заголовок'
						},*/

						chart : {
							ignoreHiddenSeries: false,

							events : {
								load : function() {
									$this.chart = this;
								}
							}
						},

						xAxis : {
							type: 'datetime',
							lineColor: '#000',
							tickColor: '#000',
							gridLineWidth: 1,
							ordinal: false,
							title: {
								text: 'TIME',
								align: 'high',
								y: -30
							},
							labels: {
								formatter: function() {
									return Highcharts.dateFormat('%H:%M', this.value);
								}
							}
						},

						yAxis : {
							max: $this.max_limit, // максимальная точка графика
							min: $this.min_limit, // минимальная точка графика
							labels: {
								align: 'right',
								x: -3
							},
							lineWidth: 1,
							tickWidth: 1,
							lineColor: '#000',
							tickColor: '#000',
							title: {
								text: 'USD',
								align: 'high',
								x: 30
							}
						},

						tooltip: {
							formatter: function() {
								var s = '<b>'+ Highcharts.dateFormat('%d.%m.%Y', this.x) +'</b>';
								s += '<br/><b>'+ Highcharts.dateFormat('%H:%M:%S', this.x) +'</b>';
								s += '<br/>'+ this.points[0].point.name +'';
								return s;
							}
						},

						series : [{
							name : 'история до начала сессии',
							lineWidth: 1,
							data : data[0],
							type : 'area',
							fillColor: 'rgba(0,95,155,0.5)',
							color: '#0065A8',
							//dashStyle: 'ShortDash',
							marker : {
								enabled : true,
								radius : 2
							},
							shadow : true,
							tooltip: {
								valueDecimals: 2
							}
						}]
					});
				});
			},
			update: function(price, date, name){
				if (typeof $this.chart === "undefined") {
					return;
				}
				var series = $this.chart.series[0];
				var yA = $this.chart.yAxis[0];
				var point = {
					'x': date,
					'y': price,
					'name': name
				};
				series.addPoint(point, true, true);
				var limit = (series.dataMax - series.dataMin);
				if (limit > 0) {
					var max = series.dataMax + (limit / 4);
					var min = series.dataMin - (limit / 4);
					console.log(series.dataMax +' = '+ max);
					console.log(series.dataMin +' = '+ min);
					yA.update({
						max: max,
						min: min
					});
				}
			}
		}
	})();

	$(function() {
		ChartMain.init('<?php echo $id_chart; ?>', '<?php echo $id; ?>');
	});

</script>
<div id="<?php echo $id_chart; ?>" style="height: 300px; min-width: 500px"></div>