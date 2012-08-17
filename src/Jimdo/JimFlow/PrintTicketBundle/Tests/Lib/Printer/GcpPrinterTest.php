<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Printer;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\GcpPrinter;

class GcpPrinterTest extends \PHPUnit_Framework_TestCase
{
    const SOME_PRINTER_ID = 1;

    /**
     * @test
     */
    public function itShouldUseGcpClientToSubmitPrintJob()
    {
        $somePrinterId = self::SOME_PRINTER_ID;
        $someFile = array(
            'content' => 'dd',
            'mime' => 'aa/bb'
        );

        $client = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client', arraY(), array(), '', false);
        $client->expects($this->once())->method('submitPrintJob')->with($somePrinterId, $someFile);

        $printer = new GcpPrinter($client);
        $printer->doPrint($somePrinterId, $someFile);
    }
}
