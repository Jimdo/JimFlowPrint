<?php

namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\TicketDateFilter;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\TicketTypeEntityFilter;


class FilterChain
{
    private $dateFilter;
    private $ticketTypeEntityFilter;

    public function __construct(TicketDateFilter $dateFilter, TicketTypeEntityFilter $ticketTypeEntityFilter)
    {
        $this->dateFilter = $dateFilter;
        $this->ticketTypeEntityFilter = $ticketTypeEntityFilter;
    }

    public function filter(array $data)
    {
        $data = $this->dateFilter->filter($data, 'date');
        $data = $this->ticketTypeEntityFilter->filter($data, 'type');

        return $data;
    }
}