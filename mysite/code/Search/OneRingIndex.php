<?php

namespace Gandalf\OneRingRentals\Indexes;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\FullTextSearch\Solr\SolrIndex;

class OneRingIndex extends SolrIndex
{

    /**
     * Initialise the index
     */
    public function init()
    {
        $this->addClass(SiteTree::class);
        $this->addClass('Region');
        $this->addClass(\Property::class);

        $this->addFulltextField('Title');
        $this->addFulltextField('Description');
        $this->addFulltextField('Content');
        $this->addFulltextField('Regions.Title');
        $this->addFulltextField('Regions.Description');

        parent::init();
    }
}
