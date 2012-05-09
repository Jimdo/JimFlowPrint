<?php
namespace Jimdo\JimkanbanBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

class PrintController extends Controller
{
    public function printticketAction(Request $request)
    {
        $data = array();
        parse_str($request->getQueryString(), $data);
        $queryString = http_build_query($data);

        $templateDataService = $this->container->get('jimdo.template_data_view');
        $templateData = $templateDataService->getTemplateData();

        $printingService = $this->get('jimdo.gcp_printing');
        $printingService->doPrint($templateData['printer'], $this->generateUrl('template_print_view', $data, true));

        $pdf = $this->container->get('jimdo.pdf_generator');
        //$f = $pdf->generateFromUrl($this->generateUrl('template_print_view', $data, true));

        //return new Response($f, 200, array('Content-Type' => 'application/pdf'));

        return new Response('{"message": "ok"}' , 200);
    }

}
