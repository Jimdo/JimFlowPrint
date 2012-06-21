<?php

namespace Jimdo\JimkanbanBundle\Tests\Lib\Filter;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimkanbanBundle\Lib\Listener\TicketTypeFallbackListener;
use \Doctrine\ORM\EntityManager;

class TicketTypeFallbackListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldIgnoreEntitiesNotTicketType()
    {
        //Not TicketType Entity
        $entity = $this->getMock('\Jimdo\JimkanbanBundle\Entity\Printer', array(), array(), '', false);
        //If not TicketType, it should never be asked if it's the fallback type
        $entity->expects($this->never())->method('getIsFallback');

        $em = $this->getEntityManager();

        $eventArgs = $this->getEventArgs($em, $entity);

        $listener = new TicketTypeFallbackListener();
        $listener->postPersist($eventArgs);

    }

    /**
     * @test
     */
    public function itShouldCheckIfEntityIsSupposedToBeFallback()
    {
        $entity = $this->getMock('\Jimdo\JimkanbanBundle\Entity\TicketType', array(), array(), '', false);
        $em = $this->getEntityManager();

        $entity->expects($this->once())->method('getIsFallback');

        $listener = new TicketTypeFallbackListener();
        $listener->postPersist($this->getEventArgs($em, $entity));
    }

    /**
     * @test
     */
    public function itShouldNotUpdateTheNewFallbackTicketType()
    {
        $em = $this->getEntityManager();
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
}
