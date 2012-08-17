<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib;
use Symfony\Component\HttpFoundation\Request;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\FilterChain;

class TemplateData
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Filter\FilterChain
     */
    private $filterChain;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param FilterChain $filterChain
     */
    public function __construct(Request $request, FilterChain $filterChain)
    {
        $this->request = $request;
        $this->filterChain = $filterChain;
    }

    /**
     * @return array
     */
    public function getTemplateData()
    {
        return $this->filterChain->filter($this->getData());
    }

    /**
     * @return array
     */
    protected function getData()
    {
        $request = $this->request;

        return array(
            'created' => $request->get('created'),
            'id' => $request->get('id'),
            'title' => $request->get('title'),
            'reporter' => $request->get('reporter'),
            'type' => $request->get('type'),
            'printer' => $request->get('printer')
        );
    }
}
