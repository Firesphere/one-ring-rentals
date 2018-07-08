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

        $this->addFulltextField('Title');
        $this->addFulltextField('Content');
    }
}
