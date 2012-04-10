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

        $repository = $this->getRepository($entity);

        $filter = new TicketTypeEntityFilter($repository);

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

        $repository = $this->getRepository($notFoundEntity);

        $filter = new TicketTypeEntityFilter($repository);
        $filter->filter($data, $someKeyName);
    }

    private function getRepository($entity)
    {
        $repository = $this->getMock(
            '\Jimdo\JimkanbanBundle\Entity\TicketTypeRepository',
            array('findOneBy'),
            array(),
            '',
            false
        );
        $repository->expects($this->once())
                ->method('findOneBy')
                ->will($this->returnValue($entity));

        return $repository;
    }
}
