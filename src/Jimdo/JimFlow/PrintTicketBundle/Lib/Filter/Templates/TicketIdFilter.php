<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterInterface;

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
