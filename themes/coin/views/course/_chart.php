<?php Yii::app()->clientScript->registerPackage('chart'); ?>
<?php $id_chart = 'chart-container-'. rand(0,9999); ?>

<script type="text/javascript">
	$(function() {
		$.getJSON('/index.php?r=chart/index&id_pair=<?php echo $id; ?>&period=0', function(data) {

			// create the chart
			$('#<?php echo $id_chart; ?>').highcharts('StockChart', {
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
							var series = this.series[0];
							setInterval(function() {
								/* обновляем график с интервалом */
								$.getJSON('/index.php?r=chart/index&id_pair=<?php echo $id; ?>&period=0&limit=1', function(data) {
									series.addPoint(data[0], true, true);
								});
							}, 60000);
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
						var s = '<b>'+ Highcharts.dateFormat('%d.%m.%Y %H:%M', this.x) +'</b>';
						s += '<br/>'+ this.points[0].point.name +'';
						return s;
					}
				},

				series : [{
					name : 'история до начала сессии',
					lineWidth: 1,
					data : data,
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
	});

</script>
<div id="<?php echo $id_chart; ?>" style="height: 300px; min-width: 500px"></div>