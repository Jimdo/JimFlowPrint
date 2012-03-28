<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
 
class TicketDateFilter implements FilterInterface {

    public function filter(array $data, $key) {
        $data[$key] = date('d.m.Y', strtotime(substr($data[$key], 0, 10)));

        return $data;
    }

}
