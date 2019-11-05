<?php


namespace Didlogic\Resources\Destination;


use Didlogic\Resources\ResourceList;

/**
 * Class DestinationList
 * @package Didlogic\Resources\Destination
 */
class DestinationList extends ResourceList
{
    /**
     * DestinationList constructor.
     * @param Destination ...$resources
     */
    public function __construct(Destination ...$resources)
    {
        parent::__construct($resources);
    }
}