<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;

class TicketIdFilter implements FilterInterface
{
    /**
     * @param array $data
     * @param $key
     * @return array
     */
    public function filter(array $data, $key)
    {
        $data[$key] = str_replace('#', '', $data[$key]);

        return $data;
    }
}
