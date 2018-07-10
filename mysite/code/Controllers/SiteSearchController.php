<?php

use Gandalf\OneRingRentals\Indexes\OneRingIndex;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\FullTextSearch\Search\Queries\SearchQuery;

/**
 * Class \SiteSearchController
 *
 * @property \SiteSearch dataRecord
 * @method \SiteSearch data()
 * @mixin \SiteSearch dataRecord
 */
class SiteSearchController extends PageController
{
    protected $Query;

    protected $SearchLink;

    public function index(HTTPRequest $request)
    {
        $searchVars = $request->getVar('search');
        $vars = $request->getVars();
        if ($searchVars) {
            /** @var OneRingIndex $index */
            $index = Injector::inst()->get(OneRingIndex::class);

            $query = new SearchQuery();
            $this->Query = $searchVars;
            $query->addSearchTerm($searchVars);

            $index->setFieldBoosting('RegionsPage_Regions_Title', 5);
            $index->addFacetField('RegionsPage.Regions.ID');
            $index->addFacetField('Property.RegionID');
            $facetedFields = SolrIndexExtension::$facet_fields;
            foreach ($facetedFields as $facetedField => $solrFields) {
                if (isset($vars[$facetedField])) {
                    // This... is a bug, it treats the filters as "AND", not "OR"
                    foreach ($solrFields as $field) {
                        $query->addFilter($field, $vars[$facetedField]);
                    }
                }
            }

            $result = $index->search($query);
            $this->Results = $result->Matches;
            $this->Facets = $result->Facets;

            $response = $this->customise(['SearchResults' => $this->Results, 'Facets' => $this->Facets]);

            return $response->renderWith(['Page_results', 'Page']);
        }

        return $this;
    }

    public function Form()
    {
        $fields = FieldList::create([
            $searchField = TextField::create('search', 'Search', $this->Query)
        ]);

        $searchField->addExtraClass('form-control');
        $searchField->setAttribute('placeholder', 'Search One Ring Rentals');

        $actions = FieldList::create([
            FormAction::create('doSearch', 'Search')
        ]);

        $form = Form::create($this, __FUNCTION__, $fields, $actions);
        $action = SiteSearch::get()->first();
        $form->setFormAction($action->Link());
        $form->setFormMethod('GET');
        $form->disableSecurityToken();

        return $form;
    }
}
