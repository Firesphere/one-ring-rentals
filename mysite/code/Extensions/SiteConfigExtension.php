<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

/**
 * Class \SiteConfigExtension
 *
 * @property \SilverStripe\SiteConfig\SiteConfig|\SiteConfigExtension $owner
 * @property string $FacebookLink
 * @property string $TwitterLink
 * @property string $GoogleLink
 * @property string $YouTubeLink
 * @property string $FooterContent
 */
class SiteConfigExtension extends DataExtension
{

    private static $db = array(
        'FacebookLink'  => 'Varchar',
        'TwitterLink'   => 'Varchar',
        'GoogleLink'    => 'Varchar',
        'YouTubeLink'   => 'Varchar',
        'FooterContent' => 'Text'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Social', array(
            TextField::create('FacebookLink', 'Facebook'),
            TextField::create('TwitterLink', 'Twitter'),
            TextField::create('GoogleLink', 'Google'),
            TextField::create('YouTubeLink', 'YouTube')
        ));
        $fields->addFieldToTab('Root.Main',
            TextareaField::create('FooterContent', 'Content for footer')
        );
    }
}