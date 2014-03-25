<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ApiController extends CController
{
	/*public function init()
	{
		parent::init();
		// override methods to make sure we handle api errors
		Yii::app()->attachEventHandler('onError', array($this, 'apiErrorHandler'));
		Yii::app()->attachEventHandler('onException',array($this,'apiErrorHandler'));
	}*/

	/**
	 * Error handler, when there is an error this will fire
	 * @param CEvent $event
	 */
	/*public function apiErrorHandler(CEvent $event)
	{
		echo "<pre>";
		print_r($event);
		echo "</pre>";
		$event->handled = true;
		if($event instanceof CErrorEvent) {
			throw new ErrorException($event->message, $event->statusCode, 0, $event->file, $event->line);
		}
		Yii::app()->end();
	}*/

	public function behaviors()
	{
		return array(
			'restAPI' => array('class' => '\rest\controller\MyBehavior')
		);
	}

	/**
	 * Renders a view with a layout.
	 *
	 * @param string $view name of the view to be rendered. See {@link getViewFile} for details
	 * about how the view script is resolved.
	 * @param array $data data to be extracted into PHP variables and made available to the view script
	 * @param boolean $return whether the rendering result should be returned instead of being displayed to end users.
	 * @param array $fields allowed fields to REST render
	 * @return string the rendering result. Null if the rendering result is not required.
	 * @see renderPartial
	 * @see getLayoutFile
	 */
	public function render($view, $data = null, $return = false, array $fields = array('message', 'count', 'model', 'data'))
	{
		if (($behavior = $this->asa('restAPI')) && $behavior->getEnabled()) {
			if (isset($data['model']) && $this->isRestService()/* && count(array_intersect(array_keys($data), $fields)) == 1*/) {
				$data['data'] = $data['model'];
				unset($data['model']);
				$fields = null;
			}
			return $this->renderRest($view, $data, $return, $fields);
		} else {
			return parent::render($view, $data, $return);
		}
	}

	/**
	 * Redirects the browser to the specified URL or route (controller/action).
	 * @param mixed $url the URL to be redirected to. If the parameter is an array,
	 * the first element must be a route to a controller action and the rest
	 * are GET parameters in name-value pairs.
	 * @param boolean|integer $terminate whether to terminate OR REST response status code !!!
	 * @param integer $statusCode the HTTP status code. Defaults to 302. See {@link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html}
	 * for details about HTTP status code.
	 */
	public function redirect($url, $terminate = true, $statusCode = 302)
	{
		if (($behavior = $this->asa('restAPI')) && $behavior->getEnabled()) {
			$this->redirectRest($url, $terminate, $statusCode);
		} else {
			parent::redirect($url, $terminate, $statusCode);
		}
	}
}