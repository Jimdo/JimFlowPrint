<?php
namespace Jimdo\JimkanbanBundle\Tests\Lib;
use \Jimdo\JimkanbanBundle\Lib\TemplateDataView;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterChain;
use \Jimdo\JimkanbanBundle\Lib\Printer\Provider\Gcp;

class TemplateDataViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldContainPrintersReturnedByPrinterProvider()
    {
        $somePrinterData = array('foo' => 'bar');

        $gcpClient = $this->getMock('\Jimdo\JimkanbanBundle\Lib\Google\GCP\Client', array(), array(), '', false);
        $gcpClient->expects($this->once())->method('getPrinterList')->will($this->returnValue($somePrinterData));

        $provider = new Gcp($gcpClient);

        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request', array(), array(), '', false);

        $templateData = new TemplateDataView($request, new FilterChain(), $provider);
        $data = $templateData->getTemplateData();

        $this->assertEquals($data['printers'], $somePrinterData);
    }

}
