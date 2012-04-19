<?php
namespace Jimdo\JimkanbanBundle\Tests\Lib\Filter\Templates;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\PrinterEntityFilter;

class PrinterEntityFilterTest extends \PHPUnit_Framework_TestCase
{

    const  SOME_ID = 1;
    const SOME_FILTER_KEY_NAME = 'printer';
    /**
     * @test
     */
    public function itShouldAllowToGetThePrinterEntityById()
    {
        $someId = self::SOME_ID;
        $someFilterKey = self::SOME_FILTER_KEY_NAME;

        $entity = $this->getMock(
            'Jimdo\JimkanbanBundle\Entity\Printer',
            array('getId'),
            array(),
            '',
            false
        );
        $entity->expects($this->any())
                ->method('getId')
                ->will($this->returnValue($someId));

        $repository = $this->getRepository($entity);

        $filter = new PrinterEntityFilter($repository);
        $data = array($someFilterKey => $someId);

        $data = $filter->filter($data, $someFilterKey);
        $testEntity = $data[$someFilterKey];

        $this->assertEquals($someId, $testEntity->getId());
    }


    /**
     * @test
     */
    public function itShouldSetTheValueToNullIfNoPrinterIsFound()
    {
        $someId = self::SOME_ID;
        $someKeyName = self::SOME_FILTER_KEY_NAME;
        $notFoundEntity = null;

        $data = array($someKeyName => $someId);

        $repository = $this->getRepository($notFoundEntity);

        $filter = new PrinterEntityFilter($repository);
        $data = $filter->filter($data, $someKeyName);

        $this->assertEquals(null, $data[$someKeyName]);
    }

    private function getRepository($entity)
    {
        $repository = $this->getMock(
            '\Jimdo\JimkanbanBundle\Entity\PrinterRepository',
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
