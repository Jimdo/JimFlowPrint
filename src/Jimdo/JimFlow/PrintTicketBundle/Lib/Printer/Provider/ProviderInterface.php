<?php
namespace  Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider;

use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

interface ProviderInterface
{
    /**
     * @abstract
     * @return Config
     */
    public function getPrinters();
}
