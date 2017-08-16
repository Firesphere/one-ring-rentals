<?php
use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\Pagination\Connection;
use SilverStripe\GraphQL\Pagination\PaginatedQueryCreator;

class PaginatedReadPropertiesQueryCreator extends PaginatedQueryCreator
{
    public function createConnection()
    {
        return Connection::create('paginatedReadProperties')
            ->setConnectionType($this->manager->getType('Property'))
            ->setArgs([
                'Title' => [
                    'type' => Type::string(),
                    'description' => "Filter the properties by the title"
                ]
            ])

            // setup some default limits should there be none by the client.
            ->setDefaultLimit(10)
            ->setMaximumLimit(100)

            ->setSortableFields(['ID', 'Title', "PricePerNight"])
            ->setConnectionResolver(function ($obj, $args, $context) {
                $property = Property::singleton();
                if (!$property->canView($context['currentUser'])) {
                    throw new \InvalidArgumentException(sprintf(
                        '%s view access not permitted',
                        Property::class
                    ));
                }

                $list = Property::get();

                // Optional filtering by properties
                if (isset($args['Title'])) {
                    $list = $list->filter('Title:PartialMatch', $args['Title']);
                }

                return $list;
            });
    }
}