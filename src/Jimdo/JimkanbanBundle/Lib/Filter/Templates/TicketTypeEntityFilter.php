<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use \Jimdo\JimkanbanBundle\Lib\Filter\Templates\Entity;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
use \Jimdo\JimkanbanBundle\Entity\TicketTypeRepository;

class TicketTypeEntityFilter extends Entity implements FilterInterface
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
     * @param $data
     * @param $key
     * @return array|mixed
     */
    protected function handleNullResult($data, $key)
    {
        /**
         * @var TicketTypeRepository
         */
        $repository = $this->getRepository();

        $data[$key] =  $repository->findOneBy(array('isFallback' => true));

        return $data;

    }
}
