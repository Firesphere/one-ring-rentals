<?php

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;

/**
 * Class \SolrIndexExtension
 *
 * @property \SolrIndexExtension $owner
 */
class SolrIndexExtension extends DataExtension
{
    /**
     * Map facet fields to DataObjects
     * @var array
     */
    public static $facet_fields = [
        'Region' => [
            'RegionsPage_Regions_ID',
            'Property_RegionID'
        ]
    ];

    /**
     * @param ArrayData $return
     * @param Apache_Solr_Response $results
     */
    public function updateSearchResults($return, $results)
    {
        $facets = $this->handleFacetFields($results);

        $return->setField('Facets', $facets);
    }

    /**
     * @param Apache_Solr_Response $searchResults
     * @return ArrayData
     */
    protected function handleFacetFields($searchResults)
    {
        $solrFacets = (array)$searchResults->facet_counts->facet_fields;
        $facetArray = [];
        foreach (static::$facet_fields as $object => $facets) {
            $facetList = $this->getFacetList($facets, $solrFacets);
            if (count($facetList)) {
                $fIDs = array_keys($facetList);
                /** @var DataList $items */
                $items = $object::get()->filter(['ID' => $fIDs]);
                if ($items->count()) {
                    $facetArray = $this->addFacetItems($items, $facetList, $object, $facetArray);
                }
            }
        }

        return ArrayData::create($facetArray);
    }


    /**
     * @param DataList|DataObject[] $items
     * @param array $facetList
     * @param string $object
     * @param array $facetArray
     * @return array
     */
    protected function addFacetItems($items, $facetList, $object, $facetArray)
    {
        $itemList = ArrayList::create();

        foreach ($items as $item) {
            $item->FacetCount = $facetList[$item->ID];
            $itemList->push($item);
        }

        $itemList = $itemList->sort(['FacetCount' => 'DESC', 'Title' => 'ASC',]);
        $facetArray[$object] = $itemList;

        return $facetArray;
    }

    /**
     * @param array $facets
     * @param array $solrFacets
     * @return array
     */
    protected function getFacetList($facets, $solrFacets)
    {
        $facetList = [];
        foreach ($facets as $facetField) {
            $solrFacetArray = (array)$solrFacets[$facetField];
            foreach ($solrFacetArray as $itemID => $itemCount) {
                if (isset($facetList[$itemID]) && $itemCount < $facetList[$itemID]) {
                    $itemCount = $facetList[$itemID];
                }
                $facetList[$itemID] = $itemCount;
            }
        }

        return $facetList;
    }

}