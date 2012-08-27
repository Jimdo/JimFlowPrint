<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Util;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\ProviderInterface;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;
 
class NameSortAscending implements ProviderInterface
{

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Printer\Provider\ProviderInterface
     */
    private $provider;

    /**
     * @param \Jimdo\PrintTicketBundle\Lib\Printer\Provider\ProviderInterface $provider
     */
    public function __construct($provider) {
        $this->provider = $provider;
    }

    /**
     * @return \Jimdo\PrintTicketBundle\Lib\Printer\Config[]
     */
    public function getPrinters()
    {
       return $this->sortAsc();
    }

    /**
     * @return array|\Jimdo\PrintTicketBundle\Lib\Printer\Config[]
     */
    private function sortAsc()
    {
        $printers = $this->provider->getPrinters();

        usort($printers, array($this, "sort"));
        return $printers;
    }


    /**
     * @param \Jimdo\PrintTicketBundle\Lib\Printer\Config $a
     * @param \Jimdo\PrintTicketBundle\Lib\Printer\Config $b
     * @return int
     */
    private function sort(Config $a, Config $b)
    {
        return strcasecmp($a->getName(), $b->getName());
    }
}
