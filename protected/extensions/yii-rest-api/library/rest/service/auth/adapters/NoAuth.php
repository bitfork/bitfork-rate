<?php
/**
 * Yii RESTful API
 *
 * @link      https://github.com/paysio/yii-rest-api
 * @copyright Copyright (c) 2012 Pays I/O Ltd. (http://pays.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT license
 * @package   REST_Service
 */

namespace rest\service\auth\adapters;

use rest\service\auth\AdapterInterface;

class NoAuth implements AdapterInterface
{
    /**
     * @var string
     */
    public $realm = 'API';

    /**
     * @var string
     */
    public $identityClass = 'application.components.UserIdentity';

    /**
     * @throws \CHttpException
     */
    public function authenticate()
    {
    }
}