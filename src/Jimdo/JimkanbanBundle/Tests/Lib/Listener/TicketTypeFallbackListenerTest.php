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

        $eventArgs = $this->getMock(
            '\Doctrine\ORM\Event\LifecycleEventArgs',
            array('getEntity', 'getEntityManager'),
            array($em, $entity)
        );

        $listener = new TicketTypeFallbackListener($eventArgs);
        $listener->postPersist($eventArgs);

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
}
