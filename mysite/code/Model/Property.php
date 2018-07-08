<?php

use SilverStripe\Assets\Image;
use SilverStripe\ORM\Filters\PartialMatchFilter;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\Filters\ExactMatchFilter;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Controller;

/**
 * Class \Property
 *
 * @property string $Title
 * @property float $PricePerNight
 * @property int $Bedrooms
 * @property int $Bathrooms
 * @property boolean $FeaturedOnHomepage
 * @property string $AvailableStart
 * @property string $AvailableEnd
 * @property string $Description
 * @property int $RegionID
 * @property int $PrimaryPhotoID
 * @property int $PageID
 * @method \Region Region()
 * @method \SilverStripe\Assets\Image PrimaryPhoto()
 * @method \PropertyPage Page()
 */
class Property extends DataObject
{

    /**
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar',
        'PricePerNight' => 'Currency',
        'Bedrooms' => 'Int',
        'Bathrooms' => 'Int',
        'FeaturedOnHomepage' => 'Boolean',
        'AvailableStart' => 'Date',
        'AvailableEnd' => 'Date',
        'Description' => 'Text'
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Region' => Region::class,
        'PrimaryPhoto' => Image::class,
        'Page' => PropertyPage::class
    );

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Title' => 'Title',
        'Region.Title' => 'Region',
        'PricePerNight.Nice' => 'Price',
        'FeaturedOnHomepage.Nice' => 'Featured?'
    );

    /**
     * Return the searchable fields for our gridfield.
     * @return array
     */
    public function searchableFields()
    {
        return array(
            'Title' => array(
                'filter' => PartialMatchFilter::class,
                'title' => 'Title',
                'field' => TextField::class
            ),
            'RegionID' => array(
                'filter' => ExactMatchFilter::class,
                'title' => 'Region',
                'field' => DropdownField::create('RegionID')
                    ->setSource(
                        Region::get()->map('ID', 'Title')
                    )
                    ->setEmptyString('-- Any region --')
            ),
            'FeaturedOnHomepage' => array(
                'filter' => ExactMatchFilter::class,
                'title' => 'Only featured'
            )
        );
    }

    /**
     * Return the CMSFields for our Property ModelAdmin
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title'),
            TextareaField::create('Description'),
            CurrencyField::create('PricePerNight', 'Price (per night)'),
            DropdownField::create('Bedrooms')
                ->setSource(ArrayLib::valuekey(range(1, 10))),
            DropdownField::create('Bathrooms')
                ->setSource(ArrayLib::valuekey(range(1, 10))),
            DropdownField::create('RegionID', 'Region')
                ->setSource(Region::get()->map('ID', 'Title'))
                ->setEmptyString('-- Select a region --'),
            DropdownField::create('PageID', 'Page')
                ->setSource(PropertyPage::get()->map('ID', 'Title'))
                ->setEmptyString('-- Select a page --'),
        CheckboxField::create('FeaturedOnHomepage', 'Feature on homepage')
        ));

        $fields->addFieldToTab('Root.Photos', $upload = UploadField::create(
            'PrimaryPhoto',
            'Primary photo'
        ));

        $upload->getValidator()->setAllowedExtensions(array(
            'png',
            'jpeg',
            'jpg',
            'gif'
        ));

        $upload->setFolderName('property-photos');
        return $fields;
    }

    public function Link()
    {
        $page = $this->Page();
        if (!$this->PageID || $page->exists()) {
            $page = PropertyPage::get()->first();
            $this->PageID = $page->ID;
            $this->write();
        }

        return $page->Link('property/' . $this->ID);
    }


    public function LinkingMode()
    {
        return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
    }

    public function getContent()
    {
        return $this->Description;
    }
}
