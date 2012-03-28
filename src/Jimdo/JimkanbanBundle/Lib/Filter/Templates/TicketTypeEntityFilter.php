<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
use \Doctrine\ORM\EntityManager;

class TicketTypeEntityFilter implements FilterInterface {

    const ENTITY_NAME = 'JimdoJimkanbanBundle:TicketType';

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;


    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository(self::ENTITY_NAME);
    }

    public function filter(array $data, $key)
    {
        $entity = $this->repository->findOneBy(array('name' => $data[$key]));

        if (!$entity) {
            throw new \InvalidArgumentException($data[$key] . ' has no entity');
        }

        $data[$key] = $entity;
        return $data;
    }
}
