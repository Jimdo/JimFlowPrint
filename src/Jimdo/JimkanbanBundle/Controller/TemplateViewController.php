<?php
namespace Jimdo\JimkanbanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jimdo\JimkanbanBundle\Lib\TemplateData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Jimdo\JimkanbanBundle\Entity\PrinterRepository;



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
        $templateDataService = $this->container->get('jimdo.template_data_view');
        $templateData = $templateDataService->getTemplateData();

        return $this->render(
            'JimdoJimkanbanBundle:Template:ticket.html.twig',
            $templateData
        );
    }
}