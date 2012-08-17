<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Filter;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterChain;

class FilterChainTest extends \PHPUnit_Framework_TestCase
{
    const SOME_KEY = 'SOME_KEY';
    private $someData = array();

    /**
     * @test
     */
    public function itShouldCallRegisteredFiltersWithGivenKey()
    {
        $someKey = self::SOME_KEY;
        $someData = $this->someData;

        $filterMock = $this->getMock(
            '\Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates\TicketTypeEntityFilter',
            array(),
            array(),
            '',
            false
        );
        $filterMock->expects($this->once())
                ->method('filter')
                ->with($this->equalTo($someData), $this->equalTo($someKey));

        $filterChain = new FilterChain();
        $filterChain->add($filterMock, self::SOME_KEY);
        $filterChain->filter($someData);
    }

    /**
     * @test
     */
    public function itShouldReturnTheArrayFilteredByFilters()
    {
        $someKey = self::SOME_KEY;
        $someData = $this->someData;
        $someFilerResult = array($someKey => 'foo');

        $filterMock = $this->getFilterMock();

        $filterMock->expects($this->once())
                ->method('filter')
                ->will($this->returnValue($someFilerResult));

        $filterChain = new FilterChain();
        $filterChain->add($filterMock, self::SOME_KEY);
        $this->assertEquals($someFilerResult, $filterChain->filter($someData));
    }

    private function getFilterMock()
    {
        $filterMock = $this->getMock(
            '\Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates\TicketTypeEntityFilter',
            array(),
            array(),
            '',
            false
        );

        return $filterMock;
    }
}
