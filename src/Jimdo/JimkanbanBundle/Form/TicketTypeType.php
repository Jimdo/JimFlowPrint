<?php

namespace Jimdo\JimkanbanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TicketTypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('textColor')
            ->add('backgroundColor')
            ->add('isBackgroundFilled', 'checkbox')
        ;
    }

    public function getName()
    {
        return 'jimdo_jimkanbanbundle_tickettypetype';
    }
}
