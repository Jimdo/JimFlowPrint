<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterInterface;
use Doctrine\ORM\EntityRepository;


abstract class EntityFilter
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;


    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function filter(array $data, $key)
    {
        $entity = $this->repository->findOneBy(array($this->getFindBy() => $data[$key]));

        if (!$entity) {
            throw new \InvalidArgumentException($data[$key] . ' has no entity');
        }

        $data[$key] = $entity;
        return $data;
    }

    protected abstract function getFindBy();
}
