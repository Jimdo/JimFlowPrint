<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates;
use Doctrine\ORM\EntityRepository;

abstract class Entity
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $value
     * @return object
     */
    protected function findOneBy($value)
    {
        return $this->repository->findOneBy(array($this->getFindBy() => $value));
    }

    /**
     * @param array $data
     * @param $key
     * @return array
     */
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

    /**
     * @abstract
     * @return mixed
     */
    abstract protected function getFindBy();

    /**
     * @abstract
     * @param $data
     * @param $key
     * @return mixed
     */
    abstract protected function handleNullResult($data, $key);
}
