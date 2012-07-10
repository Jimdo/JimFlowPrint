<?php
namespace Jimdo\JimkanbanBundle\Lib\Printer\Provider\Util;
use Jimdo\JimkanbanBundle\Lib\Printer\Provider\ProviderInterface;
use Jimdo\JimkanbanBundle\Lib\Printer\Config;
 
class NameSortAscending implements ProviderInterface
{

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Printer\Provider\ProviderInterface
     */
    private $provider;

    /**
     * @param \Jimdo\JimkanbanBundle\Lib\Printer\Provider\ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider) {
        $this->provider = $provider;
    }

    /**
     * @return \Jimdo\JimkanbanBundle\Lib\Printer\Config[]
     */
    public function getPrinters()
    {
       return $this->sortAsc();
    }

    /**
     * @return array|\Jimdo\JimkanbanBundle\Lib\Printer\Config[]
     */
    private function sortAsc()
    {
        $printers = $this->provider->getPrinters();

        usort($printers, array($this, "sort"));
        return $printers;
    }


    /**
     * @param \Jimdo\JimkanbanBundle\Lib\Printer\Config $a
     * @param \Jimdo\JimkanbanBundle\Lib\Printer\Config $b
     * @return int
     */
    private function sort(Config $a, Config $b)
    {
        return strcasecmp($a->getName(), $b->getName());
    }
}
