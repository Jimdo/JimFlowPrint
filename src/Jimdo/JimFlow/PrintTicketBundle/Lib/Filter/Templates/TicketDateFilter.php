<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterInterface;

class TicketDateFilter implements FilterInterface
{

    /**
     * @param array $data
     * @param $key
     * @return array|mixed
     */
    public function filter(array $data, $key)
    {
        $data[$key] = date('Y-m-d', strtotime(substr($data[$key], 0, 10)));

        return $data;
    }

}
