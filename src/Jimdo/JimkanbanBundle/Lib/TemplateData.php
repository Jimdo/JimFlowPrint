<?php
namespace Jimdo\JimkanbanBundle\Lib;
use Symfony\Component\HttpFoundation\Request;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterChain;

class TemplateData
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Filter\FilterChain
     */
    private $filterChain;

    public function __construct(Request $request, FilterChain $filterChain)
    {
        $this->request = $request;
        $this->filterChain = $filterChain;
    }

    public function getTemplateData()
    {
        return $this->filterChain->filter($this->getData());
    }

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
