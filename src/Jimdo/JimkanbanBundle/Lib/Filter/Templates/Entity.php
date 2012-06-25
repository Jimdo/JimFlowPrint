<?php
namespace Jimdo\JimkanbanBundle\Lib\Filter\Templates;
use Doctrine\ORM\EntityRepository;

abstract class Entity
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function findOneBy($value)
    {
        return $this->repository->findOneBy(array($this->getFindBy() => $value));
    }

    public function filter(array $data, $key)
    {
        $entity = $this->findOneBy($data[$key]);

        if (null === $entity) {
            return $this->handleNullResult($data, $key);
        }

        $data[$key] = $entity;

        return $data;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    abstract protected function getFindBy();
    abstract protected function handleNullResult($data, $key);
}
