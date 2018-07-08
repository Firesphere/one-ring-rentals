<?php

/**
 * Class \PropertyPage
 *
 * @method \SilverStripe\ORM\DataList|\Property[] Properties()
 */
class PropertyPage extends Page
{

    private static $has_many = [
        'Properties' => 'Property'
    ];
}
