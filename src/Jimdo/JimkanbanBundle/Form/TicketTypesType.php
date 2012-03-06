<?php

namespace Jimdo\JimkanbanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TicketTypesType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('ticket_types', 'collection', array('type' => new TicketTypeType()));
    }

    public function getName()
    {
        return 'jimdo_jimkanbanbundle_tickettypestype';
    }
}
