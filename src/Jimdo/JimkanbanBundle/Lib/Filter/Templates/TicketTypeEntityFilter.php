<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
use \Jimdo\JimkanbanBundle\Entity\TicketTypeRepository;

class TicketTypeEntityFilter implements FilterInterface {

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;


    public function __construct(TicketTypeRepository $repository)
    {
        $this->repository = $repository;
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
