<?php

use GraphQL\Type\Definition\Type;
use SilverStripe\GraphQL\TypeCreator;
use SilverStripe\GraphQL\Pagination\Connection;

class PropertyTypeCreator extends TypeCreator
{
    public function attributes()
    {
        return [
            'name' => 'Property'
        ];
    }

    public function fields()
    {
        $regionConnection = Connection::create('Region')
            ->setConnectionType($this->manager->getType('Region'))
            ->setDescription('The properties region')
            ->setSortableFields(['ID', 'Title', "Description"]);

        return [
            'ID' => ['type' => Type::nonNull(Type::id()), 'description' => 'The Primary Key of this property'],
            'Title' => ['type' => Type::string(), 'description' => 'The property title or name'],
            'Bedrooms' => ['type' => Type::int(), 'description' => 'The number of bedrooms this property has'],
            'Bathrooms' => ['type' => Type::int(), 'description' => 'The number of bathrooms this property has'],
            'AvailableStart' => ['type' => Type::string(), 'description' => 'The date this property is available from'],
            'AvailableEnd' => ['type' => Type::string(), 'description' => 'The date this property is available to'],
            'Description' => ['type' => Type::string(), 'description' => 'A description of the property'],
            'Region' => [
                'type' => $regionConnection->toType(),
                'args' => $regionConnection->args(),
                'resolve' => function (Property $obj, $args, $context) use ($regionConnection) {
                    return $regionConnection->resolveList(
                        // not ideal.
                        new \SilverStripe\ORM\ArrayList([$obj->Region()]),
                        $args,
                        $context
                    );
                }
            ]
        ];
    }
}