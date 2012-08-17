<?php
namespace Jimdo\JimkanbanBundle\Lib;
use Jimdo\JimkanbanBundle\Lib\TemplateData;
use Symfony\Component\HttpFoundation\Request;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterChain;
use \Jimdo\JimkanbanBundle\Lib\Printer\Provider\ProviderInterface;

class TemplateDataView extends TemplateData
{

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Printer\Provider\Gcp
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
