<?php
namespace Jimdo\JimkanbanBundle\Tests\Lib\Filter\Templates;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\TicketTypeEntityFilter;

class TicketEntityFilterTest extends \PHPUnit_Framework_TestCase
{
    const SOME_VALID_NAME = 'online marketing';
    const SOME_INVALID_NAME = 'deine mudda';
    const SOME_FILTER_KEY_NAME = 'type';


    /**
     * @test
     */
    public function itShouldAllowToGetTheTicketTypeByName()
    {

        $someName = self::SOME_VALID_NAME;
        $someKeyName = self::SOME_FILTER_KEY_NAME;

        $entity = $this->getMock(
            'Jimdo\JimkanbanBundle\Entity',
            array('getName'),
            array(),
            '',
            false
        );

        $entity->expects($this->any())
                ->method('getName')
                ->will($this->returnValue($someName));

        $em = $this->getEntityManager($entity);

        $filter = new TicketTypeEntityFilter($em);

        $data = array($someKeyName => $someName);

        $data = $filter->filter($data, $someKeyName);
        $testEntity = $data[$someKeyName];

        $this->assertEquals($someName, $testEntity->getName());

    }


    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function itShouldThrowAnInvalidArgumentExceptionIfTypeIsNotFoundByName()
    {
        $someName = self::SOME_VALID_NAME;
        $someKeyName = self::SOME_FILTER_KEY_NAME;
        $notFoundEntity = null;

        $data = array($someKeyName => $someName);

        $em = $this->getEntityManager($notFoundEntity);

        $filter = new TicketTypeEntityFilter($em);
        $filter->filter($data, $someKeyName);
    }

    private function getEntityManager($entity)
    {
        $repository = $this->getMock(
            '\Doctrine\ORM\EntityRepository',
            array('findOneBy'),
            array(),
            '',
            false
        );
        $repository->expects($this->once())
                ->method('findOneBy')
                ->will($this->returnValue($entity));

        $em = $this->getMock(
            '\Doctrine\ORM\EntityManager',
            array('getRepository'),
            array(),
            '',
            false
        );
        $em->expects($this->once())
                ->method('getRepository')
                ->will($this->returnValue($repository));

        return $em;
    }
}
