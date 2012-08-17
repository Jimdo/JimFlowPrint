<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Generator;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Generator\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    const SOME_HTML = '<div></div>';

    const SOME_PDF_OUTPUT = 'sadsad';

    /**
     * @test
     */
    public function itShouldCallTheGivenGeneratorWithHtmlAndOptions()
    {
        $someHTML = self::SOME_HTML;
        $someOptions = array('foo' => 'bar');
        $somePdfOutput = self::SOME_PDF_OUTPUT;

        $generator = $this->getMock('\Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator', array(), array(), '', false);
        $generator->expects($this->once())->method('getOutputFromHtml')->with($someHTML, $someOptions)->will($this->returnValue($somePdfOutput));

        $generatorService = new Service($generator, $someOptions);

        $this->assertEquals($somePdfOutput, $generatorService->generateFromHtml($someHTML));
    }

}
