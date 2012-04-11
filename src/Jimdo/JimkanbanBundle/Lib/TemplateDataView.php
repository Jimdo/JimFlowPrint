<?php
namespace Jimdo\JimkanbanBundle\Lib;
use Jimdo\JimkanbanBundle\Lib\TemplateData;
use Symfony\Component\HttpFoundation\Request;
use \Jimdo\JimkanbanBundle\Lib\Filter\FilterChain;
use \Jimdo\JimkanbanBundle\Entity\PrinterRepository;
 
class TemplateDataView extends  TemplateData {

   /**
    * @var \Jimdo\JimkanbanBundle\Entity\PrinterRepository
    */
   private $repository;

   public function __construct(Request $request, FilterChain $filterChain, PrinterRepository $repository)
   {
       parent::__construct($request, $filterChain);
       $this->repository = $repository;
   }

    protected function getData() {
        return array_merge(
            parent::getData(),
            array('printers' => $this->getPrinters() )
        );
    }

    private function getPrinters()
    {
        return $this->repository->findAll();
    }

}
