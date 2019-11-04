<?php


namespace Didlogic\Resources\Country;


use Didlogic\Resources\ResourceList;

class CountryList extends ResourceList
{
    public function __construct(Country ...$resources)
    {
        parent::__construct($resources);
    }
}