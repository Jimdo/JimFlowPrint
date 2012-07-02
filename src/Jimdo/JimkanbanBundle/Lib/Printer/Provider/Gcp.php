<?php
namespace Jimdo\JimkanbanBundle\Lib\Printer\Provider;
use \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client;
use Jimdo\JimkanbanBundle\Lib\Printer\Config;

class Gcp implements ProviderInterface
{

    const STATUS_ONLINE = 'ONLINE';

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client
     */
    private $gcpClient;

    public function __construct(Client $gcpClient)
    {
        $this->gcpClient = $gcpClient;
    }

    /**
     * @return \Jimdo\JimkanbanBundle\Lib\Printer\Config[]
     */
    public function getPrinters()
    {
        $printers = array();

        foreach ($this->gcpClient->getPrinterList() as $printer) {
            $printers[] = new Config($printer['id'], $printer['name'], $this->isAvailable($printer['connectionStatus']));
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
