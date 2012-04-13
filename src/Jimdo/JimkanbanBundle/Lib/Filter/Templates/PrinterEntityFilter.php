<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\EntityFilter;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
use \Jimdo\JimkanbanBundle\Entity\PrinterRepository;

class PrinterEntityFilter extends EntityFilter implements FilterInterface
{
    const FIND_BY = 'id';

    protected function getFindBy()
    {
        return self::FIND_BY;
    }
}
