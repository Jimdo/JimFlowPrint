<?php
namespace Jimdo\JimkanbanBundle\Controller;
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
            'JimdoJimkanbanBundle:External:print-buttons.html.twig',
            array_merge($templateData, array('form' => $this->createFormBuilder()->getForm()->createView()))
        );
    }


}
