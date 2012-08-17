<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

class PrintButtonsController extends Controller
{
    public function showAction(Request $request)
    {
        $templateDataService = $this->container->get('jimdo.template_data_view_printers');
        $templateData = $templateDataService->getTemplateData();

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:External:print-buttons.html.twig',
            array_merge($templateData, array('form' => $this->createFormBuilder()->getForm()->createView()))
        );
    }

    public function jsAction(Request $request) {
        $response = new Response();

        $response->setContent($this->renderView('JimdoJimFlowPrintTicketBundle:External:loader.js.html.twig'));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/javascript');

        return $response;
    }


}
