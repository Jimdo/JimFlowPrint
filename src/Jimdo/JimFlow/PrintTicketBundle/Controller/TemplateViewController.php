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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ticketAction()
    {
        return $this->renderViewWithGoogleAccountCheck('JimdoJimFlowPrintTicketBundle:Template:ticket.html.twig');
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
        return $this->renderViewWithGoogleAccountCheck('JimdoJimFlowPrintTicketBundle:Template:story.html.twig');
    }

    public function storyprintAction()
    {
        $templateData = $this->getTemplateData(false);

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Template:print-story.html.twig',
            $templateData
        );
    }

    private function renderViewWithGoogleAccountCheck($view)
    {
        try {
            $templateData = $this->getTemplateData();

            $templateData = array_merge(
                array('isAdmin' => $this->get('security.context')->isGranted('ROLE_ADMIN')),
                array('form' => $this->getFormView()),
                $templateData
            );

            return $this->render(
                $view,
                $templateData
            );

        } catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('notice', 'There was a problem connecting to Google. Have you connected your account?');
            return $this->redirect($this->generateUrl('tickettype_list'));
        }
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
