<?php

use SilverStripe\Control\HTTPRequest;

/**
 * Created by PhpStorm.
 *
 * User: simon
 * Date: 08-Jul-18
 * Time: 14:05
 *
 * @property \PropertyPage dataRecord
 * @method \PropertyPage data()
 * @mixin \PropertyPage dataRecord
 */
class PropertyPageController extends PageController
{
    private static $allowed_actions = [
        'property'
    ];

    /**
     * @param HTTPRequest $request
     */
    public function getProperty(HTTPRequest $request)
    {
        $params = $this->getURLParams();
        $this->Property = Property::get()->byID($params['ID']);
    }
}
