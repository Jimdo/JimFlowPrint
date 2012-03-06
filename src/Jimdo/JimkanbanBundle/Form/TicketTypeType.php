<?php

namespace Jimdo\JimkanbanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TicketTypeType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'label' => 'Name'
                ))
                ->add('textColor', 'text', array(
                    'label' => 'Text Color'
                ))
                ->add('backgroundColor', 'text', array(
                    'label' => 'Background Color'
                ))
                ->add('isBackgroundFilled', 'checkbox', array(
                    'label' => 'Fill entire background'
                ))
        ;
    }

    public function getName() {
        return 'jimdo_jimkanbanbundle_tickettypetype';
    }

}
