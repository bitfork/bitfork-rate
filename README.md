bitfork-rate
============

{ENGLISH DESCRIPTION}
Platform for creating your own crypto currencies index.  
At the moment, the platform gives you the opportunity to show the Bitcoin rate to the U.S. dollar based 
on the trading volume and the latest prices on the data from btc-e.com and bitstamp.net

{RUSSIAN DESCRIPTION}
Битфорк курс - это платформа для создания индекса обменного курса криптовалют.
На данный момент платформа дает вам возможнсоть показать курс Bitcoin к USD основываясь на данных об 
объемах торгов и последних ценах на покупку с бирж btc-e.com и bitstamp.net


HOW IT WORK
============

{RUSSIAN DESCRIPTION}
Платформа использует API бирж для получения данных об объеме торгов за последние 24 часа и последних ценах.
Вся информация записывается в базу данных с периодичностью в 5 секунд. На основании накопленной информации
платформа может показать вам курс моментальный, за последние сутки и за 7 дней.

Механизм рассчета битфорк курса основывается на объемах торгов. Чем больший объем отдельно взятой биржи, тем 
больше его влияние на взвешенный курс.
