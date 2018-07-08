<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\Debug;

/**
 * Class \PropertyPageController
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
    public function property(HTTPRequest $request)
    {
        $params = $this->getURLParams();
        $this->Item = Property::get()->byID($params['ID']);

        return $this;
    }
}
