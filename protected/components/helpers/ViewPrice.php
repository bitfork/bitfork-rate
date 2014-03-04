<?php
class ViewPrice
{
	public static function GetResult($value, $is_show_null_kop = false, $rub = '', $kop = '$', $decimal_place = 2, $decimal_point = '.', $thousand_point = ' ')
	{
		if (!empty($rub)) {
			$decimal_point = ' '. $rub .' ';
		}
		$string = number_format(round($value, (int)$decimal_place), (int)$decimal_place, $decimal_point, $thousand_point);
		if (!empty($kop)) {
			$kop = ' '. $kop;
			$string .= $kop;
		}
		if ($is_show_null_kop===false) {
			if (!empty($rub)) {
				$string = preg_replace('/('. $decimal_point .')[0]{'. $decimal_place .'}'. $kop .'$/iu', '$1', $string);
			} else {
				$string = preg_replace('/'. $decimal_point .'[0]{'. $decimal_place .'}'. $kop .'$/iu', '', $string);
			}
		}
		return $string;
	}
}