<?php
namespace Jimdo\JimkanbanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jimdo\JimkanbanBundle\Entity\TicketType;

/**
 * TicketType controller.
 *
 */
class TemplateController extends Controller
{
    /**
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function indexAction()
    {
        return $this->render(
            'JimdoJimkanbanBundle:Template:note.html.twig'
        );
    }
}