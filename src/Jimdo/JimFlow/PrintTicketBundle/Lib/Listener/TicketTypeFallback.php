<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Listener;

use \Doctrine\ORM\Event\LifecycleEventArgs;
use \Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType;
use Jimdo\JimFlow\PrintTicketBundle\Entity\TicketTypeRepository;

class TicketTypeFallback
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var TicketType
     */
    private $entity;

    /**
     * @param LifecycleEventArgs $args
     * @return mixed
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $this->entity = $args->getEntity();
        $em = $this->entityManager = $args->getEntityManager();

        if (!$entity instanceof TicketType) {
            return;
        } else {
            if ($this->isSupposedToBeFallback()) {
                $this->unsetCurrentFallbackTicketType();
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @return mixed
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        return $this->postPersist($args);
    }

    /**
     * @return bool
     */
    private function isSupposedToBeFallback()
    {
        return $this->entity->getIsFallback();
    }

    /**
     * @return null
     */
    private function unsetCurrentFallbackTicketType()
    {
        /**
         * @var TicketTypeRepository
         */
        $repository = $this->entityManager->getRepository('JimdoJimFlowPrintTicketBundle:TicketType');

        foreach ($repository->findBeingFallbackAndNotBeingEntity($this->entity->getId()) as $entity) {
            $entity->setIsFallback(false);
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        }
    }

}
