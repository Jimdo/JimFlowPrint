<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib;
use Jimdo\JimFlow\PrintTicketBundle\Lib\TemplateData;
use Symfony\Component\HttpFoundation\Request;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterChain;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\ProviderInterface;

class TemplateDataView extends TemplateData
{

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Printer\Provider\Gcp
     */
    private $printerProvider;

    /**
     * @param Request $request
     * @param FilterChain $filterChain
     * @param ProviderInterface $printerProvider
     */
    public function __construct(Request $request, FilterChain $filterChain, ProviderInterface $printerProvider)
    {
        parent::__construct($request, $filterChain);
        $this->printerProvider = $printerProvider;
    }

    /**
     * @return array
     */
    protected function getData()
    {
        return array_merge(parent::getData(), array('printers' => $this->getPrinters()));
    }

    /**
     * @return array
     */
    private function getPrinters()
    {
        return $this->printerProvider->getPrinters();
    }

}
