<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\Entity;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;

class PrinterEntityFilter extends Entity implements FilterInterface
{
    const FIND_BY = 'id';

    protected function getFindBy()
    {
        return self::FIND_BY;
    }

    protected function handleNullResult($data, $key)
    {
        $data[$key] = null;

        return $data;
    }
}
