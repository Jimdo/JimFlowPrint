<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates;

use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterInterface;

class TeamMemberFilter implements FilterInterface
{
    /**
     * @param array $data
     * @param string $key
     * 
     * @return array
     */
    public function filter(array $data, $key)
    {
        $members = explode(';', $data[$key]);

        $data[$key] = $members;

        return $data;
    }
}
