<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer;
use \Jimdo\JimkanbanBundle\Lib\Printer\PrinterInterface;
use \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client;

class GcpPrinter implements PrinterInterface {

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client
     */
    private $gcpClient;

    /**
     * @param \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client $gcpClient
     */
    public function __construct(Client $gcpClient)
    {
        $this->gcpClient = $gcpClient;
    }

    public function doPrint($printerId, array $file)
    {
        $this->gcpClient->submitPrintJob($printerId, $file);
    }
}
