<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jimdo\JimFlow\PrintTicketBundle\Lib\TemplateData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * TicketType controller.
 *
 */
class TemplateViewController extends Controller
{
    /**
     * @param  \Symfony\Component\HttpFoundation\Request           $request
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function ticketAction(Request $request)
    {
        $templateData = $this->getTemplateData();


        $templateData = array_merge(
            array('isAdmin' => $this->get('security.context')->isGranted('ROLE_ADMIN')),
            array('form' => $this->getFormView()),
            $templateData
        );

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Template:ticket.html.twig',
            $templateData
        );
    }

    public function ticketprintAction()
    {
        $templateData = $this->getTemplateData(false);

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Template:print-ticket.html.twig',
            $templateData
        );
    }

    public function storyAction()
    {
        $templateData = array_merge(
            $this->getTemplateData(),
            array(
                'form' => $this->getFormView()
            )
        );

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Template:story.html.twig',
            $templateData
        );
    }

    public function storyprintAction()
    {
        $templateData = $this->getTemplateData(false);

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Template:print-story.html.twig',
            $templateData
        );
    }

    /**
     * @param  bool  $includePrinters
     * @return array
     */
    private function getTemplateData($includePrinters = true)
    {
        $service = 'jimdo.template_data_view';

        if ($includePrinters) {
            $service .= '_printers';
        }

        $templateDataService = $this->container->get($service);
        $templateData = $templateDataService->getTemplateData();

        return $templateData;
    }

    /**
     * Empty form used to render csrf token
     * @return \Symfony\Component\Form\FormView
     */
    private function getFormView()
    {
        return $this->createFormBuilder()->getForm()->createView();
    }
}
