<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Printer\Provider\Util;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Util\NameSortAscending;

class NameSortAscendingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnPrintersOrderedByNameAscending()
    {
        $someUnsortedData = array(
            new Config('1', 'Zett', true),
            new Config('2', 'Arnold', true),
            new Config('3', 'Toll', true)
        );

        $expectedSortedData = array(
            new Config('2', 'Arnold', true),
            new Config('3', 'Toll', true),
            new Config('1', 'Zett', true),
        );

        $provider = $this->getMock('Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\ProviderInterface', array(), array(), '', false);
        $provider->expects($this->once())->method('getPrinters')->will($this->returnValue($someUnsortedData));

        $nameSort = new NameSortAscending($provider);

        $this->assertEquals($expectedSortedData, $nameSort->getPrinters());


    }

}
