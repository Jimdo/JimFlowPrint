<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

class PrintController extends Controller
{
    public function printticketAction(Request $request)
    {
        $data = $request->request->all();
        $response = $this->forward('JimdoJimFlowPrintTicketBundle:TemplateView:ticketprint', array($data));

        return $this->doPrint($response->getContent(), $request);
    }

    public function printstoryAction(Request $request)
    {
        $data = $request->request->all();
        $response = $this->forward('JimdoJimFlowPrintTicketBundle:TemplateView:storyprint', array($data));

        return $this->doPrint($response->getContent(), $request);
    }

    private function doPrint($data, Request $request)
    {

        $this->assertFormValid($request);

        $templateDataService = $this->container->get('jimdo.template_data_view');
        $templateData = $templateDataService->getTemplateData();

        $printingService = $this->get('jimdo.gcp_printing');
        $response = new Response();
        $response->setStatusCode(200);

        try {
            $printingService->doPrint($templateData['printer'], $data);

        } catch (\InvalidArgumentException $e) {
            $response->setStatusCode(500);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

    /**
     * @param Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     * @return void
     */
    private function assertFormValid(Request $request)
    {
        $form = $this->createFormBuilder()->getForm();
        $form->bindRequest($request);

        if (!$form->isValid()) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        }
    }
}
