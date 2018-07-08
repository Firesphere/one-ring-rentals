<?php

use SilverStripe\ORM\DataObject;

/**
 * Class \ArticleComment
 *
 * @property string $Name
 * @property string $Email
 * @property string $Comment
 * @property int $ArticlePageID
 * @method \ArticlePage ArticlePage()
 */
class ArticleComment extends DataObject
{

    private static $db = array(
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'Comment' => 'Text'
    );


    private static $has_one = array(
        'ArticlePage' => 'ArticlePage'
    );
}