<?php


namespace Didlogic\Resources;


class ResourceList implements \IteratorAggregate
{
    private $resources;

    public function __construct(array $resources)
    {
        $this->resources = $resources;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->resources);
    }
}