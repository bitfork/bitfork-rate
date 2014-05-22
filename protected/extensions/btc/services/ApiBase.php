<?php
namespace btc\services;

use btc\Service;

class ApiBase
{
	private $errors_message = array();

	public function query($url, $post_data = null, $headers = null)
	{
		$ch = null;
		if (is_null($ch)) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.0.1) Gecko');
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		if (is_array($post_data)) {
			$post_data = http_build_query($post_data, '', '&');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}
		if (is_array($post_data)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		// run the query
		$res = curl_exec($ch);
		if ($res === false) {
			$this->setMessageLog('Could not get reply: '.curl_error($ch) .' - '. $url, 'error');
			return false;
		}
		$dec = json_decode($res, true);
		if (!$dec) {
			$this->setMessageLog('Invalid data received, please make sure connection is working and requested API exists - '. $url);
			return false;
		}
		if (isset($dec['error'])) {
			if (strpos($url,'https://api.kraken.com/')!==false) {
				if (count($dec['error'])>0) {
					$this->setMessageLog(var_export($dec['error'], true) .' - '. $url);
					return false;
				}
			} else {
				$this->setMessageLog($dec['error'] .' - '. $url);
				return false;
			}
		}
		return $dec;
	}

	/**
	 * сохранияем в лог сообщение
	 */
	public function setMessageLog($error, $level = 'error', $category = 'btc')
	{
		if (is_array($error)) {
			$this->errors_message = array_merge($this->errors_message, $error);
			return;
		}
		$this->errors_message[] = $error;
		\Yii::log($error, $level, $category);
	}

	/**
	 * получаем сообщения
	 */
	public function getMessageLog()
	{
		return $this->errors_message;
	}

	/**
	 * вернет базовый урл
	 */
	public function getBaseUrl()
	{
		return $this->sercice_url;
	}
}