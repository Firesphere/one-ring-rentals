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

    public function index(HTTPRequest $request)
    {
        $searchVars = $request->getVar('search');
        if ($searchVars) {
            /** @var OneRingIndex $index */
            $index = Injector::inst()->get(OneRingIndex::class);
            $query = new SearchQuery();
            $this->Query = $searchVars;
            $query->addSearchTerm($searchVars);

            $this->dataRecord->Results = $index->search($query)->Matches;

            $response = $this->customise(['SearchResults' => $this->SearchResults]);

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