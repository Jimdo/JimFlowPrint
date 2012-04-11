<?php
namespace Jimdo\JimkanbanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jimdo\JimkanbanBundle\Lib\TemplateData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



/**
 * TicketType controller.
 *
 */
class TemplateViewController extends Controller
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function ticketAction(Request $request)
    {

        $mail =  $this->container->get('jimdo.email_printer');
        $mail->doPrint('ddd');
        $templateDataService = $this->container->get('jimdo.template_data_view');
        $templateData = $templateDataService->getTemplateData();

        return $this->render(
            'JimdoJimkanbanBundle:Template:ticket.html.twig',
            $templateData
        );
    }


    public function printticketAction(Request $request)
    {


        $httpClient = $this->container->get('buzz');
        $html = $httpClient->get('http://jimdo.com')->getContent();

        return new Response(
            $this->get('knp_snappy.image')->getOutputFromHtml($html),
            200,
            array(
                 'Content-Type' => 'image/jpg',
                 'Content-Disposition' => 'filename="image.jpg"'
            )
        );
    }


    private function getViewData(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $printer = $em->getRepository('JimdoJimkanbanBundle:Printer')->findAll();

        $data = array(
            'created' => $request->get('created'),
            'id' => $request->get('id'),
            'title' => $request->get('title'),
            'reporter' => $request->get('reporter'),
            'type' => $request->get('type'),
            'printers' => $printer
        );

        $filterChain = $this->container->get('jimdo.ticket_filter_chain');
        return $filterChain->filter($data);
    }
}