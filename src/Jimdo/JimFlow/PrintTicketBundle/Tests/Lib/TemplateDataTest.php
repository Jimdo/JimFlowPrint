<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\TemplateData;

class TemplateDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnTheFilteredRequestData()
    {
        $someDate = '12-06-2013';
        $someFilteredDate = '12.06.2013';

        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request', array(), array(), '', false);
        $filterChain = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterChain' , array(), array(), '', false);

        $request->expects($this->at(0))->method('get')->with('created')->will($this->returnValue($someDate));
        $filterChain->expects($this->any())->method('filter')->will($this->returnValue(array('created' => $someFilteredDate)));

        $templateData = new TemplateData($request, $filterChain);

        $this->assertEquals($templateData->getTemplateData(), array('created' => $someFilteredDate));
    }

}
