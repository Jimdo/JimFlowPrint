<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\TemplateDataView;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterChain;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Gcp;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

class TemplateDataViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldContainPrintersReturnedByPrinterProvider()
    {
        $somePrinterData = new Config('1', 'foo', true);

        $provider = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Gcp', array(), array(), '', false);
        $provider->expects($this->once())->method('getPrinters')->will($this->returnValue($somePrinterData));

        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request', array(), array(), '', false);

        $templateData = new TemplateDataView($request, new FilterChain(), $provider);
        $data = $templateData->getTemplateData();

        $this->assertEquals($data['printers'], $somePrinterData);
    }

}
