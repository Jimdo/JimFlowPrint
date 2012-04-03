<?php

namespace Jimdo\JimkanbanBundle\Lib\Filter;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\TicketDateFilter;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\TicketTypeEntityFilter;


class FilterChain
{
    /**
     * @var array
     */
    private $registeredFilters;


    /**
     * @param FilterInterface $filter
     * @param $key
     * @return void
     */
    public function add(FilterInterface $filter, $key) {
        $this->registeredFilters[$key][] = $filter;
    }

    /**
     * @param array $data
     * @return array
     */
    public function filter(array $data)
    {
        foreach ($this->registeredFilters as $key => $filters) {
            foreach ($filters as $filter) {
                $data = $filter->filter($data, $key);
            }
        }

        return $data;
    }
}