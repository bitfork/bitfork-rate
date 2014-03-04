<?php
class MyHttp
{
	private $_curl = null;
	private $_is_cache = false;
    public $info = array();
    public $options = array();
    public $min_delay = 0;
    public $max_delay = 0;
	private $errors_message = array();

    public function __construct($options = array(), $min_delay = 0, $max_delay = 0)
    {
        $this->options['return'] = 1;
        $this->options['agent'] = 1;
		$this->options['header'] = 0;
		$this->options['timeout'] = 30;
		$this->options['ssl'] = 0;
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }
        $this->min_delay = $min_delay;
        $this->max_delay = $max_delay;
    }

	public function setCache($is = true)
	{
		$this->_is_cache = $is;
	}

	public function setOptions()
	{
        if (isset($this->options['return'])) curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, $this->options['return']);
        if (isset($this->options['agent'])) curl_setopt($this->_curl, CURLOPT_USERAGENT, $this->getAgent());
        if (isset($this->options['fallow'])) curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, $this->options['fallow']);
		if (isset($this->options['header'])) curl_setopt($this->_curl, CURLOPT_HEADER, $this->options['header']);
		if (isset($this->options['timeout'])) curl_setopt($this->_curl, CURLOPT_TIMEOUT, $this->options['timeout']);
		if (isset($this->options['timeout'])) curl_setopt($this->_curl, CURLOPT_CONNECTTIMEOUT, $this->options['timeout']);
		if (isset($this->options['ssl'])) curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, $this->options['ssl']);
        return true;
    }

    public function setUrl($url)
    {
        $url = trim($url);
        $url = str_replace(' ', '%20', $url);
        if (!preg_match('!^\w+://! i', $url)) {
            $url = 'http://'.$url;
        }
        curl_setopt($this->_curl, CURLOPT_URL, $url);
    }

    public function setReferer($url)
    {
        curl_setopt($this->_curl, CURLOPT_REFERER, $url);
    }

    public function run($url, $referer = '')
    {
		$contents = false;
		if ($this->_is_cache) {
			$contents = Yii::app()->cache->get($url);
		}
		if ($contents === false)
		{
			usleep(rand($this->min_delay, $this->max_delay));

			$this->_curl = curl_init();
			$this->setUrl($url);
			if ($referer!='') $this->setReferer($referer);
			if ($this->setOptions()===false) {
				curl_close($this->_curl);
				return false;
			}
			$contents = trim(curl_exec($this->_curl));
			$error_code = curl_errno($this->_curl);

			if ($contents === false or $error_code != 0) {
				$this->error_code = curl_errno($this->_curl);
				$this->error_string = curl_error($this->_curl);
				curl_close($this->_curl);
				$this->setMessageLog("Error code: ". $this->error_code ." - Error string: ". $this->error_string .' - '. $url, 'error');
				return false;
			} else {
				$this->info = curl_getinfo($this->_curl);
				curl_close($this->_curl);

				if ($this->options['header']===true or $this->options['header']==1) {
					if (preg_match('/^Location: ([^\r\n\ ]*)/ium', $contents, $match)) {
						if (isset($match[1])) {
							$this->info['location'] = $match[1];
						}
					}
				}

				if (isset($this->info['http_code']) && ($this->info['http_code'] == 301 || $this->info['http_code'] == 302) && ($this->options['header']===false || $this->options['header']==0)) {
					$this->options['header'] = true;
					return $this->run($url, $referer);
				}

				if (isset($this->info['http_code']) && $this->info['http_code'] == 404) {
					$this->setMessageLog('page http_code 404 '. $url, 'error');
					return false;
				}

				$contents = str_replace('nobr', 'span', $contents);
			}

			if ($this->_is_cache) {
				Yii::app()->cache->set($url, array($contents, $this->info), Yii::app()->params['timeLimitCacheCurl']);
			} else {
				return $contents;
			}
		}

		if (is_array($contents)) {
			$this->info = (isset($contents[1])) ? $contents[1] : '';
			$contents = (isset($contents[0])) ? $contents[0] : '';
		}

		return $contents;
    }

    protected function getAgent()
    {
         $agents = array(
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.0.1) Gecko',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Maxthon 2.0',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET)',
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.0.4) Gecko',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MyIE2',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; en) Opera',
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko',
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1a2) Gecko',
            'Opera/9.00 (Windows NT 5.1; U; ru)',
            'Opera/9.00 (Windows NT 5.2; U; ru)'
        );
        
        return $agents[array_rand($agents, 1)];
    }
    
    /**
     * сохранияем в лог сообщение
     */
    protected function setMessageLog($error, $level = 'info', $category = 'grabber')
    {
		$this->errors_message[] = $error;
        Yii::log($error, $level, $category);
    }

	/**
	 * получаем сообщения
	 */
	public function getMessageLog()
	{
		return $this->errors_message;
	}
}