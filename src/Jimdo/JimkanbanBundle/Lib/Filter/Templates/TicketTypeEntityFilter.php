<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use \Jimdo\JimkanbanBundle\Lib\Filter\Templates\EntityFilter;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
use \Jimdo\JimkanbanBundle\Entity\TicketTypeRepository;

class TicketTypeEntityFilter extends EntityFilter implements FilterInterface
{
    const FIND_BY = 'name';

    protected function getFindBy()
    {
        return self::FIND_BY;
    }
}
