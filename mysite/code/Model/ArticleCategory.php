<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

/**
 * Class \ArticleCategory
 *
 * @property string $Title
 * @property int $ArticleHolderID
 * @method \ArticleHolder ArticleHolder()
 * @method \SilverStripe\ORM\ManyManyList|\ArticlePage[] Articles()
 */
class ArticleCategory extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar'
    );


    private static $has_one = array(
        'ArticleHolder' => 'ArticleHolder'
    );


    private static $belongs_many_many = array(
        'Articles' => 'ArticlePage',
    );


    public function getCMSFields()
    {
        return FieldList::create(
            TextField::create('Title')
        );
    }

    public function Link()
    {
        return $this->ArticleHolder()->Link(
            'category/' . $this->ID
        );
    }
}
