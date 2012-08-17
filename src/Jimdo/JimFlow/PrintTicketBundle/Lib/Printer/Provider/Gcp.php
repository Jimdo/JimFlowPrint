<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

class Gcp implements ProviderInterface
{

    const STATUS_ONLINE = 'ONLINE';

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Google\GCP\Client
     */
    private $gcpClient;

    public function __construct(Client $gcpClient)
    {
        $this->gcpClient = $gcpClient;
    }

    /**
     * @return \Jimdo\PrintTicketBundle\Lib\Printer\Config[]
     */
    public function getPrinters()
    {
        $printers = array();

        foreach ($this->gcpClient->getPrinterList() as $printer) {
            $printers[] = new Config($printer['id'], $printer['displayName'], $this->isAvailable($printer['connectionStatus']));
        }

        return $printers;
    }

    /**
     * @param $printerStatus
     * @return bool
     */
    private function isAvailable($printerStatus)
    {
        return $printerStatus === self::STATUS_ONLINE;
    }
}
