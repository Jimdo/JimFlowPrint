<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Controller;
use Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthToken;
use Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthTokenRepository;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

class PrintController extends Controller
{
    public function printticketAction(Request $request)
    {
        $data = $request->request->all();
        $response = $this->forward('JimdoJimFlowPrintTicketBundle:TemplateView:ticketprint', array($data));

        return $this->doPrint($response->getContent(), $request, $data['printer']);
    }

    public function printstoryAction(Request $request)
    {
        $data = $request->request->all();
        $response = $this->forward('JimdoJimFlowPrintTicketBundle:TemplateView:storyprint', array($data));

        return $this->doPrint($response->getContent(), $request, $data['printer']);
    }

    public function printersAction()
    {
        $printerProvider = $this->get('jimdo.printing.provider.gcp.sorted');
        $printers = $printerProvider->getPrinters();

        $printers = array_map(function (Config $printer) {
            return array(
                'id' => $printer->getId(),
                'name' => $printer->getName(),
                'isAvailable' => $printer->isAvailable()
            );
        }, $printers);

        $response = new Response();

        $response->setContent(json_encode($printers));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function doPrint($data, Request $request, $printer)
    {

        //$this->assertFormValid($request);

        $templateDataService = $this->container->get('jimdo.template_data_view');
        $templateData = $templateDataService->getTemplateData();

        $printingService = $this->get('jimdo.gcp_printing');
        $response = new Response();
        $response->setStatusCode(200);

        try {
            $printingService->doPrint($printer, $data);

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
        $form->handleRequest($request);

        if (!$form->isValid()) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        }
    }
}
