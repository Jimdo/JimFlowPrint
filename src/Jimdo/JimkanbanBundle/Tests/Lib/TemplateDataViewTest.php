<?php
namespace Jimdo\JimkanbanBundle\Tests\Lib;
use \Jimdo\JimkanbanBundle\Lib\TemplateDataView;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterChain;
 
class TemplateDataViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldContainPrintersReturnedByGcpClient()
    {
        $somePrinterData = array('foo' => 'bar');

        $gcpClient = $this->getMock('\Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient', array(), array(), '', false);
        $gcpClient->expects($this->once())->method('getPrinterList')->will($this->returnValue($somePrinterData));

        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request', array(), array(), '', false);


        $templateData = new TemplateDataView($request, new FilterChain(), $gcpClient);
        $data = $templateData->getTemplateData();

        $this->assertEquals($data['printers'], $somePrinterData);
    }

}
