<?php
/**
 * Yii RESTful API
 *
 * @link      https://github.com/paysio/yii-rest-api
 * @copyright Copyright (c) 2012 Pays I/O Ltd. (http://pays.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT license
 * @package   REST_Controller
 */

namespace rest\controller;

class MyBehavior extends Behavior
{
    /**
     * Redirects the browser to the specified URL or route (controller/action).
     * @param mixed $url the URL to be redirected to. If the parameter is an array,
     * the first element must be a route to a controller action and the rest
     * are GET parameters in name-value pairs.
     * @param boolean|integer $terminate whether to terminate OR REST response status code !!!
	 * @param integer $statusCode the HTTP status code. Defaults to 302. See {@link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html}
     * for details about HTTP status code.
     */
    public function redirectRest($url, $terminate = true, $statusCode = 302)
    {
        if ($this->hasEventHandler('onBeforeRedirect')) {
            $this->onBeforeRedirect(new \CEvent($this, array('url' => &$url, 'terminate' => &$terminate, 'statusCode' => &$statusCode)));
        }

        $model = $this->replaceModelIdInUrl($url);

        $this->getOwner()->disableBehavior($this->behaviorName);
        if ($this->isRestService()) {
            if ($statusCode == 201) {
                $this->getOwner()->redirect($url, false, 201);
            } else {
                $statusCode = 200;
            }
            $this->getRestService()->sendData(array('data'=>$model), null, $statusCode);
        }

        $this->getOwner()->redirect($url, $terminate);
        $this->getOwner()->enableBehavior($this->behaviorName);
    }
}