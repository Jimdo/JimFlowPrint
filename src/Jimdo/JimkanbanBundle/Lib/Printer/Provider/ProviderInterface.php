<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer\Provider;

interface ProviderInterface
{
    /**
     * @abstract
     * @return \Jimdo\JimkanbanBundle\Lib\Printer\Config[]
     */
    public function getPrinters();
}
