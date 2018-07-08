<?php

/**
 * Class \HomePageController
 *
 * @property \HomePage dataRecord
 * @method \HomePage data()
 * @mixin \HomePage dataRecord
 */
class HomePageController extends PageController
{

    public function LatestArticles($count = 3)
    {
        return ArticlePage::get()
            ->sort('Created', 'DESC')
            ->limit($count);
    }

    public function FeaturedProperties()
    {
        return Property::get()
            ->filter(array(
                'FeaturedOnHomepage' => true
            ))
            ->limit(6);
    }
}