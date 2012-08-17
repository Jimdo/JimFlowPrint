<?php
namespace  Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

class GcpWithoutDocs extends Gcp implements ProviderInterface
{
    /**
     * @return \Jimdo\PrintTicketBundle\Lib\Printer\Config[]
     */
    public function getPrinters()
    {
        $printers = parent::getPrinters();
        $availablePrinters = array();

        foreach ($printers as $printer) {
            if ($printer->getId() != '__google__docs') {
                $availablePrinters[] = $printer;
            }
        }

        return $availablePrinters;
    }
}
