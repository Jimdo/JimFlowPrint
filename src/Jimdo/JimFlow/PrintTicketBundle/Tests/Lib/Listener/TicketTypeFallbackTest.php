<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Filter;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Listener\TicketTypeFallback;
use \Doctrine\ORM\EntityManager;

class TicketTypeFallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldIgnoreEntitiesNotTicketType()
    {
        //Not TicketType Entity
        $entity = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Entity\Printer', array(), array(), '', false);
        //If not TicketType, it should never be asked if it's the fallback type
        $entity->expects($this->never())->method('getIsFallback');

        $em = $this->getEntityManager();

        $eventArgs = $this->getEventArgs($em, $entity);

        $listener = new TicketTypeFallback();
        $listener->postPersist($eventArgs);

    }

    /**
     * @test
     */
    public function itShouldCheckIfEntityIsSupposedToBeFallback()
    {
        $entity = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType', array(), array(), '', false);
        $em = $this->getEntityManager();

        $entity->expects($this->once())->method('getIsFallback');

        $listener = new TicketTypeFallback();
        $listener->postPersist($this->getEventArgs($em, $entity));
    }

    private function getEntityManager()
    {
        return $this->getMock('\Doctrine\ORM\EntityManager', array(), array(), '', false);
    }

    private function getEventArgs($em, $entity)
    {
        $eventArgs = $this->getMock(
            '\Doctrine\ORM\Event\LifecycleEventArgs',
            array(),
            array(),
            '',
            false
        );
        $eventArgs->expects($this->any())->method('getEntity')->will($this->returnValue($entity));
        $eventArgs->expects($this->any())->method('getEntityManager')->will($this->returnValue($em));

        return $eventArgs;
    }

    /**
     * @test
     */
    public function itShouldSetIsFallbackToFalseForEveryEntityButTheGivenOne()
    {
        $someEntity = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType', array(), array(), '', false);
        $someEntities = array($someEntity);
        $someId = 1;

        $entity = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType', array(), array(), '', false);
        $repository = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Entity\TicketTypeRepository', array(), array(), '', false);
        $em = $this->getEntityManager();

        $someEntity->expects($this->once())->method('setIsFallback')->with(false);

        $entity->expects($this->once())->method('getId')->will($this->returnValue($someId));
        $entity->expects($this->once())->method('getIsFallback')->will($this->returnValue(true));

        $repository->expects($this->once())->method('findBeingFallbackAndNotBeingEntity')->with($someId)->will($this->returnValue($someEntities));


        $em->expects($this->once())->method('getRepository')->will($this->returnValue($repository));
        $em->expects($this->once())->method('persist')->with($someEntity);

        $listener = new TicketTypeFallback();
        $listener->postPersist($this->getEventArgs($em, $entity));
    }
}
