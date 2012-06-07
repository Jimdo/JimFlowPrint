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
        $data = $request->request->all();
        $response = $this->forward('JimdoJimkanbanBundle:TemplateView:ticketprint', array($data));
        return $this->doPrint($response->getContent());
    }

    public function printstoryAction(Request $request)
    {
        $data = $request->request->all();
        $response = $this->forward('JimdoJimkanbanBundle:TemplateView:storyprint', array($data));
        return $this->doPrint($response->getContent());
    }

    private function doPrint($data)
    {
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

}
