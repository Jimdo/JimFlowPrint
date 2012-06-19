<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer;
use \Jimdo\JimkanbanBundle\Lib\Printer\PrinterInterface;
use \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient;

class GcpPrinter implements PrinterInterface {

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient
     */
    private $gcpClient;

    /**
     * @param \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient $gcpClient
     */
    public function __construct(GCPClient $gcpClient)
    {
        $this->gcpClient = $gcpClient;
    }

    public function doPrint($printerId, array $file)
    {
        $this->gcpClient->submitPrintJob($printerId, $file);
    }
}
