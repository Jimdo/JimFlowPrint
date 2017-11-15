<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SkillRepository
 */
class SkillRepository extends EntityRepository
{
    /**
     * @param array $names
     * 
     * @return array
     */
    public function findInNames(array $names = [])
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder
            ->add('select', 'ss')
            ->add('from', '\Jimdo\JimFlow\PrintTicketBundle\Entity\Skill ss')
            ->andWhere('ss.name IN (:skills)')
            ->setParameter('skills', $names);

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
