<?php
class DLanguageHttpRequest extends CHttpRequest
{
	private $_requestUri;

	public function getRequestUri()
	{
		if ($this->_requestUri === null)
			$this->_requestUri = DMultilangHelper::processLangInUrl(parent::getRequestUri());

		return $this->_requestUri;
	}

	public function getOriginalUrl()
	{
		return $this->getOriginalRequestUri();
	}

	public function getOriginalRequestUri()
	{
		return DMultilangHelper::addLangToUrl($this->getRequestUri());
	}
}