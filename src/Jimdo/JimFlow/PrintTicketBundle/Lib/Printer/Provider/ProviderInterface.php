<?php
namespace  Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider;

interface ProviderInterface
{
    /**
     * @abstract
     * @return \Jimdo\PrintTicketBundle\Lib\Printer\Config[]
     */
    public function getPrinters();
}
