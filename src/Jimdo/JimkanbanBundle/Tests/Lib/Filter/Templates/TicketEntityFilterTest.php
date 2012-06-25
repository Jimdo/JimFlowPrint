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

        $repository = $this->getRepository();
        $repository->expects($this->any())
                ->method('findOneBy')
                ->will($this->returnValue($entity));

        $filter = new TicketTypeEntityFilter($repository);

        $data = array($someKeyName => $someName);

        $data = $filter->filter($data, $someKeyName);
        $testEntity = $data[$someKeyName];

        $this->assertEquals($someName, $testEntity->getName());

    }

    /**
     * @test
     */
    public function itShould()
    {
        $someName = self::SOME_VALID_NAME;
        $someKeyName = self::SOME_FILTER_KEY_NAME;
        $entity = null;

        $repository = $this->getRepository();

        //make sure Repository returns no entity
        $repository->expects($this->any())
                ->method('findOneBy')
                ->will($this->returnValue($entity));

        //Filter should now call findOneBy for the second time, but this time trying to get the fallback Entity
        $repository->expects($this->at(1))
                ->method('findOneBy')
                ->with($this->equalTo(array('isFallback' => true)));

        $data = array($someKeyName => $someName);
        $filter = new TicketTypeEntityFilter($repository);
        $data = $filter->filter($data, $someKeyName);
        $testEntity = $data[$someKeyName];
    }

    private function getRepository()
    {
        $repository = $this->getMock(
            '\Jimdo\JimkanbanBundle\Entity\TicketTypeRepository',
            array('findOneBy'),
            array(),
            '',
            false
        );

        return $repository;
    }
}
