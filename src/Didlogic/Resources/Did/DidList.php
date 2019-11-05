<?php


namespace Didlogic\Resources\Did;


use Didlogic\Resources\ResourceList;

/**
 * Class DidList
 * @package Didlogic\Resources\Did
 */
class DidList extends ResourceList
{
    /**
     * DidList constructor.
     * @param Did ...$resources
     */
    public function __construct(Did ...$resources)
    {
        parent::__construct($resources);
    }
}