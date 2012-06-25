<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use \Jimdo\JimkanbanBundle\Lib\Filter\Templates\Entity;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
use \Jimdo\JimkanbanBundle\Entity\TicketTypeRepository;
use Jimdo\JimkanbanBundle\Entity\TicketType;

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
        if (!$entity = $this->getFallbackTicketType()) {
            $entity = $this->getNoneTicketType();
        }

        $data[$key] = $entity;

        return $data;
    }

    private function getFallbackTicketType()
    {
        /**
         * @var TicketTypeRepository
         */
        $repository = $this->getRepository();
        return $repository->findOneBy(array('isFallback' => true));
    }

    private function getNoneTicketType()
    {
        $entity = new TicketType();
        $entity->setName('NONE CONFIGURED!');
        $entity->setBackgroundColor('ff0000');

        return $entity;
    }
}
