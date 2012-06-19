<?php
namespace Jimdo\JimkanbanBundle\Lib;
use Jimdo\JimkanbanBundle\Lib\TemplateData;
use Symfony\Component\HttpFoundation\Request;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterChain;
use \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient;

class TemplateDataView extends TemplateData
{

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient
     */
    private $gcpClient;

    public function __construct(Request $request, FilterChain $filterChain, GCPClient $gcpClient)
    {
        parent::__construct($request, $filterChain);
        $this->gcpClient = $gcpClient;
    }

    protected function getData()
    {
        return array_merge(parent::getData(), array('printers' => $this->getPrinters()));
    }

    private function getPrinters()
    {
        return $this->gcpClient->getPrinterList();
    }

}
