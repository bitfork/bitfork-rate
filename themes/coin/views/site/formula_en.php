<h1>Формула рассчета битфорк индекса криптовалют</h1>
<p>Bitfork-rate.com using price and volume from popular bitcoin, litecoin and other crypto currencies exchanges. We use only API service from Exchages.</p>


<!-- MathJax -->
<script type="text/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<script type="text/x-mathjax-config">
	MathJax.Hub.Config({
	tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]},
	styles:
	{
	".MathJax_Display":
	{
	"display": "inline !important"
	}
	}
	});
</script>
<!-- end MathJax -->

<section class="main-bordered-vertical main-separated-vertical main-grid-380 main-grid380_bord">
	<div class="main-grid-sidebar_right">
		<h2>Formula description:</h2>
		<div class="text-small">
			<p><tt class="tt-light">Exchange_Volume <sub>k</sub></tt>  &mdash; 24 hours total volume from exchange k.</p>
			<p><tt class="tt-light">Summary_Volume</tt>  &mdash; 24 hours total volume from all exchanges.</p>
			<p><tt class="tt-light">price <sub>k</sub></tt>  &mdash; average exchange "k"  price for the selected period.</p>
		</div>
	</div>

	<div class="main-grid-content_left">
		<h2>Formula estimate crypto currency  price index</h2>
		<aside class="main-formula">
			<tt>Bitfork index</tt> = $${\sum_{k=1}^{n_k}  \frac{\mathrm{Exchange&nbsp;Volume&nbsp;_k}}{\mathrm{Summary&nbsp;Volume}} \times {\mathrm{price&nbsp;_k}}}$$
		</aside>
	</div>
</section>

<h2>Price index calculation example</h2>
<p>For example use Bitcoin/ U.S. dollar price index. We show you example with 3 exchanges  (Exchange 1, Exchange 2, Exchange 3).</p>

<h3>Bitcoin to USD last price index calculation example.</h3>
<h4>Initial data:</h4>
<div class="main-bordered-double main-padding_10">
	<p><b>Биржа 1:</b> <tt>price <sub>1</sub></tt> = 1500 USD,  <tt class="tt-light">Exchange_Volume <sub>1</sub></tt> = 20 000 BTC</p>
	<p><b>Биржа 2:</b> <tt>price <sub>2</sub></tt> = 1490 USD,  <tt class="tt-light">Exchange_Volume <sub>2</sub></tt> = 5 000 BTC</p>
	<p><b>Биржа 3:</b> <tt>price <sub>3</sub></tt> = 1550 USD,  <tt class="tt-light">Exchange_Volume <sub>3</sub></tt> = 25 000 BTC</p>
</div>
<h4>Пример расчета:</h4>
<div class="main-bordered-double main-padding_10">
	<h5>Шаг 0 (вычисление Summary_Volume):</h5>
	<p><tt>Summary_Volume</tt> = <tt class="tt-light">Exchange_Volume <sub>1</sub></tt> + <tt class="tt-light">Exchange_Volume <sub>2</sub></tt> + <tt class="tt-light">Exchange_Volume <sub>3</sub></tt></p>
	<p><tt>Summary_Volume</tt> = 20 000 BTC + 5 000 BTC + 25 000 BTC = 50 000 BTC</p>
</div>
<div class="main-bordered-double main-padding_10 main-margTop">
	<h5>Шаг 1 (вычисляем данные по первой бирже):</h5>
	<aside class="main-formula">
		<tt>Bitfork index <sub>1</sub></tt> = $${\frac{\mathrm{20&nbsp;000&nbsp;BTC}}{\mathrm{50&nbsp;000&nbsp;BTC}} \times {\mathrm{1&nbsp;500&nbsp;USD}} \mathrm{&nbsp;=&nbsp;600}}$$
	</aside>
</div>
<div class="main-bordered-double main-padding_10 main-margTop">
	<h5>Шаг 2 (вычисляем данные по второй бирже): </h5>
	<aside class="main-formula">
		<tt>Bitfork index <sub>2</sub></tt> = $${\frac{\mathrm{5&nbsp;000&nbsp;BTC}}{\mathrm{50&nbsp;000&nbsp;BTC}} \times {\mathrm{1&nbsp;490&nbsp;USD}} \mathrm{&nbsp;=&nbsp;149}}$$
	</aside>
</div>
<div class="main-bordered-double main-padding_10 main-margTop">
	<h5>Шаг 3 (вычисляем данные по третьей бирже):</h5>
	<aside class="main-formula">
		<tt>Bitfork index <sub>3</sub></tt> = $${\frac{\mathrm{25&nbsp;000&nbsp;BTC}}{\mathrm{50&nbsp;000&nbsp;BTC}} \times {\mathrm{1&nbsp;550&nbsp;USD}} \mathrm{&nbsp;=&nbsp;775}}$$
	</aside>
</div>
<div class="main-bordered-double main-padding_10 main-margTop">
	<h5>Шаг 4 (вычисление индекса):</h5>
	<aside class="main-formula">
		<tt>Bitfork index</tt> = $${\mathrm{600&nbsp;+&nbsp;149&nbsp;+&nbsp;775&nbsp;=&nbsp;1&nbsp;524&nbsp;USD}}$$
	</aside>
</div>
<div class="main-bordered-double main-padding_10 main-margTop">
	<h5>Итог вычисления:</h5>
	<aside class="main-formula">
		<tt>Bitfork index</tt> = 1&nbsp;524 USD
	</aside>
</div>



<div class="main-margTop2 text-center">
	<h2>Начни использовать битфорк индекс уже сегодня</h2>
	<div class="main-zoom">
		<div class="main-col3">
			<a class="imgWrap-140" href="#"><img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/bitforkDevelop.jpg"/></a>
			<h3><a href="#">Заказать интеграцию</a></h3>
		</div>
		<div class="main-col3">
			<a class="imgWrap-140" href="#"><img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/api.jpg"/></a>
			<h3><a href="#">Интегрировать самостоятельно</a></h3>
		</div>
		<div class="main-col3">
			<a class="imgWrap-140" href="https://github.com/bitfork/bitfork-rate"><img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/i/github.jpg"/></a>
			<h3><a href="#">Скачать исходники с GitHub</a></h3>
		</div>
	</div>
</div>