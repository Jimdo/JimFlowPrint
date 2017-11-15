<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates;

use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates\Entity;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterInterface;

class SkillEntityFilter extends Entity implements FilterInterface
{
    const FIND_BY = 'name';

    /**
     * @return mixed|string
     */
    protected function getFindBy()
    {
        return self::FIND_BY;
    }

    /**
     * @param array $data
     * @param $key
     * 
     * @return array
     */
    public function filter(array $data, $key)
    {
        $skills = explode(';', $data[$key]);

        $entities = $this->getRepository()->findInNames($skills);

        $data[$key] = array_slice($entities, 0, 4);

        return $data;
    }

    /**
     * @param $data
     * @param $key
     * 
     * @return array|mixed
     */
    protected function handleNullResult($data, $key)
    {
        return [];
    }
}
