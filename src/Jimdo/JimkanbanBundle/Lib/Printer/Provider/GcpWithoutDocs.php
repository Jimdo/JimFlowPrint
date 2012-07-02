<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer\Provider;
use \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client;
use Jimdo\JimkanbanBundle\Lib\Printer\Config;

class GcpWithoutDocs extends Gcp implements ProviderInterface
{
    /**
     * @return \Jimdo\JimkanbanBundle\Lib\Printer\Config[]
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
