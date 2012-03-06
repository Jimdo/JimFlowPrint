<?php

namespace Jimdo\JimkanbanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Jimdo\JimkanbanBundle\Form\TicketTypeType;
use Jimdo\JimkanbanBundle\Form\TicketTypesType;
use Jimdo\JimkanbanBundle\Entity\TicketType;


class TicketTypeController extends Controller 
{

    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function editAction() {
        
        $ticketType = new TicketType();
        $ticketType2 = new TicketType();
        $ticketType3 = new TicketType();
        
        $ticketTypes = array (
            $ticketType,
            $ticketType2,
            $ticketType3           
        );
        
        $form = $this->createForm(new TicketTypesType(), array('ticket_types' => $ticketTypes));

        return array('form' => $form->createView());
    }

}
