<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates\Entity;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterInterface;
use \Jimdo\JimFlow\PrintTicketBundle\Entity\TicketTypeRepository;
use Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType;

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
