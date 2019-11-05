<?php


namespace Didlogic\Resources;


/**
 * Class ResourceList
 * @package Didlogic\Resources
 */
class ResourceList implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $resources;

    /**
     * ResourceList constructor.
     * @param array $resources
     */
    public function __construct(array $resources)
    {
        $this->resources = $resources;
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->resources);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->resources;
    }
}