<?php
namespace  Jimdo\JimFlow\PrintTicketBundle\Lib\Printer;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\PrinterInterface;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client;

class GcpPrinter implements PrinterInterface
{
    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Google\GCP\Client
     */
    private $gcpClient;

    /**
     * @param \Jimdo\PrintTicketBundle\Lib\Google\GCP\Client $gcpClient
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
