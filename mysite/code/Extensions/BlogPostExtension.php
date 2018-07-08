<?php

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

/**
 * Class \BlogPostExtension
 *
 * @property \BlogPostExtension $owner
 * @property boolean $IsFeatured
 */
class BlogPostExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'IsFeatured' => 'Boolean',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $sidebar = $fields->fieldByName('blog-admin-sidebar');
        $sidebar->insertBefore('PublishDate', new CheckboxField('IsFeatured', 'Mark as featured post'));
    }
}
