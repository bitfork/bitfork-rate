<?php
echo CHtml::link('[ btce ]', array('course/parse', 'id'=>'btce'));
echo CHtml::link('[ bitstamp ]', array('course/parse', 'id'=>'bitstamp'));
echo CHtml::link('[ btcchina ]', array('course/parse', 'id'=>'btcchina'));

echo "<pre>";
var_dump($results);
echo "</pre>";