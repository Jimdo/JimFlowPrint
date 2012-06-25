<?php
namespace Jimdo\JimkanbanBundle\Tests\Lib\Printer;
use \Jimdo\JimkanbanBundle\Lib\Printer\PrintingService;
class PrintingServiceTest extends \PHPUnit_Framework_TestCase
{
    const SOME_PRINTER_ID = 1;
    const SOME_HTML = '<a></a>';
    const SOME_PDF_OUTPUT = 'fsdsfs';
    const SOME_MIME_TYPE = 'application/yourmama';

    /**
     * @test
     */
    public function itShouldPrintUsingTheGivenPrinterUsingExpectedParams()
    {
        $somePrinterId = self::SOME_PRINTER_ID;
        $someHTML = self::SOME_HTML;
        $somePdfOutput = self::SOME_PDF_OUTPUT;
        $someMime = self::SOME_MIME_TYPE;
        $expectedParam = array(
            'content' => $somePdfOutput,
            'mime' => $someMime
        );

        $fileInfo = $this->getMock('\finfo', array(), array(), '', false);
        $printer = $this->getMock('\Jimdo\JimkanbanBundle\Lib\Printer\GcpPrinter', array(), array(), '', false);
        $generatorService = $this->getMock('\Jimdo\JimkanbanBundle\Lib\Generator\Service', array(), array(), '', false);

        $fileInfo->expects($this->once())->method('buffer')->will($this->returnValue($someMime));

        $generatorService->expects($this->once())->method('generateFromHtml')->will($this->returnValue($somePdfOutput));

        $printer->expects($this->once())->method('doPrint')->with($somePrinterId, $expectedParam);

        $printService = new PrintingService($printer, $generatorService, $fileInfo);
        $printService->doPrint($somePrinterId, $someHTML);
    }

}
